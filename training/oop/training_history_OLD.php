<?php
/* training/oop/training_history.php */
// session_start();
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../../config/permission.php';

$db = db();
$db->set_charset('utf8mb4');

$user_level = isset($_SESSION['user_instrument']) ? (int)$_SESSION['user_instrument'] : 0;
$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$user_dept = isset($_SESSION['user_department']) ? $_SESSION['user_department'] : '';

// เช็คว่าเป็นการเรียกดูหน้าเต็มผ่าน tid หรือไม่
$is_full_page = isset($_GET['tid']);

// 1. กำหนดจำนวนแถวต่อหน้า
$limit = 7; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// 2. Query นับจำนวนแถวทั้งหมด (เพื่อเอาไปทำปุ่มเปลี่ยนหน้า)
$sql_count = "SELECT COUNT(*) AS total FROM instrument_training";
$res_count = $db->query($sql_count);
$total_rows = $res_count->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// 3. Query ดึงข้อมูลโดยใส่ LIMIT และ OFFSET
// (ปรับ SQL เดิมของนายที่มี GROUP_CONCAT)
$sql = "SELECT t.*, 
               GROUP_CONCAT(m.atm_model_name SEPARATOR ', ') AS instruments 
        FROM instrument_training t 
        LEFT JOIN instrument_training_items ti ON t.training_id = ti.training_id 
        LEFT JOIN automate_model m ON ti.instrument_id = m.atm_model_id 
        GROUP BY t.training_id 
        ORDER BY t.training_id DESC 
        LIMIT $limit OFFSET $offset";

