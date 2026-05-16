<?php
/* instrument/config/search_manual.php */
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// เช็คสิทธิ์
if (!isset($_SESSION['user_instrument']) || (int)$_SESSION['user_instrument'] < 1) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/helpers.php';

$conn = db();
$conn->set_charset('utf8mb4');

// FIX: เช็คสิทธิ์แก้ไข (checkLevel ≥ 2) แล้วส่งกลับไปใน JSON
// เพื่อให้ JS ฝั่ง renderTable/renderMobile รู้ว่าต้องแสดงปุ่มแก้ไขหรือไม่
$can_edit = (int)$_SESSION['user_instrument'] >= 2;

$kw          = trim($_GET['kw'] ?? '');
$category_id = (int)($_GET['category_id'] ?? 0);
$status_id   = (int)($_GET['status_id'] ?? 0);
$page        = max(1, (int)($_GET['page'] ?? 1));
$limit       = 10;
$offset      = ($page - 1) * $limit;

// --- WHERE ---
$where  = ["1=1"];
$params = [];
$types  = "";

if ($kw !== '') {
    $where[]  = "m.atm_model_name LIKE ?";
    $params[] = "%$kw%";
    $types   .= "s";
}
if ($category_id > 0) {
    $where[]  = "m.ref_atm_category_id = ?";
    $params[] = $category_id;
    $types   .= "i";
}
if ($status_id > 0) {
    $where[]  = "m.ref_atm_status_manual_id = ?";
    $params[] = $status_id;
    $types   .= "i";
}

$where_sql = implode(" AND ", $where);

// --- COUNT ---
$stmt_count = $conn->prepare("SELECT COUNT(*) FROM instruments i
    JOIN automate_model m ON i.ins_id = m.atm_model_id
    WHERE $where_sql");
if ($params) $stmt_count->bind_param($types, ...$params);
$stmt_count->execute();
$total = (int)$stmt_count->get_result()->fetch_row()[0];

// --- DATA ---
$data_params   = $params;
$data_params[] = $limit;
$data_params[] = $offset;
$data_types    = $types . "ii";

$stmt = $conn->prepare("
    SELECT i.ins_id,
           m.atm_model_name  AS name,
           m.ref_atm_status_manual_id,
           c.atm_category_name,
           t.cable_name,
           i.equipment_image,
           i.updated_at,
           i.created_at
    FROM instruments i
    JOIN automate_model m  ON i.ins_id = m.atm_model_id
    JOIN automate_category c ON m.ref_atm_category_id = c.atm_category_id
    LEFT JOIN instrument_cable_types t ON t.cable_id = i.cable_type_id
    WHERE $where_sql
    ORDER BY
        (m.ref_atm_status_manual_id = 1) DESC,
        GREATEST(COALESCE(i.updated_at,'1000-01-01'), COALESCE(m.atm_model_updatedAt,'1000-01-01')) DESC,
        i.ins_id DESC
    LIMIT ? OFFSET ?
");
$stmt->bind_param($data_types, ...$data_params);
$stmt->execute();
$res = $stmt->get_result();

$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = [
        'ins_id'                   => (int)$row['ins_id'],
        'name'                     => $row['name'],
        'ref_atm_status_manual_id' => (int)$row['ref_atm_status_manual_id'],
        'atm_category_name'        => $row['atm_category_name'] ?? '—',
        'cable_name'               => $row['cable_name'] ?? '—',
        'equipment_image'          => $row['equipment_image'] ?? '',
        'updated_at'               => $row['updated_at'] ?? $row['created_at'] ?? '',
    ];
}

echo json_encode([
    'total'    => $total,
    'page'     => $page,
    'limit'    => $limit,
    'pages'    => (int)ceil($total / $limit),
    'can_edit' => $can_edit, // FIX: เพิ่ม field นี้เพื่อให้ JS แสดงปุ่มแก้ไขได้ถูกต้อง
    'debug_session' => $_SESSION['user_instrument'] ?? 'NOT SET',
    'data'     => $data,
], JSON_UNESCAPED_UNICODE);