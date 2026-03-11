<?php
/* view_instrument.php */
require __DIR__ . '/../config/paths.php';
require __DIR__ . '/../config/helpers.php';
require __DIR__ . '/../db/db.php';

$conn = db();
$conn->set_charset('utf8mb4');

$ins_id = (int)($_GET['id'] ?? 0);
if ($ins_id <= 0) exit('Invalid ID');

// 1) โหลดข้อมูลหลักพร้อม Join (ใช้ i.update_at ให้ตรงกับฐานข้อมูลจริง)
// ⭐ 1) แก้ไข Query: เชื่อมด้วย ID และดึงชื่อจากตาราง automate
$stmt = $conn->prepare("
    SELECT 
        i.*, 
        m.atm_model_name AS name,           -- ดึงชื่อรุ่นมาตรฐาน
        c.atm_category_name AS category_name, -- ดึงชื่อหมวดหมู่มาตรฐาน
        t.cable_name, 
        t.cable_pic
    FROM instruments i
    INNER JOIN automate_model m ON i.ins_id = m.atm_model_id -- เชื่อมด้วย ID
    INNER JOIN automate_category c ON m.ref_atm_category_id = c.atm_category_id
    LEFT JOIN instrument_cable_types t ON t.cable_id = i.cable_type_id
    WHERE i.ins_id = ?
");
$stmt->bind_param("i", $ins_id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

if (!$item) exit('ไม่พบคู่มือเครื่องตรวจ');

// 2) โหลดไฟล์ที่เกี่ยวข้อง (คงเดิม)
$setup = $conn->query("SELECT * FROM instrument_setup_images WHERE instrument_id = $ins_id ORDER BY sort_order ASC");
$run = $conn->query("SELECT * FROM instrument_run_images WHERE instrument_id = $ins_id ORDER BY sort_order ASC");
$det = $conn->query("SELECT * FROM instrument_determination WHERE instrument_id = $ins_id");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/view.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/manual_guide.css">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold"><i class="bi bi-display me-2 text-primary"></i><?= htmlspecialchars($item['name']) ?></h4>
        <a href="<?= BASE_URL ?>?act=manual_guide" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="bi bi-chevron-left"></i> กลับหน้าหลัก
        </a>
    </div>

    <div class="card mb-4 shadow-sm border-0 rounded-3">
        <div class="card-body p-3 p-md-4">
            <div class="row g-4">
                <div class="col-md-5 col-lg-4 text-center">
                    <img src="<?= img_src($item['equipment_image']) ?>" 
                        class="img-fluid rounded border shadow-sm" 
                         onerror="this.src='https://placehold.co/250x180?text=No+Image'">
                </div>
                <div class="col-md-7 col-lg-8">
                    <div class="row g-2 mb-3">
                        <div class="col-6 border-end">
                            <small class="text-muted d-block">หมวดหมู่</small>
                            <span class="fw-bold text-primary"><?= htmlspecialchars($item['category_name'] ?: 'ไม่ระบุ') ?></span>
                        </div>
                        <div class="col-6 ps-3">
                            <small class="text-muted d-block">ชนิดสาย</small>
                            <span class="fw-bold"><?= htmlspecialchars($item['cable_name'] ?: 'ไม่ระบุ') ?></span>
                        </div>
                    </div>
                    
                    <div class="card mt-3 border-0 shadow-sm bg-light">
                        <div class="card-header fw-bold bg-white d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span><i class="bi bi-file-earmark-code me-1 text-success"></i> Config Text</span>
                            <button class="btn btn-sm btn-outline-primary border-0" onclick="copyConfig()" id="btnCopy">
                                <i class="bi bi-copy me-1"></i> Copy
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <textarea
                                id="configTarget"
                                class="form-control border-0 bg-transparent text-success p-3"
                                rows="6"
                                style="font-family: 'Courier New', monospace; font-size: 0.85rem; resize: none;"
                                readonly
                            ><?= htmlspecialchars($item['config_text']) ?></textarea>
                        </div>
                    </div>

                    <div class="mt-3 p-3 bg-white rounded border-start border-primary border-4 shadow-sm">
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-sm-auto">
                                <small class="text-muted">
                                    <i class="bi bi-clock-history me-1"></i>อัปเดตล่าสุด: 
                                    <span class="text-dark fw-bold"><?= htmlspecialchars($item['update_at'] ?? $item['created_at']) ?></span>
                                </small>
                            </div>
                            <div class="d-none d-sm-block col-auto text-muted">|</div>
                            <div class="col-12 col-sm-auto">
                                <small class="text-muted">
                                    <i class="bi bi-person-fill me-1"></i>โดย: 
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        <?= htmlspecialchars($item['updated_by'] ?: 'System') ?>
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold"><i class="bi bi-gear-wide-connected me-2 text-primary"></i>ขั้นตอนการติดตั้ง (Setup)</h6>
        </div>
        <div class="card-body p-3">
            <div class="img-grid">
                <?php if ($setup->num_rows > 0): ?>
                    <?php while($s = $setup->fetch_assoc()): ?>
                        <a href="<?= img_src($s['file_name']) ?>" class="thumb-link" data-fancybox="gallery-setup" data-caption="Setup Step">
                            <img src="<?= img_src($s['file_name']) ?>" onerror="this.src='https://placehold.co/250x180?text=No+Image'">
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-muted my-3 small">ยังไม่มีภาพขั้นตอนการติดตั้ง</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold text-success"><i class="bi bi-play-circle-fill me-2"></i>รูปภาพหน้างาน</h6>
        </div>
        <div class="card-body p-3">
            <div class="img-grid">
                <?php if ($run->num_rows > 0): ?>
                    <?php while($r = $run->fetch_assoc()): ?>
                        <a href="<?= img_src($r['file_name']) ?>" class="thumb-link" data-fancybox="gallery-run" data-caption="Run Step">
                            <img src="<?= img_src($r['file_name']) ?>" onerror="this.src='https://placehold.co/250x180?text=No+Image'">
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-muted my-3 small">ยังไม่มีภาพขั้นตอนการใช้งาน</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <label class="small text-muted d-block mb-3 fw-bold text-uppercase border-bottom pb-1">สายเชื่อมต่อ (CONNECTION CABLE)</label>
            <div class="text-center">
                <?php if (!empty($item['cable_pic'])): ?>
                    <a href="<?= BASE_URL ?>assets/imgs/<?= htmlspecialchars($item['cable_pic']) ?>" 
                       data-fancybox="gallery-cable" 
                       data-caption="สายเชื่อมต่อ: <?= htmlspecialchars($item['cable_name']) ?>">
                        <img src="<?= BASE_URL ?>assets/imgs/<?= htmlspecialchars($item['cable_pic']) ?>" 
                             class="img-fluid rounded border bg-white p-2 shadow-sm" 
                             style="width: 100%; max-width: 280px; height: auto; object-fit: contain; cursor: zoom-in;"
                             onerror="this.src='https://placehold.co/350x250?text=No+Cable+Image'">
                    </a>
                <?php else: ?>
                    <div class="bg-light rounded border d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 100%; max-width: 280px; aspect-ratio: 4/3;">
                        <i class="bi bi-usb-symbol text-muted" style="font-size: 4rem;"></i>
                    </div>
                <?php endif; ?>
                <div class="mt-3">
                    <h5 class="fw-bold text-dark mb-0"><?= htmlspecialchars($item['cable_name'] ?: 'ไม่ระบุ') ?></h5>
                    <small class="text-muted">คลิกที่รูปเพื่อขยายดูวิธีเข้าหัวสาย</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold"><i class="bi bi-file-earmark-zip-fill me-2 text-warning"></i>ไฟล์ Determination</h6>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <?php if ($det->num_rows > 0): ?>
                    <?php while($d = $det->fetch_assoc()): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-dark d-flex align-items-center text-truncate me-2">
                                <i class="bi bi-file-earmark-zip fs-4 text-secondary me-2"></i>
                                <span class="text-truncate small fw-bold"><?= htmlspecialchars($d['original_name']) ?></span>
                            </span>
                            <a href="<?= BASE_URL ?>assets/files/determination/<?= $d['file_name'] ?>" 
                               class="btn btn-sm btn-primary px-3 shadow-sm rounded-pill" target="_blank">เปิดไฟล์</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="p-4 text-center text-muted small">ยังไม่มีไฟล์เอกสารในระบบ</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. ตั้งค่า Fancybox สำหรับเลื่อนรูป
    Fancybox.bind("[data-fancybox]", {
        Carousel: { transition: "slide" },
        Toolbar: {
            display: {
                right: ["iterateZoom", "slideshow", "fullScreen", "download", "thumbs", "close"]
            }
        },
        Images: { zoom: true },
        Thumbs: { autoStart: false }
    });

    // 2. จัดการแจ้งเตือน Status
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'success') {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
            showConfirmButton: false,
            timer: 2000
        });
        const url = new URL(window.location);
        url.searchParams.delete('status');
        window.history.replaceState({}, '', url);
    }
});

