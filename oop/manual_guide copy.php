<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. ดึงระบบ Auto-Login สำหรับ Local (ถ้ามีไฟล์แยกให้ require มา)
require_once $_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instrument/config/permission.php';

// 2. เช็คสิทธิ์: ถ้าไม่มี Session หรือ สิทธิ์น้อยกว่า 1 (สิทธิ์ 0) ให้ดีดออก
if (!isset($_SESSION['user_instrument']) || (int)$_SESSION['user_instrument'] < 1) { 
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'จำกัดการเข้าถึง!',
                text: 'คุณไม่มีสิทธิ์ดำเนินการในส่วนนี้ กรุณาติดต่อผู้ดูแลระบบ',
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#ffc107',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // 🔙 ดีดกลับไปหน้า Login หลักของระบบ (ปรับ Path ตามจริง)
                    window.history.back(); 
                }
            });
        });
    </script>";
    exit; 
}
?>

<?php

var_dump($_SESSION);
$ins_id = (int)($_GET['id'] ?? 0);
// require_once __DIR__ . '/../config/permission.php';
// if (!isset($_SESSION['user_instrument']) || $_SESSION['user_instrument'] < "1") { 
//     echo "
//     <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
//     <script>
//         document.addEventListener('DOMContentLoaded', function() {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'จำกัดการเข้าถึง!',
//                 text: 'คุณไม่มีสิทธิ์ดำเนินการในส่วนนี้ กรุณาติดต่อผู้ดูแลระบบ',
//                 confirmButtonText: 'ตกลง',
//                 confirmButtonColor: '#d33',
//             }).then((result) => {
//                 if (result.isConfirmed) {
//                     window.location.href = '../';
//                 }
//             });
//         });
//     </script>";
//     exit; 
// }

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/permission.php';


$connpeuy = db();
$connpeuy->set_charset('utf8mb4');

// ---------- 1) รับพารามิเตอร์ค้นหา, การแบ่งหน้า และการเรียงลำดับ ----------
$kw          = isset($_GET['kw']) ? trim($_GET['kw']) : '';
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$sort        = $_GET['sort'] ?? 'desc'; 
$sort_order  = ($sort === 'asc') ? 'ASC' : 'DESC';
$status_id   = isset($_GET['status_id']) ? (int)$_GET['status_id'] : 0;

$items_per_page = 10; 
$current_page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;
$offset         = ($current_page - 1) * $items_per_page;

// ---------- 2) โหลดตัวเลือกหมวดหมู่ ----------
$cats = [];
$catSql = "SELECT atm_category_id AS categories_id, atm_category_name AS name FROM automate_category ORDER BY atm_category_name";
if ($res = $connpeuy->query($catSql)) {
    while ($row = $res->fetch_assoc()) { $cats[] = $row; }
    $res->free();
}
if ($status_id > 0) {
    $where_clauses[] = "m.ref_atm_status_manual_id = ?";
    $params[] = $status_id;
    $types .= "i";
}

// ---------- 3) สร้าง WHERE Clause ----------
$where_clauses = ["1=1"];
$params = [];
$types  = "";

if ($kw !== '') {
    $where_clauses[] = "m.atm_model_name LIKE ?";
    $params[] = "%$kw%";
    $types .= "s";
}
if ($category_id > 0) {
    $where_clauses[] = "m.ref_atm_category_id = ?";
    $params[] = $category_id;
    $types .= "i";
}
// ⭐ ย้ายมาอยู่ในชุดเดียวกัน
if ($status_id > 0) {
    $where_clauses[] = "m.ref_atm_status_manual_id = ?";
    $params[] = $status_id;
    $types .= "i";
}
$where_sql = implode(" AND ", $where_clauses);

// ---------- 4) คำนวณจำนวนรายการทั้งหมด ----------
$count_sql = "SELECT COUNT(*) FROM instruments i 
              INNER JOIN automate_model m ON i.ins_id = m.atm_model_id 
              WHERE $where_sql";
