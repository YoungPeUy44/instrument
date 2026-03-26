<?php
/* training/oop/training_history.php */
session_start();
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../db/db.php';
// แก้ไข Path ให้ถอย 2 ชั้นไปหา config/permission.php
require_once __DIR__ . '/../../config/permission.php';

$db = db();
$db->set_charset('utf8mb4');

// ❌ ลบส่วน $update_auto ที่เช็คเวลาออก เพื่อให้กดยืนยันเองเท่านั้น

// SQL ดึงข้อมูล - เพิ่ม ins_id_list เพื่อใช้ส่งค่าไปอัปเดตเครื่อง
$sql = "SELECT 
            t.training_id, 
            t.training_topic, 
            t.training_location, 
            t.training_start, 
            t.training_end,
            t.training_detail,
            t.created_at,
            t.created_by,
            t.training_status,
            t.cancel_by, 
            t.cancel_at,
            GROUP_CONCAT(m.atm_model_name SEPARATOR ', ') AS instruments,
            GROUP_CONCAT(m.atm_model_id SEPARATOR ',') AS ins_id_list 
        FROM instrument_training t
        LEFT JOIN instrument_training_items ti ON t.training_id = ti.training_id
        LEFT JOIN automate_model m ON ti.instrument_id = m.atm_model_id
        GROUP BY t.training_id
        ORDER BY t.created_at DESC, t.training_id DESC";

$res = $db->query($sql);
$user_level = isset($_SESSION['user_instrument']) ? (int)$_SESSION['user_instrument'] : 0;
$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ประวัติการเทรนเครื่องตรวจ</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>assets/imgs/logo/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= TRAIN_CSS_URL ?>training_history.css?v=<?= time() ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #2c3e50;">
                <i class="bi bi-clock-history me-2" style="color: var(--primary-color);"></i> ประวัติการเทรน
            </h2>
            <p class="text-muted">คลิกที่แถวเพื่อดูรายละเอียดและกดยืนยันผล</p>
        </div>
        <!-- <a href="?act=manual_guide" class="btn btn-warning-custom">ย้อนกลับ</a> -->

        <a href="?act=manual_guide" class="btn btn-warning-custom rounded-pill">
            <i class="bi bi-arrow-left"></i> 
            <span class="d-none d-md-inline ms-1">ย้อนกลับ</span>
        </a>
    </div>

    <div class="card card-custom shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th style="width: 35%">หัวข้อการเทรน</th>
                            <th style="width: 30%">เครื่องตรวจ</th>
                            <th style="width: 15%">สถานที่</th>
                            <th style="width: 10%">วัน-เวลา</th>
                            <th style="width: 10%" class="text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($res && $res->num_rows > 0): ?>
                            <?php while($row = $res->fetch_assoc()): ?>
                                <tr onclick='showDetail(<?= json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>, <?= $user_level ?>, "<?= $current_user_id ?>")' style="cursor: pointer;">
                                    <td>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($row['training_topic']) ?></div>
                                        <div class="text-muted small">
                                            <i class="bi bi-file-text me-1"></i> 
                                            <?= mb_substr(htmlspecialchars($row['training_detail'] ?: '-'), 0, 40) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="instruments-container">
                                            <?php 
                                            $ins_list = !empty($row['instruments']) ? explode(', ', $row['instruments']) : [];
                                            foreach($ins_list as $ins): ?>
                                                <span class="badge-instrument"><?= htmlspecialchars($ins) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td><small><i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                                <?= htmlspecialchars($row['training_location'] ?: '-') ?></small></td>
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
                                        <?php if ($row['training_status'] == 1): ?>
                                            <span class="badge rounded-pill bg-success px-3 py-2">เสร็จสิ้น</span>
                                        <?php elseif ($row['training_status'] == 2): ?>
                                            <span class="badge rounded-pill bg-secondary px-3 py-2">ยกเลิก</span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">กำลังดำเนินการ</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 p-4" style="background-color: #ffc107;">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-info-circle-fill me-2"></i> รายละเอียดการเทรน</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
            </div>
            <div class="modal-body p-4 p-md-5" id="modalContent"></div>
            <div class="modal-footer border-0 p-4 pt-0 d-flex justify-content-between">
                <div id="cancelBtnArea"></div>
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
<!-- Redirect -->
<?php if (isset($_GET['status']) && $_GET['status'] == 'update_success'): ?>
    <script>
        window.addEventListener('load', () => {
            Swal.fire({
                icon: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                text: 'สถานะเครื่องตรวจถูกปรับเป็น "พร้อม" เรียบร้อยแล้ว',
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['status']) && $_GET['status'] == 'train_success'): ?>
    <script>
        window.addEventListener('load', () => {
            Swal.fire({
                icon: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
    <script>
        window.addEventListener('load', () => {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '<?= htmlspecialchars($_GET['msg'] ?? 'ไม่สามารถดำเนินการได้') ?>',
                confirmButtonText: 'ตกลง'
            });
        });
    </script>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= TRAIN_JS_URL ?>training_history.js?v=<?= time() ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>