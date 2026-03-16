<?php
session_start();
$ins_id = (int)($_GET['id'] ?? 0);

// if (!isset($_SESSION['user_instrument']) || $_SESSION['user_instrument'] != "1") { 
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
// require_once __DIR__ . '/../config/check_permission.php';

$connpeuy = db();
$connpeuy->set_charset('utf8mb4');

// ---------- 1) รับพารามิเตอร์ค้นหา, การแบ่งหน้า และการเรียงลำดับ ----------
$kw          = isset($_GET['kw']) ? trim($_GET['kw']) : '';
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$sort        = $_GET['sort'] ?? 'desc'; 
$sort_order  = ($sort === 'asc') ? 'ASC' : 'DESC';

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
            (i.updated_at IS NULL) ASC, -- NULL อยู่ล่างสุด
            i.updated_at $sort_order
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
      <h1 class="h3 mb-0 fw-bold">
        <!-- <a href="/xct/alt/instrument?act=old" class="bi bi-list-stars me-2 text-primary" title="คู่มือเดิม"></a> -->
          คู่มือเครื่องตรวจ</h1>
        
          <a href="?act=train" class="col-4 col-md-3 btn btn-warning shadow-sm fw-bold">
                <i class="bi bi-calendar-plus me-1"></i> นัดหมายการเทรน
          </a>
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
            <div class="col-8 col-md-4">
                <select name="category_id" class="form-select">
                    <option value="0">ทุกหมวดหมู่</option>
                    <?php foreach ($cats as $c): ?>
                        <option value="<?= $c['categories_id'] ?>" <?= ($category_id == $c['categories_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-4 col-md-3">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i></button>
            </div>
        </div>
    </form>


    <div class="d-flex justify-content-between align-items-center mb-3">
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
    </div>

    

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
                  <td class="text-center">
                    <?php if ($row['ref_atm_status_manual_id'] == 1): ?>
                        <i class="bi bi-check-circle-fill text-success fs-4" title="พร้อมใช้งาน"></i>
                    <?php else: ?>
                        <i class="bi bi-check-circle-fill text-secondary opacity-25 fs-4" title="ไม่พร้อมใช้งาน"></i>
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
                            <!-- สิทธิ์การใช้งานหน้าเว็บ -->
                            
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=basic"><i class="bi bi-pencil-square text-warning me-2"></i>แก้ไขข้อมูล</a></li>
                            <li><a class="dropdown-item" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=upload"><i class="bi bi-images text-success me-2"></i>อัปโหลดภาพ</a></li>
                            <li><a class="dropdown-item" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=sort"><i class="bi bi-arrow-down-up text-info me-2"></i>ลบเเละจัดลำดับภาพ</a></li>
                            
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
                <div class="card card-instrument mb-3 shadow-sm border-0" 
                     style="position: relative;">
                    
                    <div class="row g-0">
                        <div class="col-4">
                            <img src="<?= img_src($row['equipment_image']) ?>" 
                                 class="img-fluid h-100 w-100" 
                                 style="object-fit: cover; min-height: 110px;" 
                                 onerror="this.src='<?= BASE_URL ?>assets/imgs/ins_setup/noImage.jpg'">
                        </div>

                        <div class="col-8">
                            <div class="card-body p-2 px-3">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div class="d-flex align-items-center flex-wrap gap-2" style="max-width: 82%;">
                                        <h6 class="fw-bold mb-0 text-dark text-truncate"><?= htmlspecialchars($row['name']) ?></h6>
                                        <i class="bi bi-check-circle-fill <?= ($row['ref_atm_status_manual_id'] == 1) ? 'text-success' : 'text-secondary opacity-25' ?>" style="font-size: 0.9rem;"></i>
                                    </div>

                                    <div class="dropdown" onclick="event.stopPropagation();">
                                        <i class="bi bi-three-dots-vertical text-muted fs-4" 
                                        data-bs-toggle="dropdown" 
                                        data-bs-display="static" 
                                        aria-expanded="false"></i>
                                        <?php if ($can_edit): ?>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2">
                                            <li>
                                                <a class="dropdown-item py-2" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=basic">
                                                    <i class="bi bi-pencil-square me-2 text-warning"></i>แก้ไขข้อมูล
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item py-2" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=upload">
                                                    <i class="bi bi-images me-2 text-success"></i>อัปโหลดภาพ
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item py-2" href="?act=edit&id=<?= $row['ins_id'] ?>&mode=sort">
                                                    <i class="bi bi-sort-numeric-down  text-primary me-2 "></i>ลบและจัดลำดับภาพ
                                                </a>
                                            </li>
                                        </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                

                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill mb-1"><?= htmlspecialchars($row['category_name'] ?: '—') ?></span><br>
                                        <span class="badge badge-soft rounded-pill" style="font-size: 0.7rem;"><?= htmlspecialchars($row['cable_name'] ?: '—') ?></span>
                                    </td>
                                </div>
                                

                                <div class="d-flex justify-content-between align-items-end mt-1">
                                    <small class="text-muted" style="font-size: 0.6rem;">
                                        <i class="bi bi-clock me-1"></i><?= date('d/m/y', strtotime($row['updated_at'] ?? $row['created_at'])) ?>
                                    </small>
                                    <a class="text-primary fw-bold" style="font-size: 0.75rem;" href="?act=view&id=<?= $row['ins_id'] ?>">View <i class="bi bi-chevron-right"></i></a>
                                    
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/manual_guide.js"></script>
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