$stmt_count = $connpeuy->prepare($count_sql);
if (!empty($params)) $stmt_count->bind_param($types, ...$params);
$stmt_count->execute();
$total_items = $stmt_count->get_result()->fetch_row()[0];
$total_pages = ceil($total_items / $items_per_page);

// ---------- 5) ดึงข้อมูลรายการ (Desktop/Mobile) พร้อม Join ตารางสถานะ ----------
$sql = "SELECT i.*, 
               m.atm_model_name AS name, 
               m.ref_atm_status_manual_id, -- ดึง ID สถานะมาจาก automate_model
               c.atm_category_name AS category_name, 
               t.cable_name
        FROM instruments i
        INNER JOIN automate_model m ON i.ins_id = m.atm_model_id
        INNER JOIN automate_category c ON m.ref_atm_category_id = c.atm_category_id
        LEFT JOIN instrument_cable_types t ON t.cable_id = i.cable_type_id
        WHERE $where_sql
       ORDER BY 
            (m.ref_atm_status_manual_id = 1) DESC, -- สถานะ ID=1 จะถูกดันขึ้นบนสุด
            i.updated_at DESC,                    -- ตามด้วยตัวที่เพิ่งอัปเดตล่าสุด
            i.ins_id DESC
        LIMIT ?, ?";

$finalParams = $params;
$finalParams[] = $offset;
$finalParams[] = $items_per_page;
$finalTypes = $types . "ii";

$stmt = $connpeuy->prepare($sql);
if (!$stmt) {
    die("SQL Prepare Error: " . $connpeuy->error . "<br>Query: " . $sql);
}
$stmt->bind_param($finalTypes, ...$finalParams);
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>Automate Guide</title>
  <?php require_once __DIR__ . '/../config/favicon.php'; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/manual_guide.css">
  <style>
      .thumb-md { width: 100px; height: 100px; object-fit: cover; border-radius: 10px; }
      .card-instrument { transition: transform 0.2s; cursor: pointer; }
      .card-instrument:active { transform: scale(0.98); }
  </style>
