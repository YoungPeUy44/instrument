<?php
/* oop/edit_instrument.php */
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../db/db.php';

$conn = db();
$ins_id = (int)($_GET['id'] ?? $_GET['ins_id'] ?? 0);
// รับ mode มาเพื่อ set active tab ตอนโหลดหน้า (ถ้ามี)
$active_mode = $_GET['mode'] ?? 'basic';

// --- 1. เตรียมข้อมูลเครื่องตรวจ ---
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

// เช็คข้อมูล
if ($ins_id > 0 && !$item) {
    echo "<script>alert('ไม่พบคู่มือ'); window.location.href='index.php?act=manual_guide';</script>";
    exit;
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit: <?= htmlspecialchars($item['name']) ?></title>
    <?php require_once __DIR__ . '/../config/favicon.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/manual_guide.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/edit.css?v=<?= time() ?>">
    <style>
        /* ปรับแต่ง Tab ให้เหมือนในรูปที่คุณวาด */
        .edit-tab-group {
            background: #fff;
            border-bottom: 2px solid #eee;
            margin-bottom: 20px;
        }
        .edit-tab-group .nav-link {
            border: none;
            color: #666;
            font-weight: bold;
            padding: 15px 20px;
            border-bottom: 3px solid transparent;
            border-radius: 0;
        }
        .edit-tab-group .nav-link.active {
            color: #0d6efd;
            background: none;
            border-bottom-color: #0d6efd;
        }
        .view-header-section {
            background: #fff;
            border-radius: 15px 15px 0 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .img-preview-header {
            width: 150px;
            height: 110px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="view-header-section p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <h2 class="fw-bold"><i class="bi bi-display me-2 text-primary"></i><?= htmlspecialchars($item['name']) ?></h2>
            <a href="<?= BASE_URL ?>?act=manual_guide" class="btn btn-outline-dark btn-sm rounded-pill">
                <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
            </a>
        </div>
        
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="<?= img_src($item['equipment_image']) ?>" 
                     class="img-preview-header border shadow-sm"
                     onerror="this.src='<?= BASE_URL ?>assets/imgs/ins_setup/noImage.jpg'">
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted d-block">หมวดหมู่</small>
                        <span class="fw-bold text-primary"><?= htmlspecialchars($item['category_name']) ?></span>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <small class="text-muted d-block text-uppercase small fw-bold">ชนิดสาย</small>
                            <span class="fw-bold"><?= htmlspecialchars($item['cable_name'] ?: 'ไม่ระบุ') ?></span>
                    </div>
                </div>
                <div class="mt-2 small text-muted">
                    <i class="bi bi-clock-history"></i> อัปเดตล่าสุด: <?= date('d/m/Y H:i', strtotime($item['updated_at'] ?? $row['created_at'])) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="edit-tab-group shadow-sm">
        <ul class="nav nav-tabs nav-justified border-0" id="editTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-basic">
                    <i class="bi bi-pencil-square me-2"></i>แก้ไขข้อมูลพื้นฐาน
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-upload">
                    <i class="bi bi-images me-2"></i>อัปโหลดรูปภาพ
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-sort">
                    <i class="bi bi-sort-numeric-down me-2"></i>จัดลำดับภาพ
                </button>
            </li>
        </ul>
    </div>

    <div class="card border-0 shadow-sm p-4 rounded-bottom-4">
        <form id="mainUploadForm" action="<?= BASE_URL ?>db/save_instrument.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="ins_id" value="<?= $ins_id ?>">
            <input type="hidden" name="mode" id="current_mode" value="basic">

            <div class="tab-content" id="editTabContent">
                <div class="tab-pane fade show active" id="tab-basic">
                    <?php include __DIR__ . '/edit_basic_ins.php'; ?>
                </div>
                <div class="tab-pane fade" id="tab-upload">
                    <?php include __DIR__ . '/edit_img_ins.php'; ?>
                </div>
                <div class="tab-pane fade" id="tab-sort">
                    <?php include __DIR__ . '/edit_sort_images.php'; ?>
                </div>
            </div>

            <div class="mt-5 border-top pt-4 text-center">
                <button type="submit" id="btnSubmit" class="btn btn-success btn-lg px-5 fw-bold shadow rounded-pill">
                    <i class="bi bi-save2-fill me-2"></i>บันทึกข้อมูลทั้งหมด
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeInput = document.getElementById('current_mode');
    const submitText = document.getElementById('submit-text');
    
    // 1. ฟังก์ชันเปลี่ยน Mode และข้อความปุ่มตาม Tab
    const updateSubmitButton = (targetId) => {
        if(targetId === '#tab-basic') {
            modeInput.value = 'basic';
            submitText.innerText = 'บันทึกข้อมูลพื้นฐาน';
        } else if(targetId === '#tab-upload') {
            modeInput.value = 'upload';
            submitText.innerText = 'บันทึกและอัปโหลดรูปภาพ';
        } else if(targetId === '#tab-sort') {
            modeInput.value = 'sort';
            submitText.innerText = 'บันทึกการจัดลำดับภาพ';
        }
    };

    // ดักจับการสลับ Tab
    const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabEls.forEach(el => {
        el.addEventListener('shown.bs.tab', function (event) {
            updateSubmitButton(event.target.getAttribute('data-bs-target'));
        });
    });

    // รันครั้งแรกตอนโหลดหน้า
    updateSubmitButton('#tab-<?= $active_mode ?>');

    // 2. แจ้งเตือน Success จาก URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'บันทึกเรียบร้อย',
            toast: true,
            position: 'top-end',
            timer: 2000,
            showConfirmButton: false
        });
        // ล้าง URL
        window.history.replaceState({}, '', window.location.pathname + window.location.search.replace(/[&?]status=[^&]+/g, ""));
    }

    // 3. จัดการ Submit และ Check Size
    const mainForm = document.getElementById('mainUploadForm');
    mainForm.addEventListener('submit', function(e) {
        const btn = document.getElementById('btnSubmit');
        
        // ถ้าอยู่ในโหมด Upload ให้เช็คขนาดไฟล์
        if (modeInput.value === 'upload') {
            const fileInputs = this.querySelectorAll('input[type="file"]');
            let totalSize = 0;
            fileInputs.forEach(input => {
                for (let i = 0; i < input.files.length; i++) {
                    totalSize += input.files[i].size;
                }
            });

            if (totalSize > 50 * 1024 * 1024) {
                e.preventDefault();
                Swal.fire({ icon: 'error', title: 'ไฟล์ใหญ่เกินไป!', text: 'เกิน 50 MB' });
                return;
            }
        }

        // แสดง Loading
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> กำลังบันทึก...';
    });
});
</script>

<script src="<?= BASE_URL ?>assets/js/sortable-logic.js?v=<?= time() ?>"></script>
<script src="<?= BASE_URL ?>assets/js/edit_img_ins.js"></script>

</body>
</html>