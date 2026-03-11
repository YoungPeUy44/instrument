<?php
/* oop/edit_sort_images.php */
$db = $conn ?? $connpeuy; 
$stmt_info = $db->prepare("SELECT atm_model_name FROM automate_model WHERE atm_model_id = ?");
$stmt_info->bind_param("i", $ins_id);
$stmt_info->execute();
$info = $stmt_info->get_result()->fetch_assoc();

$setup_res = $db->query("SELECT * FROM instrument_setup_images WHERE instrument_id = $ins_id ORDER BY sort_order ASC");
$run_res   = $db->query("SELECT * FROM instrument_run_images WHERE instrument_id = $ins_id ORDER BY sort_order ASC");
?>

<style>
/* คอนเทนเนอร์หลักของรายการ */
.sortable-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 5px;
}

/* ปรับปรุง Item ให้เป็น Responsive */
.sortable-item {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    padding: 10px;
    position: relative;
    touch-action: none;
    transition: box-shadow 0.2s;
}

/* จุดจับลาก (Drag Handle) ให้ใหญ่ขึ้นสำหรับนิ้วมือ */
.drag-handle {
    cursor: grab;
    background: #212529;
    color: #fff;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    margin-right: 12px;
    flex-shrink: 0;
}

/* รูปภาพปรับขนาดตามหน้าจอ */
.sortable-img {
    width: 60px;
    height: 45px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 12px;
    flex-shrink: 0;
}

/* ส่วนข้อความให้ยืดหยุ่นและตัดคำเมื่อยาวเกิน */
.sortable-info {
    flex-grow: 1;
    font-size: 0.9rem;
    font-weight: 600;
    color: #333;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding-right: 10px;
}

/* ปุ่มลบ (แก้ปัญหาล้นจอ) */
.btn-delete-item {
    background: #dc3545;
    color: #fff;
    border: none;
    border-radius: 8px;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background 0.2s;
}

/* ปรับแต่งสำหรับมือถือจอแคบมาก */
@media (max-width: 430px) {
    .sortable-item {
        padding: 8px;
    }
    .drag-handle {
        width: 35px;
        height: 35px;
        margin-right: 8px;
    }
    .sortable-img {
        width: 50px;
        height: 40px;
        margin-right: 8px;
    }
    .sortable-info {
        font-size: 0.8rem;
    }
    .btn-delete-item {
        width: 35px;
        height: 35px;
    }
}
</style>

<div class="alert alert-dark border-0 shadow-sm mb-4">
    <i class="bi bi-info-circle me-2"></i> 
    กำลังจัดลำดับรูปภาพเครื่อง: <strong><?= htmlspecialchars($info['atm_model_name'] ?? 'ไม่พบชื่อรุ่น') ?></strong>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-list-ul me-2 text-primary"></i>ลำดับภาพ Setup</h6>
        <button class="btn btn-primary btn-sm px-4 shadow-sm" onclick="saveOrder('setup', '<?= $ins_id ?>', '<?= BASE_URL ?>')">
            <i class="bi bi-save me-1"></i> บันทึกลำดับ
        </button>
    </div>
    <div class="card-body bg-light">
        <div id="setup-sortable" class="sortable-list">
            <?php $i=1; while($s = $setup_res->fetch_assoc()): ?>
                <div class="sortable-item shadow-sm" data-id="<?= $s['setup_id'] ?>">
                    <div class="drag-handle"><i class="bi bi-grip-vertical"></i></div>
                    <img src="<?= img_src($s['file_name']) ?>" class="sortable-img" onerror="this.src='assets/imgs/no-image.png'">
                    <div class="sortable-info">รูปที่ <?= $i++ ?> <small class="text-muted ms-2">(<?= htmlspecialchars($s['file_name']) ?>)</small></div>
                    <button type="button" class="btn-delete-item" onclick="deleteImgPOST('setup', '<?= $s['setup_id'] ?>', '<?= $ins_id ?>', '<?= BASE_URL ?>')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-bold text-success"><i class="bi bi-list-ul me-2"></i>ลำดับภาพ Run</h6>
        <button class="btn btn-primary btn-sm px-4 shadow-sm" onclick="saveOrder('run', '<?= $ins_id ?>', '<?= BASE_URL ?>')">
            <i class="bi bi-save me-1"></i> บันทึกลำดับ
        </button>
    </div>
    <div class="card-body bg-light">
        <div id="run-sortable" class="sortable-list">
            <?php $j=1; while($r = $run_res->fetch_assoc()): ?>
                <div class="sortable-item shadow-sm" data-id="<?= $r['run_id'] ?>">
                    <div class="drag-handle"><i class="bi bi-grip-vertical"></i></div>
                    <img src="<?= img_src($r['file_name']) ?>" class="sortable-img" onerror="this.src='assets/imgs/no-image.png'">
                    <div class="sortable-info">รูปที่ <?= $j++ ?> <small class="text-muted ms-2">(<?= htmlspecialchars($r['file_name']) ?>)</small></div>
                    <button type="button" class="btn-delete-item" onclick="deleteImgPOST('run', '<?= $r['run_id'] ?>', '<?= $ins_id ?>', '<?= BASE_URL ?>')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>