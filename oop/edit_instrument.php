<?php
/* oop/edit_instrument.php */
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../db/db.php';

$conn = db();
$ins_id = (int)($_GET['id'] ?? $_GET['ins_id'] ?? 0);
$mode = $_GET['mode'] ?? 'basic';

// --- 1. เตรียมข้อมูลเครื่องตรวจ (รัน SQL ก่อนเพื่อให้มีข้อมูลแสดงผลเสมอ) ---
$stmt = $conn->prepare("
    SELECT i.*, 
        m.atm_model_name AS name, 
        m.ref_atm_category_id,
        m.ref_atm_status_manual_id,
        c.atm_category_name AS category_name
    FROM instruments i
    INNER JOIN automate_model m ON i.ins_id = m.atm_model_id
    INNER JOIN automate_category c ON m.ref_atm_category_id = c.atm_category_id
    WHERE i.ins_id = ?
");
$stmt->bind_param("i", $ins_id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

// --- 2. เช็คสถานะไฟล์ใหญ่จาก URL (ไม่ต้องสั่ง exit เพื่อให้โหลดข้อมูลเครื่องด้านล่างด้วย) ---
$error_script = "";
if (isset($_GET['status']) && $_GET['status'] === 'error_too_big') {
    $current_size = $_GET['size'] ?? 'Unknown';
    $error_script = "
        Swal.fire({
            icon: 'error',
            title: 'ไฟล์ใหญ่เกินไป!',
            html: 'ไฟล์ที่คุณอัปโหลดมีขนาดรวม <b>$current_size MB</b> ซึ่งเกินขีดจำกัด 50MB ของระบบ',
            confirmButtonText: 'ตกลง',
            confirmButtonColor: '#d33'
        }).then(() => {
            let url = new URL(window.location.href);
            url.searchParams.delete('status');
            url.searchParams.delete('size');
            window.history.replaceState({}, '', url); // ล้าง URL โดยไม่ Refresh หน้า
        });
    ";
}

// กรณีหาข้อมูลไม่เจอจริงๆ (เช่น ID ผิด)
if ($ins_id > 0 && !$item) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({ icon: 'warning', title: 'ไม่พบคู่มือ!' }).then(() => { window.location.href='index.php?act=manual_guide'; });
            });
          </script>";
    exit;
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit: <?= htmlspecialchars($item['name'] ?? 'เครื่องตรวจ') ?></title>
    <?php require_once __DIR__ . '/../config/favicon.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/edit.css?v=<?= time() ?>">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="bi <?= ($mode==='basic'?'bi-pencil-square':($mode==='upload'?'bi-images':'bi-sort-numeric-down')) ?>"></i> <?= ($mode==='basic'?'แก้ไขข้อมูลพื้นฐาน':($mode==='upload'?'อัปโหลดรูปภาพ':'จัดลำดับภาพ')) ?></h4>
        <a href="<?= BASE_URL ?>?act=manual_guide" class="btn btn-secondary">ย้อนกลับ</a>
    </div>

    <form id="mainUploadForm" action="<?= BASE_URL ?>db/save_instrument.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="ins_id" value="<?= $ins_id ?>">
        <input type="hidden" name="mode" value="<?= $mode ?>">
        
        <?php 
        if ($mode === 'basic') include __DIR__ . '/edit_basic_ins.php'; 
        elseif ($mode === 'upload') include __DIR__ . '/edit_img_ins.php'; 
        elseif ($mode === 'sort') include __DIR__ . '/edit_sort_images.php'; 
        ?>

        <div class="mt-3">
            <button type="submit" id="btnSubmit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">
                <i class="bi bi-cloud-arrow-up-fill me-2"></i>อัปโหลดและบันทึกข้อมูล
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // แสดง Error จากไฟล์ใหญ่ (ถ้ามี)
    <?= $error_script ?>
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
            showConfirmButton: false,
            timer: 1500,
            toast: true,
            position: 'top-end' // แสดงเป็น Toast มุมขวาบนเพื่อให้ไม่บังหน้าจอ
        }).then(() => {
            // ล้าง status ออกจาก URL เพื่อป้องกัน Popup เด้งซ้ำตอน Refresh
            let url = new URL(window.location.href);
            url.searchParams.delete('status');
            window.history.replaceState({}, '', url);
        });
    }

    // 3. [เพิ่มใหม่] แจ้งเตือนเมื่อนัดเทรนสำเร็จ
    if (urlParams.get('status') === 'train_success') {
        Swal.fire({
            icon: 'success',
            title: 'นัดหมายสำเร็จ',
            text: 'ระบบบันทึกการนัดเทรนและเปลี่ยนสถานะเป็นรอเทรนแล้ว',
            confirmButtonColor: '#ffc107'
        });
    }

    // ดักจับการ Submit
    const mainForm = document.getElementById('mainUploadForm');
    if(mainForm) {
        mainForm.addEventListener('submit', function(e) {
            const fileInputs = this.querySelectorAll('input[type="file"]');
            let totalSize = 0;
            const limitSize = 50 * 1024 * 1024; // 50MB

            fileInputs.forEach(input => {
                for (let i = 0; i < input.files.length; i++) {
                    totalSize += input.files[i].size;
                }
            });

            if (totalSize > limitSize) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'ไฟล์ขนาดใหญ่เกินไป!',
                    text: 'ขนาดรวม ' + (totalSize / (1024 * 1024)).toFixed(2) + ' MB เกินขีดจำกัด 50 MB',
                    confirmButtonColor: '#d33'
                });
            } else if (totalSize > 0) {
                const btn = document.getElementById('btnSubmit');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> กำลังอัปโหลด...';
            }
        });
    }
});


</script>
<script src="<?= BASE_URL ?>assets/js/sortable-logic.js?v=<?= time() ?>"></script>
<script src="<?= BASE_URL ?>assets/js/edit_img_ins.js"></script>

</body>
</html>