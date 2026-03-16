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

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-calendar-plus text-warning me-2"></i>นัดหมายการเทรนเครื่องตรวจ</h4>
        <a href="?act=manual_guide" class="btn btn-secondary">ย้อนกลับ</a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <form action="db/save_training.php" method="POST">
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold">หัวข้อการนัดหมาย</label>
                    <input type="text" name="training_topic" class="form-control" placeholder="เช่น การใช้งานเบื้องต้น" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">สถานที่</label>
                    <input type="text" name="training_location" class="form-control" placeholder="ห้องปฏิบัติการ..." required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">เริ่มเวลา</label>
                        <input type="datetime-local" name="training_start" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">สิ้นสุดเวลา</label>
                        <input type="datetime-local" name="training_end" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">เลือกเครื่องที่จะเทรน (เลือกได้หลายเครื่อง)</label>
                    <select name="ins_ids[]" class="form-select" multiple style="height: 200px;" required>
                        <?php while($row = $res->fetch_assoc()): ?>
                            <option value="<?= $row['ins_id'] ?>">#<?= $row['ins_id'] ?> - <?= $row['atm_model_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <small class="text-muted">* กด Ctrl ค้างไว้เพื่อเลือกหลายรายการ</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">รายละเอียดเพิ่มเติม</label>
                    <textarea name="training_detail" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end">
                <button type="submit" class="btn btn-warning w-100 fw-bold py-2">
                    <i class="bi bi-save me-1"></i> บันทึกนัดหมายและตั้งค่าเป็น "รอเทรน"
                </button>
            </div>
        </form>
    </div>
</div>