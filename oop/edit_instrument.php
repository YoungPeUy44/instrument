<?php
/* oop/edit_instrument.php */
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../db/db.php';
;
$conn = db();
$ins_id = (int)($_GET['id'] ?? 0);
$mode = $_GET['mode'] ?? 'basic'; // รับโหมดจาก Dropdown

if ($ins_id <= 0) exit('Invalid ID');

// ดึงข้อมูลเครื่องตรวจ
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

if (!$item) exit('ไม่พบคู่มือครื่องตรวจในระบบ');
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Automate Guide: <?= htmlspecialchars($item['name']) ?></title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>assets/imgs/logo/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/edit.css?v=<?= time() ?>">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>
            <i class="bi <?php 
                if($mode === 'basic') echo 'bi-pencil-square'; 
                elseif($mode === 'upload') echo 'bi-images'; 
                else echo 'bi-sort-numeric-down'; 
            ?>"></i> 
            <?php 
                if($mode === 'basic') echo 'แก้ไขข้อมูลพื้นฐาน'; 
                elseif($mode === 'upload') echo 'อัปโหลดรูปภาพ'; 
                else echo 'ลบและจัดลำดับภาพ'; 
            ?>
        </h4>
        <a href="<?= BASE_URL ?>?act=manual_guide" class="btn btn-secondary">ย้อนกลับ</a>
    </div>

    <?php 
    // ตรวจสอบโหมดที่ส่งมาจาก URL
if ($mode === 'basic') {
    // 1. โหมดพื้นฐาน: แก้ชื่อ, หมวดหมู่, Config และอัปโหลด Deter.zip
    include __DIR__ . '/edit_basic_ins.php'; 
} elseif ($mode === 'upload' || $mode === 'upload') {
    // 2. โหมดจัดการสื่อ: ลบรูป, อัปโหลดรูปใหม่ 
    include __DIR__ . '/edit_img_ins.php'; 
} elseif ($mode === 'sort' || $mode === 'sort') {
    // 3. ลากวางจัดลำดับ
    include __DIR__ . '/edit_sort_images.php'; 
}

    ?>
</div>
</body>
<script src="<?= BASE_URL ?>assets/js/sortable-logic.js?v=<?= time() ?>"></script>
<script src="<?= BASE_URL ?>assets/js/edit_img_ins.js"></script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
        // เรียกใช้ Toast ที่ window.Toast (จากไฟล์ sortable-logic.js)
        if (typeof window.Toast !== 'undefined') {
            window.Toast.fire({
                icon: 'success',
                title: 'บันทึกข้อมูลเรียบร้อยแล้ว'
            });
        } else {
            // กรณีหา Toast ไม่เจอ ให้ใช้ Swal ปกติป้องกัน Error
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                timer: 2000
            });
        }
        
        // ลบ status ออกจาก URL
        const url = new URL(window.location);
        url.searchParams.delete('status');
        window.history.replaceState({}, '', url);
    }
});
</script>
</html>