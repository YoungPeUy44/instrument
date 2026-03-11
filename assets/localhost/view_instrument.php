<?php
require __DIR__ . '/db.php';
$conn = db();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) exit('Invalid ID');

$ins_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($ins_id <= 0) {
    http_response_code(404);
    exit("ไม่พบข้อมูล (ID ไม่ถูกต้อง)");
}

// -------------------------------
// 2) ดึงข้อมูลเครื่องตรวจ
// -------------------------------
$sql = "
SELECT 
  i.ins_id, i.name, i.equipment_image, i.config_text,
  i.created_at, i.update_at,
  c.name AS category_name,
  t.cable_name AS cable_name
FROM instruments i
LEFT JOIN instrument_categories  c ON c.categories_id = i.category_id
LEFT JOIN instrument_cable_types t ON t.cable_id      = i.cable_type_id
WHERE i.ins_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ins_id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$item) {
    http_response_code(404);
    exit("ไม่พบข้อมูลเครื่องตรวจ");
}

// -------------------------------
// 3) ดึงภาพ Setup
// -------------------------------
$setup = [];
$q1 = $conn->prepare("
    SELECT setup_id, file_name, sort_order 
    FROM instrument_setup_images 
    WHERE instrument_id=? 
    ORDER BY sort_order ASC, setup_id ASC
");
$q1->bind_param("i", $ins_id);
$q1->execute();
$r1 = $q1->get_result();
while ($row = $r1->fetch_assoc()) $setup[] = $row;
$q1->close();

// -------------------------------
// 4) ดึงภาพ Run
// -------------------------------
$run = [];
$q2 = $conn->prepare("
    SELECT run_id, file_name, sort_order, created_at 
    FROM instrument_run_images 
    WHERE instrument_id=? 
    ORDER BY sort_order ASC, run_id ASC
");
$q2->bind_param("i", $ins_id);
$q2->execute();
$r2 = $q2->get_result();
while ($row = $r2->fetch_assoc()) $run[] = $row;
$q2->close();

// -------------------------------
// 5) ดึงไฟล์ Determination
// -------------------------------
$det = [];
$q3 = $conn->prepare("
    SELECT deter_id, file_name, original_name, mime_type 
    FROM instrument_determination 
    WHERE instrument_id=? 
    ORDER BY deter_id DESC
");
$q3->bind_param("i", $ins_id);
$q3->execute();
$r3 = $q3->get_result();
while ($row = $r3->fetch_assoc()) $det[] = $row;
$q3->close();

// -------------------------------
// 6) ฟังก์ชัน path ของไฟล์/รูป
// -------------------------------
function asset_src(string $rel): string {
    $rel = ltrim($rel, '/');
    // แปลงเป็น path สมบูรณ์ของระบบที่คุณใช้อยู่
    return "/xct/instrument/" . htmlspecialchars($rel, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8">
<title>รายละเอียดเครื่องตรวจ | <?= htmlspecialchars($item['name']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.cover { width: 320px; height: 200px; object-fit: cover; border-radius: 12px; border: 1px solid #e5e7eb; }
.grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px,1fr)); gap: 12px; }
.grid img { width:100%; height:120px; object-fit:cover; border-radius: 10px; border:1px solid #e5e7eb; }
.chip { padding: .35rem .75rem; border-radius: 999px; background: #eef2ff; color:#1d4ed8; display:inline-block; }
pre.config { white-space:pre-wrap; background:#0f172a; color:#e2e8f0; padding:1rem; border-radius:.5rem; }
</style>
</head>
<body class="bg-light">

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex align-items-center mb-3">
        <h1 class="h4 mb-0">รายละเอียดเครื่องตรวจ</h1>
        <div class="ms-auto">
            <a class="btn btn-outline-secondary" href="controller.php?act=back">ย้อนกลับ</a>
            <a class="btn btn-warning" href="?act=edit&id=<?= $item['ins_id'] ?>">แก้ไข</a>
            <a class="btn btn-dark" href="?act=re_images&id=<?= $item['ins_id'] ?>">จัดลำดับภาพ</a>
        </div>
    </div>

    <!-- ข้อมูลหลัก -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-auto">
                    <img class="cover" src="<?= asset_src($item['equipment_image']) ?>">
                </div>
                <div class="col">
                    <h2 class="h4"><?= htmlspecialchars($item['name']) ?></h2>
                    <div class="text-muted small mb-2">
                        #<?= $item['ins_id'] ?>  
                        • เพิ่มเมื่อ <?= $item['created_at'] ?>  
                        • แก้ไขล่าสุด <?= $item['update_at'] ?>
                    </div>

                    <div class="mb-2">
                        <span class="chip"><?= htmlspecialchars($item['category_name']) ?></span>
                        <span class="chip"><?= htmlspecialchars($item['cable_name']) ?></span>
                    </div>

                    <?php if (!empty($item['config_text'])): ?>
                    <div class="mt-3">
                        <div class="fw-semibold mb-1">Config Text</div>
                        <pre class="config"><?= htmlspecialchars($item['config_text']) ?></pre>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Setup Images -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">ภาพตั้งค่าเครื่องตรวจ (Setup)</div>
        <div class="card-body">
            <?php if (empty($setup)): ?>
                <div class="text-muted">— ยังไม่มีภาพตั้งค่า —</div>
            <?php else: ?>
            <div class="grid">
                <?php foreach ($setup as $s): ?>
                <a href="<?= asset_src($s['file_name']) ?>" target="_blank">
                    <img src="<?= asset_src($s['file_name']) ?>">
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Run Images -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">ภาพการใช้งาน (Run)</div>
        <div class="card-body">
            <?php if (empty($run)): ?>
                <div class="text-muted">— ยังไม่มีภาพการใช้งาน —</div>
            <?php else: ?>
            <div class="grid">
                <?php foreach ($run as $r): ?>
                <a href="<?= asset_src($r['file_name']) ?>" target="_blank">
                    <img src="<?= asset_src($r['file_name']) ?>">
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Determination Files -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">ไฟล์ Determination</div>
        <div class="card-body">
            <?php if (empty($det)): ?>
                <div class="text-muted">— ยังไม่มีไฟล์ —</div>
            <?php else: ?>
            <?php foreach ($det as $d): ?>
                <div class="p-2 border rounded d-flex justify-content-between mb-2">
                    <div>
                        <div class="fw-bold"><?= htmlspecialchars($d['original_name']) ?></div>
                        <div class="small text-muted"><?= $d['mime_type'] ?></div>
                    </div>
                    <a class="btn btn-sm btn-outline-primary" 
                       href="<?= asset_src($d['file_name']) ?>"
                       target="_blank">ดาวน์โหลด</a>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>

</body>
</html>