</head>
<body class="bg-light">
  <div class="container py-4">
    <div class="d-flex align-items-center mb-3">
      <a href="../" class="btn btn-outline-primary me-3 shadow-sm border-2 rounded-3" title="กลับหน้าหลักระบบ">
        <i class="bi bi-house-door-fill"></i>
      </a>
      <h1 class="h3 mb-0 fw-bold d-flex justify-content-between align-items-center w-100">
    <span>คู่มือเครื่องตรวจ</span>
    <div class="d-flex gap-2">
        <a href="?act=training_history" class="btn btn-outline-dark shadow-sm rounded-pill px-3 d-flex align-items-center" title="ดูประวัติการเทรน">
            <i class="bi bi-clock-history me-2"></i>
            <span class="small fw-bold">ประวัติการเทรน</span>
        </a>
        <!-- นัดหมายเทรน permission=2 -->
        
            
                <a href="?act=train" class="btn btn-warning shadow-sm rounded-pill px-3 d-flex align-items-center" title="นัดหมายเทรนใหม่">
                    <i class="bi bi-mortarboard-fill me-2"></i>
                    <span class="small fw-bold">นัดหมายเทรน</span>
                </a>
            
        
    </div>
    </h1>
    </div>
    

    <form class="card card-body mb-4 shadow-sm border-0" method="get" action="">
    <input type="hidden" name="act" value="manual_guide">
    <div class="row g-2">
        <div class="col-12 col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="kw" class="form-control border-start-0" 
                       placeholder="ค้นหาชื่อเครื่องตรวจ..." value="<?= htmlspecialchars($kw) ?>">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <select name="category_id" class="form-select">
                <option value="0">ทุกหมวดหมู่</option>
                <?php foreach ($cats as $c): ?>
                    <option value="<?= $c['categories_id'] ?>" <?= ($category_id == $c['categories_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <select name="status_id" class="form-select">
                <option value="0">ทุกสถานะ</option>
                <option value="1" <?= ($status_id == 1) ? 'selected' : '' ?>>พร้อม</option>
                <option value="3" <?= ($status_id == 3) ? 'selected' : '' ?>>รอเทรน</option>
                <option value="2" <?= ($status_id == 2) ? 'selected' : '' ?>>ไม่พร้อม</option>
            </select>
        </div>
        <div class="col-12 col-md-2">
            <button type="submit" class="btn btn-primary w-100 fw-bold">
                <i class="bi bi-funnel-fill me-1"></i> กรอง
            </button>
        </div>
    </div>
    </form>


    <!-- <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-muted small">พบทั้งหมด <?= $total_items ?> รายการ</div>
        <div class="btn-group shadow-sm" role="group">
            <a href="?act=manual_guide&kw=<?= urlencode($kw) ?>&category_id=<?= $category_id ?>&sort=desc" 
               class="btn btn-sm <?= ($sort == 'desc') ? 'btn-dark' : 'btn-outline-dark' ?>">
                <i class="bi bi-sort-down"></i> ใหม่ล่าสุด
            </a>
            <a href="?act=manual_guide&kw=<?= urlencode($kw) ?>&category_id=<?= $category_id ?>&sort=asc" 
               class="btn btn-sm <?= ($sort == 'asc') ? 'btn-dark' : 'btn-outline-dark' ?>">
                <i class="bi bi-sort-up"></i> เก่าสุด
            </a>
        </div>
    </div> -->

    

   <div class="card shadow-sm border-0 mb-4 overflow-hidden d-none d-md-block">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width:100px;">รูปภาพ</th>
              <th>ชื่อเครื่องตรวจ</th>
              <th class="text-center" style="width:100px;">สถานะ</th>
              <th>หมวดหมู่ / ชนิดสาย</th>
              <th class="d-none d-lg-table-cell">อัปเดตล่าสุด</th>
              <th style="width:80px;" class="text-center">จัดการ</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result->num_rows === 0): ?>
              <tr><td colspan="6" class="text-center text-muted p-5">ไม่พบข้อมูลเครื่องตรวจ</td></tr>
            <?php else: ?>
              <?php while($row = $result->fetch_assoc()): ?>
                <tr onclick="window.location='?act=view&id=<?= $row['ins_id'] ?>';">
                  <td style="width:140px;">
                        <div class="table-thumb-box shadow-sm border bg-white">
                            <img src="<?= img_src($row['equipment_image']) ?>" 
                            onerror="this.src='<?= BASE_URL ?>assets/imgs/ins_setup/noImage.jpg'">
                                
                        </div>
                    </td>
                  <td>
                    <div class="fw-bold text-dark mb-0"><?= htmlspecialchars($row['name']) ?></div>
                    <div class="small text-muted">ID: #<?= (int)$row['ins_id'] ?></div>
                  </td>
                  <!-- สถานะคู่มือ -->
                  <td class="text-center">
                    <?php
                        $s_id = $row['ref_atm_status_manual_id'];
                        if ($s_id == 1): ?>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                        <i class="bi bi-check-circle-fill me-1"></i>พร้อม
                        </span>
                        <?php elseif ($s_id == 3): ?>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill text-dark">
                        <i class="bi bi-clock-history me-1"></i>รอเทรน
                        </span>
                        <?php else: ?>
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">
                        <i class="bi bi-dash-circle me-1"></i>ไม่พร้อม
                        </span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span class="badge bg-secondary-subtle text-secondary rounded-pill mb-1"><?= htmlspecialchars($row['category_name'] ?: '—') ?></span><br>
                    <span class="badge badge-soft rounded-pill" style="font-size: 0.7rem;"><?= htmlspecialchars($row['cable_name'] ?: '—') ?></span>
                  </td>
                  <td class="small text-muted d-none d-lg-table-cell">
                    <?= htmlspecialchars($row['updated_at'] ?? $row['created_at']) ?>
                  </td>
                  <td class="text-center" onclick="event.stopPropagation();">
                    <div class="dropdown">
                        <button class="btn btn-light border shadow-sm dropdown-toggle btn-action-menu"
                                type="button"
                                data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <li><a class="dropdown-item" href="?act=view&id=<?= $row['ins_id'] ?>"><i class="bi bi-eye text-primary me-2"></i>ดูรายละเอียด</a></li>
                            
                            <?php if (checkLevel(2)): ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=basic"><i class="bi bi-pencil-square text-warning me-2"></i>แก้ไขข้อมูล</a></li>
                            <li><a class="dropdown-item" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=upload"><i class="bi bi-images text-success me-2"></i>อัปโหลดภาพ</a></li>
                            <li><a class="dropdown-item" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=sort"><i class="bi bi-arrow-down-up text-info me-2"></i>ลบเเละจัดลำดับภาพ</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    
<!-- มือถือ -->
   <div class="d-md-none">
    <?php if ($result->num_rows === 0): ?>
        <div class="text-center p-5 text-muted">ไม่พบข้อมูลเครื่องตรวจ</div>
    <?php else: ?>
        <?php $result->data_seek(0); while($row = $result->fetch_assoc()): ?>
            <div class="card card-instrument mb-3 shadow-sm border-0 overflow-visible"> 
                <div class="row g-0">
                    <div class="col-4">
                        <img src="<?= img_src($row['equipment_image']) ?>" 
                             class="img-fluid h-100 w-100" 
                             style="object-fit: cover; min-height: 120px;" 
                             onerror="this.src='<?= BASE_URL ?>assets/imgs/ins_setup/noImage.jpg'">
                    </div>

                    <div class="col-8">
                        <div class="card-body p-2 px-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div class="text-truncate" style="max-width: 85%;">
                                    <a href="?act=view&id=<?= $row['ins_id'] ?>" class="text-decoration-none">
                                        <h6 class="fw-bold mb-0 text-dark text-truncate"><?= htmlspecialchars($row['name']) ?></h6>
                                    </a>
                                    
                                    <?php 
                                    if (checkLevel(1)): 
                                        $s_id = $row['ref_atm_status_manual_id'];
                                        if ($s_id == 1): ?>
                                            <small class="text-success"><i class="bi bi-check-circle-fill me-1"></i>พร้อม</small>
                                        <?php elseif ($s_id == 3): ?>
                                            <small class="text-warning"><i class="bi bi-hourglass-split me-1"></i>รอเทรน</small>
                                        <?php else: ?>
                                            <small class="text-secondary opacity-50"><i class="bi bi-dash-circle-fill me-1"></i>ไม่พร้อม</small>
                                        <?php endif; 
                                    endif; // จบการเช็คสิทธิ์ 
                                    ?>
                                </div>

                                <div class="dropdown">
                                    <i class="bi bi-three-dots-vertical text-muted fs-4 p-2" 
                                       data-bs-toggle="dropdown" 
                                       data-bs-boundary="viewport"
                                       style="cursor: pointer;"></i>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2">
                                        <li><a class="dropdown-item py-2" href="?act=view&id=<?= $row['ins_id'] ?>"><i class="bi bi-eye text-primary me-2"></i>ดูรายละเอียด</a></li>
                                        <?php if (checkLevel(2)): ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item py-2" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=basic"><i class="bi bi-pencil-square text-warning me-2"></i>แก้ไขข้อมูล</a></li>
                                            <li><a class="dropdown-item py-2" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=upload"><i class="bi bi-images text-success me-2"></i>อัปโหลดภาพ</a></li>
                                            <li><a class="dropdown-item py-2" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=sort"><i class="bi bi-sort-numeric-down text-primary me-2"></i>จัดลำดับภาพ</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-2">
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill" style="font-size: 0.65rem;"><?= htmlspecialchars($row['category_name'] ?: '—') ?></span>
                            </div>

                            <div class="d-flex justify-content-between align-items-end">
                                <small class="text-muted" style="font-size: 0.6rem;">
                                    <i class="bi bi-clock me-1"></i><?= date('d/m/y', strtotime($row['updated_at'] ?? $row['created_at'])) ?>
                                </small>
                                <a href="?act=view&id=<?= $row['ins_id'] ?>" class="text-primary fw-bold text-decoration-none" style="font-size: 0.75rem;">
                                    เปิดดูคู่มือ <i class="bi bi-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

    <nav class="py-3">
        <ul class="pagination pagination-sm justify-content-center mb-0">
            <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link shadow-sm mx-1 rounded-3" href="?act=manual_guide&page=<?= $current_page-1 ?>&kw=<?= urlencode($kw) ?>&category_id=<?= $category_id ?>">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>

            <?php
            $window = 2; // จำนวนเลขหน้ารอบหน้าปัจจุบัน
            for ($p = 1; $p <= $total_pages; $p++) {
                if ($p == 1 || $p == $total_pages || ($p >= $current_page - $window && $p <= $current_page + $window)) {
                    ?>
                    <li class="page-item <?= ($p == $current_page) ? 'active' : '' ?>">
                        <a class="page-link shadow-sm mx-1 rounded-3" href="?act=manual_guide&page=<?= $p ?>&kw=<?= urlencode($kw) ?>&category_id=<?= $category_id ?>">
                            <?= $p ?>
                        </a>
                    </li>
                    <?php
                } 
                elseif ($p == $current_page - $window - 1 || $p == $current_page + $window + 1) {
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
            }
            ?>

            <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link shadow-sm mx-1 rounded-3" href="?act=manual_guide&page=<?= $current_page+1 ?>&kw=<?= urlencode($kw) ?>&category_id=<?= $category_id ?>">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/manual_guide.js"></script>
<?php if (isset($_GET['status']) && $_GET['status'] == 'cancel_success'): ?>
        <script>
            // ใช้ SweetAlert2 สร้าง Toast มุมขวาบน
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end', // มุมขวาบน
                showConfirmButton: false,
                timer: 3000, // แสดง 3 วินาที
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: 'ยกเลิกนัดหมายสำเร็จ!',
                // text: 'ระบบได้คืนค่าสถานะเครื่องตรวจเรียบร้อยแล้ว'
            });

            // ทริค: ลบ status ออกจาก URL เพื่อไม่ให้ Refresh แล้วเด้งซ้ำ
            if (typeof window.history.replaceState === 'function') {
                const url = new URL(window.location);
                url.searchParams.delete('status');
                window.history.replaceState({}, '', url);
            }
        </script>
