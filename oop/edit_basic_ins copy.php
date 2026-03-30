<?php
/* edit_basic_ins.php - แก้ไขข้อมูลพื้นฐาน */
// ตรวจสอบว่ามี $item และ $conn จากไฟล์หลัก
if (!isset($item) || !isset($conn)) {
    die("Error: Missing data");
}

// Debug: แสดงค่าเพื่อตรวจสอบ
// echo "<!-- cable_type_id: " . ($item['cable_type_id'] ?? 'null') . " -->";
// echo "<!-- config_text: " . htmlspecialchars($item['config_text'] ?? '') . " -->";
?>
<div class="card shadow-sm mb-3 border-0">
    <div class="card-header bg-white py-2">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="fw-bold small text-uppercase">
                <i class="bi bi-pencil-square text-primary me-2"></i>แก้ไขข้อมูลพื้นฐาน
            </div>

            <div class="btn-group shadow-sm" role="group">
                <input type="radio" class="btn-check" name="status_selector" id="status_ready" value="1" 
                    <?= (isset($item['ref_atm_status_manual_id']) && $item['ref_atm_status_manual_id'] == 1) ? 'checked' : '' ?> autocomplete="off">
                <label class="btn btn-outline-success btn-sm px-3 py-1 fw-bold" for="status_ready">
                    <i class="bi bi-check-circle me-1"></i>พร้อม
                </label>

                <input type="radio" class="btn-check" name="status_selector" id="status_training" value="3" 
                    <?= (isset($item['ref_atm_status_manual_id']) && $item['ref_atm_status_manual_id'] == 3) ? 'checked' : '' ?> autocomplete="off">
                <label class="btn btn-outline-warning btn-sm px-3 py-1 fw-bold text-dark" for="status_training">
                    <i class="bi bi-hourglass-split me-1"></i>รอเทรน
                </label>

                <input type="radio" class="btn-check" name="status_selector" id="status_not_ready" value="2" 
                    <?= (isset($item['ref_atm_status_manual_id']) && $item['ref_atm_status_manual_id'] == 2) ? 'checked' : '' ?> autocomplete="off">
                <label class="btn btn-outline-danger btn-sm px-3 py-1 fw-bold" for="status_not_ready">
                    <i class="bi bi-x-circle me-1"></i>ไม่พร้อม
                </label>
            </div>
        </div>
    </div>

    <div class="card-body p-3"> 
        <div class="mb-3">
            <label class="form-label fw-bold small mb-1">ชื่อเครื่องตรวจ</label>
            <input type="text" name="name" class="form-control form-control-sm bg-light" value="<?= htmlspecialchars($item['name'] ?? '') ?>" readonly>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-12 col-md-6">
                <label class="form-label fw-bold small mb-1 text-muted">หมวดหมู่</label>
                <input type="text" class="form-control form-control-sm bg-light" 
                    value="<?= htmlspecialchars($item['category_name'] ?: 'ไม่ระบุ') ?>" readonly>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-bold small mb-1">ชนิดสาย</label>
                <select name="cable_type_id" class="form-select form-select-sm" id="cable_type_select">
                    <option value="">-- เลือกชนิดสาย --</option>
                    <?php 
                    $cables = $conn->query("SELECT cable_id, cable_name FROM instrument_cable_types WHERE cable_is_active='Y' ORDER BY cable_name");
                    if ($cables && $cables->num_rows > 0):
                        while($cb = $cables->fetch_assoc()): 
                            $selected = (isset($item['cable_type_id']) && $cb['cable_id'] == $item['cable_type_id']) ? 'selected' : '';
                    ?>
                        <option value="<?= $cb['cable_id'] ?>" <?= $selected ?>><?= htmlspecialchars($cb['cable_name']) ?></option>
                    <?php 
                        endwhile;
                    endif;
                    ?>
                </select>
                <small class="text-muted">ค่าเดิม: <?= htmlspecialchars($item['cable_name'] ?? 'ไม่ระบุ') ?></small>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold small mb-1">รายละเอียดการตั้งค่า (Config)</label>
            <textarea name="config_text" class="form-control" rows="4" style="font-size: 0.85rem;" id="config_textarea"><?= htmlspecialchars($item['config_text'] ?? '') ?></textarea>
            <small class="text-muted">ค่าเดิม: <?= htmlspecialchars(mb_substr($item['config_text'] ?? '', 0, 50)) ?></small>
        </div>

        <label class="form-label fw-bold small text-muted mb-1">ไฟล์เอกสารในระบบ:</label>
        <div class="list-group mb-3 shadow-sm border rounded">
            <?php 
            $stmt_files = $conn->prepare("SELECT * FROM instrument_determination WHERE instrument_id = ?");
            $stmt_files->bind_param("i", $ins_id);
            $stmt_files->execute();
            $res_files = $stmt_files->get_result();

            if ($res_files->num_rows > 0): 
                while($f = $res_files->fetch_assoc()): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                    <div class="d-flex align-items-center text-truncate me-2">
                        <i class="bi bi-file-earmark-zip text-secondary me-2"></i>
                        <div class="text-truncate">
                            <div class="fw-bold text-dark text-truncate" style="font-size: 0.75rem;">
                                <?= htmlspecialchars($f['original_name'] ?: $f['file_name']) ?>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-link text-danger p-0 ms-2" 
                            onclick="deleteFilePOST('<?= $f['deter_id'] ?>', '<?= $ins_id ?>', '<?= BASE_URL ?>')">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </div>
            <?php endwhile; 
            else: ?>
                <div class="p-3 text-center text-muted small bg-white">ไม่มีไฟล์เอกสาร</div>
            <?php endif; ?>
            <?php $stmt_files->close(); ?>
        </div>

        <div class="p-2 bg-primary bg-opacity-10 rounded mb-3 border border-primary border-opacity-25">
            <label class="form-label fw-bold small text-primary mb-1">เพิ่มไฟล์ใหม่ (.zip, .rar):</label>
            <input type="file" name="determinations[]" class="form-control form-control-sm" accept=".zip, .rar" multiple>
        </div>
    </div>
</div>

<script>
// ฟังก์ชันลบไฟล์
function deleteFilePOST(fileId, insId, baseUrl) {
    if (confirm('ต้องการลบไฟล์นี้ใช่หรือไม่?')) {
        fetch(`${baseUrl}db/save_instrument.php?act=delete_file&id=${fileId}`, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'OK') {
                location.reload();
            } else {
                alert('ลบไฟล์ไม่สำเร็จ');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('เกิดข้อผิดพลาด');
        });
    }
}
</script>