function copyConfig() {
    const configArea = document.getElementById('configTarget');
    const btnCopy = document.getElementById('btnCopy');
    
    // ใช้ Clipboard API
    navigator.clipboard.writeText(configArea.value).then(() => {
        // เปลี่ยน UI ปุ่มชั่วคราวเพื่อให้รู้ว่า Copy แล้ว
        const originalHTML = btnCopy.innerHTML;
        btnCopy.innerHTML = '<i class="bi bi-check2 me-1"></i> Copied!';
        btnCopy.classList.replace('btn-outline-primary', 'btn-success');
        btnCopy.classList.add('text-white');

        // แสดง Toast แจ้งเตือน (ใช้ window.Toast ที่เราตั้งค่าไว้)
        if (typeof window.Toast !== 'undefined') {
            window.Toast.fire({
                icon: 'success',
                title: 'คัดลอก Config เรียบร้อย'
            });
        }

        // คืนค่าปุ่มกลับเป็นปกติหลังจาก 2 วินาที
        setTimeout(() => {
            btnCopy.innerHTML = originalHTML;
            btnCopy.classList.replace('btn-success', 'btn-outline-primary');
            btnCopy.classList.remove('text-white', 'btn-success');
        }, 2000);
        
    }).catch(err => {
        console.error('คัดลอกไม่สำเร็จ:', err);
        Swal.fire('Error', 'ไม่สามารถคัดลอกได้ กรุณาลองใหม่', 'error');
    });
}
</script>
<footer class="main-footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <!-- ดึงปีปัจจุบันมาแสดงอัตโนมัติ -->
                <strong>Copyright © 2025 - <?= date('Y') ?></strong>  Support The Operation, Executive Team
            </div>
            <div class="col-md-6 text-center text-md-end text-muted">
                <small>
                    <b>Version</b> 2.0
                </small>
            </div>
        </div>
    </div>
</footer>
</body>
</html>