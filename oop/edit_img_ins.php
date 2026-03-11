<?php
/* edit_upload_ins.php */
$db = $conn ?? $connpeuy; 

// 1. ดึงข้อมูลเครื่องตรวจและชื่อรุ่นเพื่อใช้ตั้งชื่อไฟล์
$stmt = $db->prepare("
    SELECT i.equipment_image, m.atm_model_name 
    FROM instruments i 
    INNER JOIN automate_model m ON i.ins_id = m.atm_model_id 
    WHERE i.ins_id = ?
");
$stmt->bind_param("i", $ins_id);
$stmt->execute();
$current_ins = $stmt->get_result()->fetch_assoc();
$ins_name = $current_ins['atm_model_name'] ?? 'instrument';
?>

<div class="card shadow-sm mb-3 border-0">
    <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
        <div class="fw-bold small text-uppercase">
            <i class="bi bi-images text-success me-2"></i>จัดการรูปภาพและไฟล์
        </div>
        <span class="badge bg-light text-dark border fw-normal" style="font-size: 0.65rem;">ID: <?= $ins_id ?></span>
    </div>

    <div class="card-body p-3">
        <form action="<?= BASE_URL ?>db/save_instrument.php" method="post" enctype="multipart/form-data">
            <!-- ⭐ จุดสำคัญ: ส่งโหมด upload เพื่อป้องกันข้อมูล Basic หาย -->
            <input type="hidden" name="mode" value="upload">
            <input type="hidden" name="ins_id" value="<?= $ins_id ?>">
            <input type="hidden" name="name" value="<?= htmlspecialchars($ins_name) ?>">

            <!-- 1. รูปหน้าปก (Cover Image) พร้อมระบบ Preview -->
            <div class="mb-3 p-2 border rounded bg-light">
                <label class="form-label fw-bold small mb-2 d-block">รูปหน้าปกเครื่อง (Cover)</label>
                <div class="d-flex align-items-center gap-3">
                    <div class="position-relative">
                        <img id="eq-preview" 
                             src="<?= img_src($current_ins['equipment_image']) ?>" 
                             class="rounded border shadow-sm bg-white" 
                             style="width: 70px; height: 70px; object-fit: cover;" 
                             onerror="this.src='https://placehold.co/100x100?text=No+Img'">
                    </div>
                    <div class="flex-grow-1">
                        <input type="file" name="equipment_image" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'eq-preview')">
                        <div class="form-text mt-1" style="font-size: 0.6rem;">เปลี่ยนรูปหน้าปกหลัก (ตั้งชื่อไฟล์อัตโนมัติ)</div>
                    </div>
                </div>
            </div>

            <!-- 2. อัปโหลดรูปขั้นตอน Setup -->
            <div class="mb-3 p-2 border rounded">
                <label class="form-label fw-bold small mb-1 text-primary">
                    <i class="bi bi-gear-fill me-1"></i>รูปภาพขั้นตอน Setup
                </label>
                <input type="file" name="setup_images[]" class="form-control form-control-sm mb-2" accept="image/*" multiple>
                
                <?php 
                $setup_imgs = $db->query("SELECT * FROM instrument_setup_images WHERE instrument_id = $ins_id ORDER BY sort_order");
                if ($setup_imgs->num_rows > 0): ?>
                    <div class="d-flex flex-nowrap gap-2 overflow-auto pb-1" style="scrollbar-width: thin;">
                        <?php while($img = $setup_imgs->fetch_assoc()): ?>
                            <div class="position-relative flex-shrink-0">
                                <img src="<?= img_src($img['file_name']) ?>" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="small text-muted" style="font-size: 0.65rem;">ยังไม่มีรูปขั้นตอน Setup</div>
                <?php endif; ?>
            </div>

            <!-- 3. อัปโหลดรูปขั้นตอน Run -->
            <div class="mb-3 p-2 border rounded">
                <label class="form-label fw-bold small mb-1 text-success">
                    <i class="bi bi-play-circle-fill me-1"></i>รูปภาพหน้างาน
                </label>
                <input type="file" name="run_images[]" class="form-control form-control-sm mb-2" accept="image/*" multiple>

                <?php 
                $run_imgs = $db->query("SELECT * FROM instrument_run_images WHERE instrument_id = $ins_id ORDER BY sort_order");
                if ($run_imgs->num_rows > 0): ?>
                    <div class="d-flex flex-nowrap gap-2 overflow-auto pb-1" style="scrollbar-width: thin;">
                        <?php while($img = $run_imgs->fetch_assoc()): ?>
                            <div class="position-relative flex-shrink-0">
                                <img src="<?= img_src($img['file_name']) ?>" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="small text-muted" style="font-size: 0.65rem;">ยังไม่มีรูปขั้นตอน Run</div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">
                <i class="bi bi-cloud-arrow-up-fill me-2"></i>อัปโหลดและบันทึกข้อมูล
            </button>
        </form>
    </div>
</div>

<script>
/**
 * ฟังก์ชันพรีวิวรูปภาพหน้าปกทันที
 */
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>