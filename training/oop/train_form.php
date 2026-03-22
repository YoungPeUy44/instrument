<?php
/* oop/train_form.php */

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/helpers.php';

$db = db();
$sql = "SELECT i.ins_id, m.atm_model_name 
        FROM instruments i 
        INNER JOIN automate_model m ON i.ins_id = m.atm_model_id 
        ORDER BY m.atm_model_name ASC";
$res = $db->query($sql);
?>

<link rel="stylesheet" href="<?= TRAIN_CSS_URL ?>train_form.css?v=<?= time() ?>">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-primary">
                <i class="bi bi-calendar-check-fill me-2"></i>นัดหมายการเทรนเครื่องตรวจ
            </h4>
            <p class="text-muted small mb-0">สร้างรายการนัดหมายและเลือกเครื่องมือที่ต้องการเปลี่ยนสถานะเป็น "รอเทรน"</p>
        </div>
        <a href="?act=manual_guide" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
        </a>
    </div>

    <form id="trainForm" action="<?= BASE_URL ?>training/db/save_training.php" method="POST">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">รายละเอียดการนัดหมาย</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">หัวข้อการนัดหมาย</label>
                            <input type="text" name="training_topic" class="form-control form-control-lg border-2" placeholder="เช่น การใช้งานเบื้องต้นประจำปี" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">สถานที่</label>
                            <input type="text" name="training_location" class="form-control border-2" placeholder="ห้องปฏิบัติการ / ตึก..." required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold small text-uppercase">เริ่มเวลา</label>
                                <input type="datetime-local" name="training_start" class="form-control border-2" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small text-uppercase">สิ้นสุดเวลา</label>
                                <input type="datetime-local" name="training_end" class="form-control border-2" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">รายละเอียดเพิ่มเติม</label>
                            <textarea name="training_detail" class="form-control border-2" rows="3" placeholder="ระบุข้อมูลที่ผู้เข้าเทรนต้องเตรียมตัว..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 py-3 fw-bold rounded-3 shadow-sm mt-2">
                            <i class="bi bi-cloud-arrow-up-fill me-2"></i> บันทึกข้อมูลนัดหมาย
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">เลือกเครื่องตรวจ (<span id="selectedCount">0</span>)</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label small fw-bold" for="selectAll">เลือกทั้งหมด</label>
                            </div>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-light border-2 border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="searchIns" class="form-control border-2 border-start-0 bg-light" placeholder="ค้นหาชื่อเครื่องตรวจ...">
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="list-group list-group-flush instrument-list" style="max-height: 550px; overflow-y: auto;">
                            <?php while($row = $res->fetch_assoc()): ?>
                                <label class="list-group-item border rounded-3 mb-2 p-3 d-flex align-items-center btn-instrument-item">
                                    <input class="form-check-input me-3 ms-0 ins-checkbox" type="checkbox" name="ins_ids[]" value="<?= $row['ins_id'] ?>">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="fw-bold text-dark text-truncate"><?= htmlspecialchars($row['atm_model_name']) ?></div>
                                        <div class="d-flex gap-2 mt-1">
                                            <span class="badge bg-light text-muted border rounded-pill fw-normal">ID: #<?= $row['ins_id'] ?></span>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill fw-normal"><?= htmlspecialchars($row['category_name']) ?></span>
                                        </div>
                                    </div>
                                </label>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="<?= TRAIN_JS_URL ?>train_form.js?v=<?= time() ?>"></script>