<?php
session_start();
/* oop/add_instrument.php */
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../db/db.php';

$conn = db();
$conn->set_charset('utf8mb4');

// โหลด Categories
$categories = $conn->query("SELECT categories_id, name FROM instrument_categories WHERE is_active = 'Y' ORDER BY name")->fetch_all(MYSQLI_ASSOC);

// โหลด Cable Types
$cables = $conn->query("SELECT cable_id, cable_name FROM instrument_cable_types WHERE cable_is_active = 'Y' ORDER BY cable_name")->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8">
<title>เพิ่มเครื่องตรวจ</title>
<link rel="icon" type="image/x-icon" href="/xct/alt/instrument/assets/imags/logo/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.preview-img{ width:100%; max-width:260px; height:auto; border-radius:10px; border:1px solid #dee2e6; background:#f8f9fa; }
</style>
</head>
<body class="bg-light">
<div class="container py-4">

    <div class="d-flex align-items-center mb-3">
        <h4 class="mb-0">เพิ่มเครื่องตรวจ</h4>
        <a href="<?= BASE_URL ?>?act=manual_guide" class="btn btn-outline-secondary ms-auto">← ย้อนกลับ</a>
    </div>

    <form method="post" action="<?= BASE_URL ?>?act=save" enctype="multipart/form-data" class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">หมวดหมู่เครื่องตรวจ <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- เลือก --</option>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= (int)$c['categories_id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ชนิดสายสื่อสาร</label>
                    <select name="cable_type_id" class="form-select">
                        <option value="">-- ไม่มี --</option>
                        <?php foreach ($cables as $c): ?>
                            <option value="<?= (int)$c['cable_id'] ?>"><?= htmlspecialchars($c['cable_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">ชื่อเครื่อง <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="เช่น XN-1000, BC-7600">
                </div>
            </div>

            <hr class="my-4">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">ภาพหน้าปกเครื่อง</label>
                    <input type="file" name="equipment_image" class="form-control" accept="image/*" onchange="previewCover(this)">
                </div>
                <div class="col-md-6 text-center">
                    <img id="coverPreview" src="https://via.placeholder.com/260x180?text=Preview" class="preview-img mt-2">
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-12">
                    <label class="form-label">รายละเอียดการตั้งค่า (Config)</label>
                    <textarea name="config_text" class="form-control" rows="4"></textarea>
                </div>
            </div>

            <hr class="my-4">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">ภาพตั้งค่าเครื่อง (Setup)</label>
                    <input type="file" name="setup_images[]" class="form-control" multiple accept="image/*">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ภาพการใช้งาน (Run)</label>
                    <input type="file" name="run_images[]" class="form-control" multiple accept="image/*">
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-12">
                    <div class="p-3 bg-primary bg-opacity-10 rounded mb-4 border border-primary border-opacity-25">
                        <label class="form-label fw-bold small text-primary">อัปโหลดไฟล์ใหม่ (.zip, .rar):</label>
                        <input type="file" name="determinations[]" class="form-control" accept=".zip, .rar" multiple>
                     </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-end gap-2">
            <a href="<?= BASE_URL ?>?act=manual_guide" class="btn btn-outline-secondary">ยกเลิก</a>
            <button type="submit" class="btn btn-warning px-4">บันทึกข้อมูล</button>
        </div>
    </form>
</div>

<script>
function previewCover(input){
    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = e => { document.getElementById('coverPreview').src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>