<?php endif; ?>
<?php if (isset($_GET['status']) && $_GET['status'] == 'no_permission'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // เช็คว่ามี Swal หรือไม่ป้องกัน Error
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'จำกัดการเข้าถึง!',
                    text: 'คุณไม่มีสิทธิ์ดำเนินการในส่วนนี้ กรุณาติดต่อผู้ดูแลระบบ',
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#d33', // สีแดง
                    allowOutsideClick: false,    // บังคับให้ต้องกดปุ่มเท่านั้น ห้ามคลิกข้างนอกเพื่อปิด
                }).then((result) => {
                    if (result.isConfirmed) {
                        // เมื่อกดปุ่ม 'ตกลง' ให้ลบค่า status ออกจาก URL เพื่อความสะอาด
                        if (typeof window.history.replaceState === 'function') {
                            const url = new URL(window.location);
                            url.searchParams.delete('status');
                            window.history.replaceState({}, '', url);
                        }
                    }
                });
            }
        });
    </script>
<?php endif; ?>

<footer class="main-footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <!-- ดึงปีปัจจุบันมาแสดงอัตโนมัติ -->
                <strong>Copyright © 2025 - <?= date('Y') ?></strong>  Support The Operation, Executive Team
            </div>
            <div class="col-md-6 text-center text-md-end text-muted">
                <small>
                    <b>Version</b> 2.0
                </small>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

