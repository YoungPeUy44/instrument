<?php
/* oop/edit_instrument.php */
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../db/db.php';

$conn = db();
$ins_id = (int)($_GET['id'] ?? $_GET['ins_id'] ?? 0);
$active_mode = $_GET['mode'] ?? 'basic';

// --- 1. เตรียมข้อมูลเครื่องตรวจ - เพิ่ม cable_type_id และ config_text ---
$stmt = $conn->prepare("
    SELECT 
        i.ins_id,
        i.cable_type_id,
        i.config_text,
        i.equipment_image,
        i.updated_at,
        i.updated_by,
        i.created_at,
        m.atm_model_name AS name, 
        m.ref_atm_category_id,
        m.ref_atm_status_manual_id,
        c.atm_category_name AS category_name,
        ct.cable_name
    FROM instruments i
    INNER JOIN automate_model m ON i.ins_id = m.atm_model_id
    INNER JOIN automate_category c ON m.ref_atm_category_id = c.atm_category_id
    LEFT JOIN instrument_cable_types ct ON i.cable_type_id = ct.cable_id
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
    <div class="view-header-section p-4 shadow-sm bg-white rounded-3">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <h2 class="fw-bold mb-0"><i class="bi bi-display me-2 text-primary"></i><?= htmlspecialchars($item['name']) ?></h2>
            <div class="d-flex gap-2">
                <a href="?act=view&id=<?= $ins_id ?>" target="_blank" class="btn btn-primary btn-sm px-3 rounded-pill shadow-sm text-white">
                    <i class="bi bi-eye-fill me-1"></i> View
                </a>
                <button type="button" class="btn btn-outline-dark btn-sm rounded-pill" onclick="history.back();">
                <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
            </button>
            </div>
        </div>
        
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="<?= img_src($item['equipment_image']) ?>" 
                    class="img-preview-header border shadow-sm rounded-3"
                    style="width: 100px; height: 100px; object-fit: cover;"
                    onerror="this.src='<?= BASE_URL ?>assets/imgs/ins_setup/noImage.jpg'">
            </div>
            <div class="col">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <small class="text-muted d-block">หมวดหมู่</small>
                        <span class="fw-bold text-primary">
                            <?= htmlspecialchars($item['category_name']) ?>
                        </span>

                        <!-- ชนิดสาย -->
                        <div class="mt-2">
                            <small class="text-muted d-block">ชนิดสาย</small>
                            <span class="fw-bold text-dark">
                                <?= htmlspecialchars($item['cable_name'] ?: 'ไม่ระบุ') ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="btn-group shadow-sm" role="group">
                            <input type="radio" class="btn-check" name="status_selector" id="status_ready" value="1" 
                                <?= ($item['ref_atm_status_manual_id'] == 1) ? 'checked' : '' ?>>
                                <label class="btn btn-outline-success btn-sm px-2 py-1 fw-bold"
                                        for="status_ready"
                                        onclick="confirmStatusChange(this, 1, 'พร้อม', 'success')">พร้อม</label>

                            <input type="radio" class="btn-check" name="status_selector" id="status_training" value="3" 
                                <?= ($item['ref_atm_status_manual_id'] == 3) ? 'checked' : '' ?>>
                                <label class="btn btn-outline-warning btn-sm px-2 py-1 fw-bold text-dark"
                                        for="status_training"
                                        onclick="confirmStatusChange(this, 3, 'รอเทรน', 'warning')">รอเทรน</label>

                            <input type="radio" class="btn-check" name="status_selector" id="status_not_ready" value="2" 
                                <?= ($item['ref_atm_status_manual_id'] == 2) ? 'checked' : '' ?>>
                                <label class="btn btn-outline-danger btn-sm px-2 py-1 fw-bold"
                                        for="status_not_ready"
                                        onclick="confirmStatusChange(this, 2, 'ไม่พร้อม', 'danger')">ไม่พร้อม</label>
                        </div>
                        <input type="hidden" id="current_status_val" value="<?= $item['ref_atm_status_manual_id'] ?>">
                        
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                    <div class="small text-muted">
                        <i class="bi bi-person me-1"></i> แก้ไขโดย: <span class="fw-bold text-dark"><?= htmlspecialchars($item['updated_by'] ?: 'System') ?></span>
                        <span class="mx-2">|</span>
                        <i class="bi bi-clock-history"></i> อัปเดตล่าสุด: <?= date('d/m/Y H:i', strtotime($item['updated_at'] ?? $item['created_at'])) ?>
                    </div>
                    <!-- <div class="fw-bold small text-muted">
                        ชนิดสาย: <span class="text-dark"><?= htmlspecialchars($item['cable_name'] ?: 'ไม่ระบุ') ?></span>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="edit-tab-group shadow-sm">
        <ul class="nav nav-tabs nav-justified border-0" id="editTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link <?= $active_mode === 'basic' ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-basic">
                    <i class="bi bi-pencil-square me-2"></i>แก้ไขข้อมูลพื้นฐาน
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link <?= $active_mode === 'upload' ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-upload">
                    <i class="bi bi-images me-2"></i>อัปโหลดรูปภาพ
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link <?= $active_mode === 'sort' ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-sort">
                    <i class="bi bi-sort-numeric-down me-2"></i>จัดลำดับภาพ
                </button>
            </li>
        </ul>
    </div>

    <div class="card border-0 shadow-sm p-4 rounded-bottom-4">
        <form id="mainUploadForm" action="<?= BASE_URL ?>db/save_instrument.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="ins_id" value="<?= $ins_id ?>">
            <input type="hidden" name="mode" id="current_mode" value="<?= $active_mode ?>">

            <div class="tab-content" id="editTabContent">
                <div class="tab-pane fade <?= $active_mode === 'basic' ? 'show active' : '' ?>" id="tab-basic">
                    <?php include __DIR__ . '/edit_basic_ins.php'; ?>
                </div>
                <div class="tab-pane fade <?= $active_mode === 'upload' ? 'show active' : '' ?>" id="tab-upload">
                    <?php include __DIR__ . '/edit_img_ins.php'; ?>
                </div>
                <div class="tab-pane fade <?= $active_mode === 'sort' ? 'show active' : '' ?>" id="tab-sort">
                    <?php include __DIR__ . '/edit_sort_images.php'; ?>
                </div>
            </div>

            <div class="mt-5 border-top pt-4 text-center">
                <button type="submit" id="btnSubmit" class="btn btn-success btn-lg px-5 fw-bold shadow rounded-pill">
                    <i class="bi bi-save2-fill me-2"></i>
                    <span id="submit-text">
                        <?php if ($active_mode === 'basic'): ?>บันทึกข้อมูลพื้นฐาน
                        <?php elseif ($active_mode === 'upload'): ?>อัปโหลดรูปภาพ
                        <?php else: ?>บันทึกการจัดลำดับภาพ
                        <?php endif; ?>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeInput = document.getElementById('current_mode');
    const submitText = document.getElementById('submit-text');
    
    // ฟังก์ชันอัปเดต Mode
    const updateMode = (targetId) => {
        if (!targetId) return;
        
        let mode = 'basic';
        if(targetId === '#tab-upload') mode = 'upload';
        if(targetId === '#tab-sort') mode = 'sort';
        
        if (modeInput) {
            modeInput.value = mode;
            console.log('✅ Mode updated to:', mode); // Debug
        }
        
        if (submitText) {
            const texts = {
                'basic': 'บันทึกข้อมูลพื้นฐาน',
                'upload': 'อัปโหลดรูปภาพ',
                'sort': 'บันทึกการจัดลำดับภาพ'
            };
            submitText.innerText = texts[mode];
        }
        
        // อัปเดต URL
        const url = new URL(window.location);
        url.searchParams.set('mode', mode);
        window.history.replaceState({}, '', url);
    };

    // ดักจับการคลิกสลับ Tab
    const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabEls.forEach(el => {
        el.addEventListener('shown.bs.tab', function (event) {
            const targetId = event.target.getAttribute('data-bs-target');
            updateMode(targetId);
        });
    });

    // ตรวจสอบ mode จาก URL
    const urlParams = new URLSearchParams(window.location.search);
    const urlMode = urlParams.get('mode');
    console.log('📍 Mode from URL:', urlMode);
    console.log('📍 Current mode input value:', modeInput ? modeInput.value : 'null');
    
    if (urlMode && modeInput && modeInput.value !== urlMode) {
        modeInput.value = urlMode;
        console.log('🔄 Updated mode input to:', urlMode);
        
        // อัปเดตข้อความปุ่ม
        const texts = {
            'basic': 'บันทึกข้อมูลพื้นฐาน',
            'upload': 'อัปโหลดรูปภาพ',
            'sort': 'บันทึกการจัดลำดับภาพ'
        };
        if (submitText) submitText.innerText = texts[urlMode] || 'บันทึกข้อมูล';
        
        // เปิด tab ที่ถูกต้อง
        const targetTab = document.querySelector(`button[data-bs-target="#tab-${urlMode}"]`);
        if (targetTab) {
            const tab = new bootstrap.Tab(targetTab);
            tab.show();
        }
    }
    
    // ตรวจสอบค่าเริ่มต้น
    console.log('🔵 Initial mode value:', modeInput ? modeInput.value : 'null');

    // แจ้งเตือน Success
    if (urlParams.get('status') === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'บันทึกเรียบร้อย',
            toast: true,
            position: 'top-end',
            timer: 2000,
            showConfirmButton: false
        });
        // ลบ status ออกจาก URL
        urlParams.delete('status');
        const newUrl = window.location.pathname + '?' + urlParams.toString();
        window.history.replaceState({}, '', newUrl);
    }

    // จัดการตอนกดปุ่ม Save
    const mainForm = document.getElementById('mainUploadForm');
    if(mainForm) {
        // ลบ event listener เดิมถ้ามี
        const oldSubmit = mainForm._submitHandler;
        if (oldSubmit) mainForm.removeEventListener('submit', oldSubmit);
        
        const submitHandler = function(e) {
            // ตรวจสอบ mode ก่อนส่ง
            const currentTab = document.querySelector('.nav-link.active');
            if(currentTab) {
                const targetId = currentTab.getAttribute('data-bs-target');
                let mode = 'basic';
                if(targetId === '#tab-upload') mode = 'upload';
                if(targetId === '#tab-sort') mode = 'sort';
                
                if (modeInput) {
                    modeInput.value = mode;
                    console.log('📤 Before submit - mode set to:', mode);
                }
            }
            
            // Debug: แสดงค่าที่จะส่ง
            console.log('📤 FORM DATA - mode:', modeInput ? modeInput.value : 'null');
            console.log('📤 FORM DATA - ins_id:', document.querySelector('[name="ins_id"]')?.value);
            
            const btn = document.getElementById('btnSubmit');
            if (modeInput && modeInput.value === 'upload') {
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
                    if(btn) btn.disabled = false;
                    return;
                }
            }

            if(btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> กำลังบันทึก...';
            }
        };
        
        mainForm._submitHandler = submitHandler;
        mainForm.addEventListener('submit', submitHandler);
    }
});
// เเต้งเตือนปุ่ม
// * ฟังก์ชันเปลี่ยนสถานะและบันทึกทันที (AJAX)
//  */
function confirmStatusChange(element, newValue, statusText, colorType) {
    // ดึงค่าปัจจุบันจาก Hidden Input
    const currentStatusInput = document.getElementById('current_status_val');
    const currentVal = currentStatusInput ? currentStatusInput.value : '';
    
    // ดึง ID เครื่องตรวจจาก PHP Direct
    const ins_id = '<?= $ins_id ?>'; 
    // ดึง Path ไฟล์บันทึกจาก PHP Direct
    const saveUrl = '<?= BASE_URL ?>db/save_instrument.php'; 

    // ถ้ากดสถานะเดิม ไม่ต้องทำอะไร
    if (newValue == currentVal) return;

    const btnColors = { 'success': '#198754', 'warning': '#ffc107', 'danger': '#dc3545' };

    Swal.fire({
        title: 'ยืนยันการเปลี่ยนสถานะ?',
        text: `ต้องการเปลี่ยนเป็น "${statusText}" และบันทึกทันทีใช่หรือไม่?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'ใช่, เปลี่ยนเลย!',
        cancelButtonText: 'ยกเลิก',
        confirmButtonColor: btnColors[colorType],
        cancelButtonColor: '#6e7881',
        reverseButtons: false 
    }).then((result) => {
        if (result.isConfirmed) {
            // เตรียมข้อมูลส่งไปที่ PHP
            const formData = new FormData();
            formData.append('mode', 'basic');
            formData.append('ins_id', ins_id);
            formData.append('status_selector', newValue);

            // ส่งข้อมูลด้วย Fetch API
            fetch(saveUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log("Server Response:", data);
                
                // ตรวจสอบว่าในผลลัพธ์มีคำว่า OK หรือไม่ (รองรับกรณีมี Warning ปน)
                if (data.indexOf('OK') !== -1) { 
                    Swal.fire({
                        toast: true, 
                        position: 'top-end', 
                        icon: 'success',
                        title: `บันทึกสถานะ "${statusText}" เรียบร้อยแล้ว`,
                        showConfirmButton: false, 
                        timer: 1500
                    }).then(() => {
                        location.reload(); // รีโหลดเพื่อให้ข้อมูลผู้แก้ไขล่าสุดอัปเดต
                    });
                } else {
                    throw new Error(data);
                }
            })
            .catch(err => {
                console.error('Fetch Error:', err);
                Swal.fire('Error!', 'บันทึกไม่สำเร็จ กรุณาเช็คการเชื่อมต่อ Database', 'error');
                revertRadio(currentVal);
            });
        } else {
            // กดยกเลิก ให้ดีดปุ่มกลับไปสถานะเดิม
            revertRadio(currentVal);
        }
    });
}

/**
 * ฟังก์ชันดีด Radio Button กลับไปค่าเดิม
 */
function revertRadio(val) {
    const radios = document.getElementsByName('status_selector');
    radios.forEach(r => { 
        if (r.value == val) r.checked = true; 
    });
}

</script>

<script src="<?= BASE_URL ?>assets/js/sortable-logic.js?v=<?= time() ?>"></script>
<script src="<?= BASE_URL ?>assets/js/edit_img_ins.js"></script>
<script src="<?= BASE_URL ?>assets/js/edit.js"></script>

</body>
</html>