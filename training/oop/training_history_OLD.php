<?php
/* training/oop/training_history.php - เพิ่มคอลัมน์ผู้นัดเทรน */
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../db/db.php';

$db = db();
$db->set_charset('utf8mb4');

$update_auto = "UPDATE instrument_training 
                SET training_status = 1 
                WHERE training_end < NOW() AND training_status = 0";
$db->query($update_auto);

// Query ดึงข้อมูลการเทรน - เพิ่ม created_by
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
            GROUP_CONCAT(m.atm_model_name SEPARATOR ', ') AS instruments
        FROM instrument_training t
        LEFT JOIN instrument_training_items ti ON t.training_id = ti.training_id
        LEFT JOIN automate_model m ON ti.instrument_id = m.atm_model_id
        GROUP BY t.training_id
        ORDER BY t.created_at DESC, t.training_id DESC";

$res = $db->query($sql);
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
<style>

</style>
</head>
<body>

<div class="container py-3">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #2c3e50;">
                <i class="bi bi-clock-history me-2" style="color: var(--primary-color);"></i> 
                ประวัติการเทรนเครื่องตรวจ
            </h2>
            <p class="text-muted">ตรวจสอบรายการนัดหมายและเครื่องตรวจที่บันทึกไว้</p>
        </div>
       
        <a href="?act=manual_guide" class="btn btn-warning-custom">
            <i class=" me-2"></i> ย้อนกลับ
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'train_success'): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                    <div>
                        <strong class="fs-6">บันทึกการนัดหมายสำเร็จ!</strong>
                        <p class="mb-0 small">จำนวนเครื่องที่เลือก: <?= htmlspecialchars($_GET['count'] ?? 0) ?> รายการ</p>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php elseif ($_GET['status'] == 'error'): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                    <div>
                        <strong class="fs-6">เกิดข้อผิดพลาด!</strong>
                        <p class="mb-0 small"><?= htmlspecialchars($_GET['msg'] ?? 'ไม่ทราบสาเหตุ') ?></p>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Main Card -->
    <div class="card card-custom">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <!-- <th style="width: 5%">ID</th> -->
                            <th style="width: 30%">หัวข้อการเทรน</th>
                            <th style="width: 30%">เครื่องตรวจ</th>
                            <th style="width: 20%">สถานที่</th>
                            <th style="width: 10%">วัน-เวลา</th>
                            <!-- <th style="width: 12%">ผู้นัดเทรน</th> -->
                            <th style="width: 10%">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($res && $res->num_rows > 0): ?>
                            <?php while($row = $res->fetch_assoc()): ?>
                                <tr onclick="showDetail(<?= htmlspecialchars(json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)) ?>)" style="cursor: pointer;">
                                    <!-- <td class="text-center">
                                        <span class="id-badge">#<?= $row['training_id'] ?></span>
                                    </td> -->
                                    <td>
                                        <div class="training-topic" title="<?= htmlspecialchars($row['training_topic']) ?>">
                                            <?= htmlspecialchars($row['training_topic']) ?>
                                        </div>
                                        <?php if (!empty($row['training_detail'])): ?>
                                            <div class="training-detail-preview" style="font-size:0.7rem; color:#6c757d;" title="<?= htmlspecialchars($row['training_detail']) ?>">
                                                <i class="bi bi-file-text me-1"></i> <?= mb_substr(htmlspecialchars($row['training_detail']), 0, 35) ?>
                                                <?= strlen($row['training_detail']) > 35 ? '...' : '' ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <!-- เครื่องตรวจ -->
                                    <td>
                                        <div class="instruments-container">
                                            <?php 
                                            $ins_list = !empty($row['instruments']) ? explode(', ', $row['instruments']) : [];
                                            foreach($ins_list as $ins): 
                                                if(!$ins) continue;
                                            ?>
                                                <span class="badge-instrument">
                                                    <i class="bi bi-hdd-stack"></i> <?= htmlspecialchars($ins) ?>
                                                </span>
                                            <?php endforeach; ?>
                                            <?php if (empty($ins_list)): ?>
                                                <span class="text-muted small">- ไม่มีข้อมูล -</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <!-- สถานที่ -->
                                    <td>
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                        <span class="location-text small" title="<?= htmlspecialchars($row['training_location'] ?: '-') ?>">
                                            <?= htmlspecialchars($row['training_location'] ?: '-') ?>
                                        </span>
                                    </td>
                                    <!-- เวลา -->
                                    <td>
                                        <div class="timeline-badge">
                                            <i class="bi bi-calendar-event text-primary"></i>
                                            <div>
                                                <div class="fw-bold"><?= date('d/m/Y', strtotime($row['training_start'])) ?></div>
                                                <div class="text-muted">
                                                    <?= date('H:i', strtotime($row['training_start'])) ?> - 
                                                    <?= date('H:i', strtotime($row['training_end'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- สถานะ -->
                                    <td class="text-center">
                                        <?php 
                                        $st = $row['training_status'];
                                        if ($st == 2): ?>
                                            <span class="badge rounded-pill bg-secondary text-white">
                                                <i class="bi bi-x-circle-fill me-1"></i> ยกเลิก
                                            </span>
                                        <?php elseif ($st == 1): ?>
                                            <span class="badge-status-completed">
                                                <i class="bi bi-check-circle-fill me-1"></i> เสร็จสิ้น
                                            </span>
                                        <?php else: ?>
                                            <span class="badge-status-pending">
                                                <i class="bi bi-hourglass-split me-1"></i> กำลังดำเนินการ
                                            </span>
                                        <?php endif; ?>
                                    </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <i class="bi bi-calendar-x"></i>
                                    <p class="mb-0">ไม่พบประวัติการเทรน</p>
                                    
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-0 p-4" style="background-color: #ffc107;">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center" id="detailModalLabel">
                    <i class="bi bi-info-circle-fill me-2"></i> รายละเอียดการเทรน
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4 p-md-5" id="modalContent">
                </div>

            <div class="modal-footer border-0 p-4 pt-0 d-flex justify-content-between">
                <div id="cancelBtnArea"></div>
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> ปิด
                </button>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['status']) && $_GET['status'] == 'cancel_success'): ?>
    <script>
        window.addEventListener('load', () => {
            Swal.fire({
                icon: 'success',
                title: 'ยกเลิกสำเร็จ',
                timer: 1500,
                showConfirmButton: false
            });
        });
    </script>
<?php endif; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const myModalEl = document.getElementById('detailModal');
    myModalEl.addEventListener('hidden.bs.modal', function () {
        // ลบคลาส modal-open ออกจาก body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // ค้นหาและลบ div ที่เป็น .modal-backdrop ออกให้หมด
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
    });
});
</script>


<script src="<?= TRAIN_JS_URL ?>training_history.js?v=<?= time() ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>