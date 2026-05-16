<?php
/* view_instrument.php */
require __DIR__ . '/../config/paths.php';
require __DIR__ . '/../config/helpers.php';
require __DIR__ . '/../db/db.php';

$conn = db();
$conn->set_charset('utf8mb4');

$ins_id = (int)($_GET['id'] ?? 0);
if ($ins_id <= 0) exit('Invalid ID');

// 1) โหลดข้อมูลหลักพร้อม Join (ดึงชื่อรุ่นและชื่อหมวดหมู่)
$stmt = $conn->prepare("
    SELECT 
        i.*, 
        m.atm_model_name AS name,           
        c.atm_category_name AS category_name, 
        t.cable_name, 
        t.cable_pic
    FROM instruments i
    INNER JOIN automate_model m ON i.ins_id = m.atm_model_id 
    INNER JOIN automate_category c ON m.ref_atm_category_id = c.atm_category_id
    LEFT JOIN instrument_cable_types t ON t.cable_id = i.cable_type_id
    WHERE i.ins_id = ?
");
$stmt->bind_param("i", $ins_id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

if (!$item) exit('ไม่พบคู่มือเครื่องตรวจ');

// 2) โหลดข้อมูลภาพและไฟล์
$setup = $conn->query("SELECT * FROM instrument_setup_images WHERE instrument_id = $ins_id ORDER BY sort_order ASC");
$run   = $conn->query("SELECT * FROM instrument_run_images WHERE instrument_id = $ins_id ORDER BY sort_order ASC");
$det   = $conn->query("SELECT * FROM instrument_determination WHERE instrument_id = $ins_id");
?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View: <?= htmlspecialchars($item['name']) ?></title>
    <?php require_once __DIR__ . '/../config/favicon.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .img-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 8px; }
        .img-grid img { width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; transition: 0.2s; }
        .img-grid img:hover { transform: scale(1.05); }
        .main-footer { padding: 20px 0; background: #fff; border-top: 1px solid #dee2e6; margin-top: 40px; }
        textarea#configTarget { background-color: #f8f9fa !important; color: #198754 !important; font-family: 'Courier New', Courier, monospace; }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-dark">
            <i class="bi bi-display me-2 text-primary"></i><?= htmlspecialchars($item['name']) ?>
        </h4>      
            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill" onclick="smartBack();">
                <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
            </button>
    </div>

    <div class="card mb-4 shadow-sm border-0 rounded-3">
        <div class="card-body p-3 p-md-4">
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <img src="<?= img_src($item['equipment_image']) ?>" 
                         class="img-fluid rounded border shadow-sm w-100" 
                         style="max-width: 320px;"
                         onerror="this.src='<?= BASE_URL ?>assets/imgs/ins_setup/noImage.jpg'">
                </div>
                <div class="col-md-8">
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <small class="text-muted d-block text-uppercase small fw-bold">หมวดหมู่</small>
                            <span class="text-primary fw-bold"><?= htmlspecialchars($item['category_name'] ?: 'ไม่ระบุ') ?></span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block text-uppercase small fw-bold">ชนิดสาย</small>
                            <span class="fw-bold"><?= htmlspecialchars($item['cable_name'] ?: 'ไม่ระบุ') ?></span>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center border-bottom">
                            <span class="small fw-bold"><i class="bi bi-file-earmark-code me-1 text-success"></i> Configuration</span>
                            <button class="btn btn-sm btn-outline-primary border-0" onclick="copyConfig()" id="btnCopy">
                                <i class="bi bi-copy me-1"></i> คัดลอก
                            </button>
                        </div>
                        <textarea id="configTarget" class="form-control border-0 p-3" rows="5" readonly><?= htmlspecialchars($item['config_text']) ?></textarea>
                    </div>

                    <div class="mt-3">
                        <small class="text-muted"><i class="bi bi-clock me-1"></i> ล่าสุด: <?= htmlspecialchars($item['updated_at'] ?? $item['live_event']) ?></small>
                        <span class="mx-2 text-muted">|</span>
                        <small class="text-muted"><i class="bi bi-person me-1"></i> แก้ไขโดย: <?= htmlspecialchars($item['updated_by'] ?: 'System') ?></small>
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
                            <img src="<?= img_src($s['file_name']) ?>" onerror="this.src='<?= BASE_URL ?>assets/imgs/ins_setup/noImage.jpg'">
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
                            <img src="<?= img_src($r['file_name']) ?>" onerror="this.src='<?= BASE_URL ?>assets/imgs/ins_setup/noImage.jpg'">
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-muted my-3 small">ยังไม่มีภาพขั้นตอนการใช้งาน</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

     <div class="card mb-4 shadow-sm border-0">
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
                             onerror="this.src='<?= BASE_URL ?>assets/imgs/ins_setup/noImage.jpg'">
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

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= BASE_URL ?>assets/js/historyback.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Fancybox.bind("[data-fancybox]", { Carousel: { transition: "slide" } });
    });

    function copyConfig() {
        const configArea = document.getElementById('configTarget');
        navigator.clipboard.writeText(configArea.value).then(() => {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'คัดลอก Config แล้ว', showConfirmButton: false, timer: 1500 });
        });
    }
</script>
</body>
</html>