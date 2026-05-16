<?php
/* db/re_images.php */
require __DIR__ . '/db.php';
$conn = db(); 
$conn->set_charset('utf8mb4');

function fail($msg, $code=400){ 
    http_response_code($code); 
    exit($msg); 
}

// รับค่าจาก POST
$instrument_id = isset($_POST['instrument_id']) ? (int)$_POST['instrument_id'] : 0;
$type          = $_POST['type'] ?? '';
$order_raw     = $_POST['order'] ?? null;

if ($instrument_id <= 0) fail('ไม่พบรหัสเครื่องตรวจ (instrument_id)');
if (!in_array($type, ['setup', 'run'])) fail('ประเภทข้อมูลไม่ถูกต้อง');
if (empty($order_raw)) fail('ไม่พบข้อมูลลำดับภาพ');

// แปลงค่า order จาก String "15,20,18" ให้เป็น Array [15, 20, 18]
$ids = explode(',', $order_raw);
$ids = array_map('intval', $ids);
$ids = array_filter($ids, fn($n) => $n > 0);

// กำหนดชื่อตารางและ Primary Key
if ($type === 'setup') {
    $table = 'instrument_setup_images';
    $pk = 'setup_id';
} else {
    $table = 'instrument_run_images';
    $pk = 'run_id';
}

$sql = "UPDATE $table SET sort_order = ? WHERE $pk = ? AND instrument_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) fail('เตรียมคำสั่ง SQL ผิดพลาด: ' . $conn->error);

$conn->begin_transaction();
try {
    foreach ($ids as $index => $id) {
        $new_order = $index + 1; // ลำดับเริ่มจาก 1
        $stmt->bind_param("iii", $new_order, $id, $instrument_id);
        $stmt->execute();
    }
    $conn->commit();
    echo "OK";
} catch (Exception $e) {
    $conn->rollback();
    fail('บันทึกไม่สำเร็จ: ' . $e->getMessage());
}