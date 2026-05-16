<?php
/* training/oop/training_history_detail.php */
session_start(); 
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../../config/permission.php';

$db = db();
$t_id            = isset($_GET['training_id']) ? (int)$_GET['training_id'] : 0;
$mode            = isset($_GET['mode']) ? $_GET['mode'] : 'modal';
$user_level      = isset($_SESSION['user_instrument']) ? (int)$_SESSION['user_instrument'] : 0;
$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$user_dept       = isset($_SESSION['user_department']) ? $_SESSION['user_department'] : '';

$sql = "SELECT t.*, 
        GROUP_CONCAT(CONCAT(m.atm_model_id, ':', m.atm_model_name) SEPARATOR '|') AS instrument_data,
        GROUP_CONCAT(m.atm_model_id SEPARATOR ',') AS ins_id_list 
        FROM instrument_training t 
        LEFT JOIN instrument_training_items ti ON t.training_id = ti.training_id 
        LEFT JOIN automate_model m ON ti.instrument_id = m.atm_model_id 
        WHERE t.training_id = $t_id GROUP BY t.training_id";

$res  = $db->query($sql);
$data = ($res) ? $res->fetch_assoc() : null;

if (!$data) {
    die("<div class='p-5 text-center'>ไม่พบข้อมูล</div>");
}

$st              = (int)$data['training_status'];
$user_level      = (int)($_SESSION['user_instrument'] ?? 0);
$current_user_id = $_SESSION['user_id'] ?? '';

$badges = [0 => 'bg-warning text-dark', 1 => 'bg-success text-white', 2 => 'bg-secondary text-white'];
$labels = [0 => 'กำลังดำเนินการ', 1 => 'เสร็จสิ้น', 2 => 'ยกเลิก'];
?>