$res = $db->query($sql);
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>Automate Guide</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>assets/imgs/logo/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= TRAIN_CSS_URL ?>training_history.css?v=<?= time() ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #2c3e50;">
                <i class="bi bi-clock-history me-2" style="color: var(--primary-color);"></i> 
                <?= $is_full_page ? 'รายละเอียดการเทรน' : 'ประวัติการเทรน' ?>
            </h2>
            <!-- <p class="text-muted"><?= $is_full_page ? 'ตรวจสอบข้อมูลและกดยืนยันผลการเทรน' : 'คลิกที่แถวเพื่อดูรายละเอียด หรือคลิกไอคอนลูกศรเพื่อขยายหน้าจอ' ?></p> -->
        </div>
        <a href="<?= BASE_URL ?>?act=manual_guide" class="btn btn-outline-dark btn-sm rounded-pill shadow-sm">
            <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
        </a>
    </div>

    <?php if ($is_full_page): ?>
        <div class="container py-2"> 
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
                <div id="full_page_content">
                    <div class="text-center p-5">
                        <div class="spinner-border text-warning" role="status"></div>
                        <p class="mt-2 text-muted">กำลังโหลดรายละเอียด...</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                // โหลดไฟล์ Model โดยส่งโหมด full เพื่อให้มีปุ่มกดยืนยันและ Padding ที่กว้างขึ้น
                $('#full_page_content').load('?act=update_training_detail&mode=full&training_id=<?= (int)$_GET['tid'] ?>');
            });
        </script>

    <?php else: ?>
        <div class="card card-custom shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 35%">หัวข้อการเทรน</th>
                                <th style="width: 30%">เครื่องตรวจ</th>
                                <th style="width: 15%">สถานที่</th>
                                <th style="width: 15%">วัน-เวลา</th>
                                <th style="width: 5%" class="text-center">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT t.*, GROUP_CONCAT(m.atm_model_name SEPARATOR ', ') AS instruments, 
                                    GROUP_CONCAT(m.atm_model_id SEPARATOR ',') AS ins_id_list 
                                FROM instrument_training t 
                                LEFT JOIN instrument_training_items ti ON t.training_id = ti.training_id 
                                LEFT JOIN automate_model m ON ti.instrument_id = m.atm_model_id 
                                GROUP BY t.training_id 
                                ORDER BY t.training_id DESC
                                LIMIT $limit OFFSET $offset";   // ← เอา comment ออก
                        $res = $db->query($sql);
                            $res = $db->query($sql);
                            if ($res && $res->num_rows > 0): 
                                while($row = $res->fetch_assoc()): ?>
                                <tr onclick="window.location.href='?act=training_history&tid=<?= $row['training_id'] ?>'" style="cursor: pointer;">
                                    <td>
                                        <div class="training-topic fw-bold text-dark" title="<?= htmlspecialchars($row['training_topic']) ?>">
                                            <?= htmlspecialchars($row['training_topic']) ?>
                                            <a href="?act=training_history&tid=<?= $row['training_id'] ?>" 
                                               class="ms-2 text-primary shadow-none" 
                                               onclick="event.stopPropagation();" title="ดูหน้าขยาย">
                                                <i class="bi bi-link-45deg" style="font-size: 0.85rem;"></i>
                                            </a>
                                        </div>
                                        <?php if (!empty($row['training_detail'])): ?>
                                            <div class="text-muted small mt-1">
                                                <i class="bi bi-file-text me-1"></i> 
                                                <?= mb_substr(htmlspecialchars($row['training_detail']), 0, 35) . (strlen($row['training_detail']) > 35 ? '...' : '') ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="instruments-container d-flex flex-wrap gap-1">
                                            <?php foreach(explode(', ', $row['instruments']) as $ins): if(!$ins) continue; ?>
                                                <span class="badge-instrument">
                                                    <i class="bi bi-hdd-stack"></i> <?= htmlspecialchars($ins) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                            <?= htmlspecialchars($row['training_location'] ?: '-') ?>
                                        </div>
                                    </td>
                                     <td>
                                        <div>
                                            <div class="small fw-bold mb-1">
                                                <i class="bi bi-calendar3 me-1 text-muted"></i> 
                                                <?= date('d/m/Y', strtotime($row['training_start'])) ?>
                                            </div>
                                            
                                            <div class="small">
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 py-1">
                                                    <i class="bi bi-clock me-1"></i>
                                                    <?= date('H:i', strtotime($row['training_start'])) ?> - <?= date('H:i', strtotime($row['training_end'])) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        $st = $row['training_status'];
                                        if ($st == 1): ?>
                                            <span class="badge rounded-pill bg-success px-3 py-2 text-white">
                                                <i class="bi bi-check-circle-fill me-1"></i> เสร็จสิ้น
                                            </span>
                                        <?php elseif ($st == 2): ?>
                                            <span class="badge rounded-pill bg-secondary px-3 py-2 text-white">
                                                <i class="bi bi-x-circle-fill me-1"></i> ยกเลิก
                                            </span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                                <i class="bi bi-hourglass-split me-1"></i> ดำเนินการ
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; else: ?>
                                <tr><td colspan="5" class="text-center p-5 text-muted"><i class="bi bi-calendar-x fs-2 d-block mb-2"></i>ไม่พบประวัติการเทรน</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>   
            </div>
        </div>

        
        <!-- แบ่งหน้า -->
            <?php if ($total_pages > 1): ?>
            <div class="d-flex flex-column align-items-center mt-3 px-3 pb-3">
                <div class="text-muted small mb-2">
                    แสดง <?= number_format($offset + 1) ?>–<?= number_format(min($offset + $limit, $total_rows)) ?>
                    จาก <?= number_format($total_rows) ?> รายการ
                </div>
                <nav>
                    <ul class="pagination pagination-sm justify-content-center mb-0">

                        <!-- ปุ่ม Previous -->
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link shadow-sm mx-1 rounded-3" href="?act=training_history&page=<?= $page - 1 ?>">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        <?php
                        // Smart window: 1 … 4 5 [6] 7 8 … 20
                        $window = 2;
                        $prev = null;
                        for ($i = 1; $i <= $total_pages; $i++):
                            $show = ($i == 1 || $i == $total_pages || abs($i - $page) <= $window);
                            if (!$show) {
                                if ($prev !== null && $prev !== '...') {
                                    echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                                    $prev = '...';
                                }
                                continue;
                            }
                        ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                <a class="page-link shadow-sm mx-1 rounded-3" href="?act=training_history&page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php $prev = $i; endfor; ?>

                        <!-- ปุ่ม Next -->
                        <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                            <a class="page-link shadow-sm mx-1 rounded-3" href="?act=training_history&page=<?= $page + 1 ?>">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        <?php endif; ?>
        
    
    </div>
    
    
<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= TRAIN_JS_URL ?>training_history.js?v=<?= time() ?>"></script>

<?php if (isset($_GET['status'])): ?>
    <script>
        $(document).ready(function() {
            const status = "<?= $_GET['status'] ?>";
            if (status === 'update_success') {
                Swal.fire({ icon: 'success', title: 'บันทึกสำเร็จ', timer: 2000, showConfirmButton: false });
            }
        });
    </script>
<?php endif; ?>

</body>
</html>