<?php
/* training/oop/training_history_model.php */
session_start(); 
// var_dump($_SESSION);
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../../config/permission.php';

$db = db();
$t_id = isset($_GET['training_id']) ? (int)$_GET['training_id'] : 0;
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'modal'; 
$user_level = isset($_SESSION['user_instrument']) ? (int)$_SESSION['user_instrument'] : 0;
$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$user_dept = isset($_SESSION['user_department']) ? $_SESSION['user_department'] : '';

$sql = "SELECT t.*, GROUP_CONCAT(m.atm_model_name SEPARATOR ', ') AS instruments, GROUP_CONCAT(m.atm_model_id SEPARATOR ',') AS ins_id_list 
        FROM instrument_training t 
        LEFT JOIN instrument_training_items ti ON t.training_id = ti.training_id 
        LEFT JOIN automate_model m ON ti.instrument_id = m.atm_model_id 
        WHERE t.training_id = $t_id GROUP BY t.training_id";

$res = $db->query($sql);
$data = ($res) ? $res->fetch_assoc() : null;

if (!$data) {
    die("<div class='p-5 text-center'>ไม่พบข้อมูล</div>");
}

$st = (int)$data['training_status'];
$user_level = (int)($_SESSION['user_instrument'] ?? 0);
$current_user_id = $_SESSION['user_id'] ?? '';
?>

<div class="modal-header border-0 p-4" style="background-color: #ffc107;">
    <h5 class="modal-title fw-bold text-dark d-flex align-items-center">
        <i class="bi bi-info-circle-fill me-2"></i> รายละเอียดการเทรน
    </h5>
    
</div>

<div class="modal-body p-4 p-md-5 bg-white">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <label class="small text-muted mb-1 fw-bold">หัวข้อการเทรน</label>
            <h3 class="fw-bold text-dark mb-0"><?= htmlspecialchars($data['training_topic']) ?></h3>
        </div>
        <div>
            <?php 
                $badges = [0 => 'bg-warning text-dark', 1 => 'bg-success text-white', 2 => 'bg-secondary text-white'];
                $labels = [0 => 'กำลังดำเนินการ', 1 => 'เสร็จสิ้น', 2 => 'ยกเลิก'];
            ?>
            <span class="badge rounded-pill <?= $badges[$st] ?> px-3 py-2 shadow-sm">
                <?= $labels[$st] ?>
            </span>
        </div>
    </div>
    <br>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label class="small text-muted mb-1 fw-bold">วัน-เวลาเริ่มต้น</label>
            <div class="form-control bg-light border-0 py-2"><?= date('d/m/Y H:i', strtotime($data['training_start'])) ?> น.</div>
        </div>
        <div class="col-md-6">
            <label class="small text-muted mb-1 fw-bold">วัน-เวลาสิ้นสุด</label>
            <div class="form-control bg-light border-0 py-2"><?= date('d/m/Y H:i', strtotime($data['training_end'])) ?> น.</div>
        </div>
    </div>
    <br>
    <div class="mb-4">
        <label class="small text-muted mb-1 fw-bold"><i class="bi bi-geo-alt-fill text-danger"></i> สถานที่</label>
        <div class="fw-bold mb-3"><?= htmlspecialchars($data['training_location'] ?: '-') ?></div>
        <br>
        <label class="small text-muted mb-1 fw-bold">เครื่องตรวจที่นัดเทรน</label>
        <div class="d-flex flex-wrap gap-2">
            <?php foreach(explode(', ', $data['instruments']) as $ins): if(!$ins) continue; ?>
                <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-3 py-1">
                    <?= htmlspecialchars($ins) ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="p-3 rounded-3 mb-4" style="background-color: #f8f9fa;">
        <label class="small text-muted mb-2 d-block fw-bold">รายละเอียดเพิ่มเติม</label>
        <div class="small text-dark" style="white-space: pre-line;">
            <?= htmlspecialchars($data['training_detail'] ?: '-') ?>
        </div>
    </div>

    <div class="border-top pt-3 mt-4">
        <div class="small text-muted d-flex align-items-center mb-1">
            <i class="bi bi-person-circle me-2"></i> 
            <span style="min-width: 80px;">ผู้นัดหมาย :</span> 
            <span class="ms-1"><?= htmlspecialchars($data['created_by']) ?> | <?= date('d/m/Y H:i', strtotime($data['created_at'])) ?></span>
        </div>

        <?php if ($st === 1 && !empty($data['confirmed_by'])): ?>
            <div class="small text-muted d-flex align-items-center mb-1">
                <i class="bi bi-check-circle-fill me-2 text-muted"></i> 
                <span style="min-width: 80px;">ผู้ยืนยัน :</span> 
                <span class="ms-1"><?= htmlspecialchars($data['confirmed_by']) ?> | <?= date('d/m/Y H:i', strtotime($data['confirmed_at'])) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($st === 2 && !empty($data['cancel_by'])): ?>
            <div class="small text-muted d-flex align-items-center mb-1">
                <i class="bi bi-x-circle-fill me-2 text-muted"></i> 
                <span style="min-width: 80px;">ผู้ยกเลิก :</span> 
                <span class="ms-1"><?= htmlspecialchars($data['cancel_by']) ?> | <?= date('d/m/Y H:i', strtotime($data['cancel_at'])) ?></span>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal-footer border-0 p-4 pt-0 d-flex justify-content-between bg-white">
    <div>
        <?php if ($user_level >= 3 && (string)$current_user_id === "3"): ?>
        <button class="btn btn-outline-danger d-flex align-items-center justify-content-center shadow-sm" 
                onclick="confirmDelete(<?= $t_id ?>)" 
                title="ลบประวัติ"
                style="width: 42px; height: 42px; border-radius: 50%;">
            <i class="bi bi-trash3 fs-5"></i>
            </button>
        <?php endif; ?>
    </div>
    
    <div class="d-flex gap-2">
        <?php if ($mode === 'full' && $st === 0): ?>
            <?php if ($user_level >= 1 && $user_dept !== 'instrument'): ?>
                <button class="btn btn-success rounded-pill px-4 fw-bold" onclick="confirmFinishInModal(<?= $t_id ?>, '<?= $data['ins_id_list'] ?>')">
                    ยืนยันการอบรบ
                </button>
            <?php endif; ?>

            <?php if ($user_dept === 'instrument'): ?>
                <button class="btn btn-danger rounded-pill px-4 fw-bold" onclick="confirmCancel(<?= $t_id ?>)">
                    ยกเลิกนัดเทรน
                </button>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($mode === 'full'): ?>
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="history.back();">
                ปิด
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                ปิด
            </button>
        <?php endif; ?>
    </div>
</div>
<!-- <script src="<?= TRAIN_JS_URL ?>training_history.js?v=<?= time() ?>"></script> -->