<style>
/* ── Responsive detail ── */
.detail-header {
    background-color: #ffc107;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.detail-header h5 { margin: 0; font-weight: 700; color: #212529; font-size: 1rem; }

.detail-body {
    background: #fff;
    padding: 1.25rem;
}
@media (min-width: 768px) {
    .detail-body { padding: 2rem 2.5rem; }
}

.detail-label {
    font-size: .75rem;
    font-weight: 700;
    color: #6c757d;
    margin-bottom: .25rem;
    display: block;
}
.detail-value {
    font-size: .92rem;
    color: #212529;
}
.detail-box {
    background: #f8f9fa;
    border-radius: 10px;
    padding: .65rem 1rem;
    font-size: .9rem;
}

/* badge เครื่องตรวจ */
.badge-instrument {
    font-size: .75rem;
    background: #e8f0fe;
    color: #1a56db;
    border-radius: 20px;
    padding: 4px 10px;
    text-decoration: none;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.badge-instrument:hover { background: #d0e2ff; color: #1246b5; }

/* footer ปุ่ม */
.detail-footer {
    background: #fff;
    padding: .85rem 1.25rem;
    border-top: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: .5rem;
}
.detail-footer .btn-group-right {
    display: flex;
    gap: .5rem;
    flex-wrap: wrap;
}

/* meta info */
.meta-row {
    display: flex;
    align-items: flex-start;
    gap: .5rem;
    font-size: .8rem;
    color: #6c757d;
    margin-bottom: .35rem;
}
.meta-row .meta-label { min-width: 80px; white-space: nowrap; }
</style>

<!-- ── Header ── -->
<div class="detail-header">
    <i class="bi bi-info-circle-fill fs-5"></i>
    <h5>รายละเอียดการเทรน</h5>
</div>

<!-- ── Body ── -->
<div class="detail-body">

    <!-- หัวข้อ + สถานะ -->
    <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
        <div>
            <span class="detail-label">หัวข้อการเทรน</span>
            <h4 class="fw-bold text-dark mb-0" style="font-size: clamp(1rem, 2.5vw, 1.4rem);">
                <?= htmlspecialchars($data['training_topic']) ?>
            </h4>
        </div>
        <span class="badge rounded-pill <?= $badges[$st] ?> px-3 py-2 shadow-sm flex-shrink-0">
            <?= $labels[$st] ?>
        </span>
    </div>

    <hr class="my-3">

    <!-- วันเวลา -->
    <div class="row g-2 mb-3">
        <div class="col-12 col-sm-6">
            <span class="detail-label">วัน-เวลาเริ่มต้น</span>
            <div class="detail-box detail-value">
                <i class="bi bi-calendar3 me-1 text-muted"></i>
                <?= date('d/m/Y H:i', strtotime($data['training_start'])) ?> น.
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <span class="detail-label">วัน-เวลาสิ้นสุด</span>
            <div class="detail-box detail-value">
                <i class="bi bi-calendar3 me-1 text-muted"></i>
                <?= date('d/m/Y H:i', strtotime($data['training_end'])) ?> น.
            </div>
        </div>
    </div>

    <!-- สถานที่ -->
    <div class="mb-3">
        <span class="detail-label"><i class="bi bi-geo-alt-fill text-danger me-1"></i>สถานที่</span>
        <div class="detail-value fw-semibold"><?= htmlspecialchars($data['training_location'] ?: '-') ?></div>
    </div>

    <!-- เครื่องตรวจ -->
    <div class="mb-3">
        <span class="detail-label">เครื่องตรวจที่นัดเทรน</span>
        <div class="d-flex flex-wrap gap-2 mt-1">
            <?php
            if (!empty($data['instrument_data'])):
                foreach (explode('|', $data['instrument_data']) as $item):
                    if (!$item) continue;
                    [$ins_id, $ins_name] = explode(':', $item, 2);
            ?>
                <a href="<?= BASE_URL ?>?act=view&id=<?= $ins_id ?>"
                   target="_blank"
                   class="badge-instrument">
                    <i class="bi bi-search small"></i> <?= htmlspecialchars($ins_name) ?>
                </a>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>

    <!-- รายละเอียดเพิ่มเติม -->
    <div class="mb-3">
        <span class="detail-label">รายละเอียดเพิ่มเติม</span>
        <div class="detail-box detail-value" style="white-space: pre-line; min-height: 48px;">
            <?= htmlspecialchars($data['training_detail'] ?: '-') ?>
        </div>
    </div>

    <!-- Meta info -->
    <div class="border-top pt-3 mt-3">
        <div class="meta-row">
            <i class="bi bi-person-circle mt-1"></i>
            <span class="meta-label">ผู้นัดหมาย :</span>
            <span><?= htmlspecialchars($data['created_by']) ?> | <?= date('d/m/Y H:i', strtotime($data['created_at'])) ?></span>
        </div>

        <?php if ($st === 1 && !empty($data['confirmed_by'])): ?>
        <div class="meta-row">
            <i class="bi bi-check-circle-fill mt-1"></i>
            <span class="meta-label">ผู้ยืนยัน :</span>
            <span><?= htmlspecialchars($data['confirmed_by']) ?> | <?= date('d/m/Y H:i', strtotime($data['confirmed_at'])) ?></span>
        </div>
        <?php endif; ?>

        <?php if ($st === 2 && !empty($data['cancel_by'])): ?>
        <div class="meta-row">
            <i class="bi bi-x-circle-fill mt-1"></i>
            <span class="meta-label">ผู้ยกเลิก :</span>
            <span><?= htmlspecialchars($data['cancel_by']) ?> | <?= date('d/m/Y H:i', strtotime($data['cancel_at'])) ?></span>
        </div>
        <?php endif; ?>
    </div>

</div>

<!-- ── Footer / ปุ่ม (คงไว้เหมือนเดิมทุกเงื่อนไข) ── -->
<div class="detail-footer">

    <!-- ปุ่มลบ (ซ้าย) -->
    <div>
        <?php if ($user_level >= 3 && (string)$current_user_id === "3"): ?>
        <button class="btn btn-outline-danger d-flex align-items-center justify-content-center shadow-sm"
                onclick="confirmDelete(<?= $t_id ?>)"
                title="ลบประวัติ"
                style="width:42px; height:42px; border-radius:50%;">
            <i class="bi bi-trash3 fs-5"></i>
        </button>
        <?php endif; ?>
    </div>

    <!-- ปุ่มขวา -->
    <div class="btn-group-right">
        <?php if ($mode === 'full' && $st === 0): ?>
            <?php if ($user_level >= 1 && $user_dept !== 'instrument'): ?>
                <button class="btn btn-success rounded-pill px-4 fw-bold"
                        onclick="confirmFinishInModal(<?= $t_id ?>, '<?= $data['ins_id_list'] ?>')">
                    ยืนยันการอบรม
                </button>
            <?php endif; ?>
            <?php if ($user_dept === 'instrument'): ?>
                <button class="btn btn-danger rounded-pill px-4 fw-bold"
                        onclick="confirmCancel(<?= $t_id ?>)">
                    ยกเลิกนัดเทรน
                </button>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($mode === 'full'): ?>
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                    onclick="history.back();">
                ปิด
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                    data-bs-dismiss="modal">
                ปิด
            </button>
        <?php endif; ?>
    </div>

</div>

<script src="<?= TRAIN_JS_URL ?>training_history_detail.js?v=<?= time() ?>"></script>