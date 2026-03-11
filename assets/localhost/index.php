<?php
session_start();
// -------------------------------
// index.php (Simple & Beginner Friendly)
// แสดงรายการเครื่องตรวจ + ค้นหาแบบง่าย
// -------------------------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/db.php';    // ต้องมีฟังก์ชัน db() คืนค่า mysqli connection
$connpeuy = db();
$connpeuy->set_charset('utf8mb4');

// ---------- 1) รับพารามิเตอร์ค้นหา ----------
$kw          = isset($_GET['kw']) ? trim($_GET['kw']) : '';      // คีย์เวิร์ดชื่อเครื่อง
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0; // หมวดหมู่

// ---------- 2) โหลดตัวเลือกหมวดหมู่ (ใช้กับ dropdown) ----------
$cats = [];
$catSql = "SELECT categories_id, name FROM instrument_categories WHERE is_active='Y' ORDER BY name";
if ($res = $connpeuy->query($catSql)) {
    while ($row = $res->fetch_assoc()) {
        $cats[] = $row;
    }
    $res->free();
} else {
    // กรณีอ่านหมวดหมู่ไม่ได้ ให้เป็นลิสต์ว่าง และแสดง error เล็กน้อยใน UI
    $cats = [];
}

// ---------- 3) สร้าง SQL หลักสำหรับรายการเครื่องตรวจ ----------
$sql = "
SELECT 
    i.ins_id,
    i.name,
    i.equipment_image,
    i.created_at,
    c.name       AS category_name,
    t.cable_name AS cable_name
FROM instruments i
LEFT JOIN instrument_categories  c ON c.categories_id = i.category_id
LEFT JOIN instrument_cable_types t ON t.cable_id      = i.cable_type_id
WHERE 1=1
";

// เงื่อนไขค้นหาแบบง่าย
$params = [];
$types  = '';

if ($kw !== '') {
    $sql    .= " AND i.name LIKE ? ";
    $params[] = '%' . $kw . '%';
    $types   .= 's';
}
if ($category_id > 0) {
    $sql    .= " AND i.category_id = ? ";
    $params[] = $category_id;
    $types   .= 'i';
}

$sql .= " ORDER BY i.update_at DESC, i.created_at DESC";

// ใช้ Prepared Statement เพื่อความปลอดภัย
$stmt = $connpeuy->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// ---------- 4) ฟังก์ชันช่วยแปลง path รูป ----------
function img_src(?string $rel): string {
    if (!$rel) return 'https://via.placeholder.com/120x80?text=No+Image';
    // ป้องกันมี slash เกินขอบเขต
    $rel = ltrim($rel, '/');
    return "/xct/instrument/" . htmlspecialchars($rel, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>รายการเครื่องตรวจ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- ใช้ Bootstrap 5 จาก CDN (มือใหม่แก้ไขง่าย) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .thumb { width: 120px; height: 80px; object-fit: cover; border-radius: 8px; }
    .table td, .table th { vertical-align: middle; }
    .badge-soft { background: #eef2ff; color: #1d4ed8; }
  </style>
</head>
<body class="bg-light">
  <div class="container py-4">
    <div class="d-flex align-items-center mb-3">
      <h1 class="h3 mb-0">รายการเครื่องตรวจ</h1>
      <!-- <a class="btn btn-primary ms-auto" href="add_instrument.php">+ เพิ่มเครื่องตรวจ</a> -->
      <a class="btn btn-primary ms-auto" href="/xct/alt/instrument?act=manual_add">+ เพิ่มเครื่องตรวจ</a>
    </div>

    <!-- ฟอร์มค้นหาแบบง่าย -->
    <form class="card card-body mb-4 shadow-sm" method="get" action="">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">ค้นหาชื่อเครื่อง</label>
          <input type="text" name="kw" class="form-control" placeholder="พิมพ์ชื่อ เช่น XN-1000" value="<?= htmlspecialchars($kw) ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label">หมวดหมู่</label>
          <select name="category_id" class="form-select">
            <option value="0">-- ทั้งหมด --</option>
            <?php foreach ($cats as $c): ?>
              <option value="<?= (int)$c['categories_id'] ?>" <?= $category_id===(int)$c['categories_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
          <button class="btn btn-dark me-2" type="submit">ค้นหา</button>
          <a class="btn btn-outline-secondary" href="index.php">ล้างตัวกรอง</a>
        </div>
      </div>
      <?php if (empty($cats)): ?>
        <div class="text-danger mt-2">* โหลดหมวดหมู่ไม่สำเร็จ กรุณาตรวจสอบตาราง <code>categories</code></div>
      <?php endif; ?>
    </form>

    <!-- ตารางรายการ -->
    <div class="card shadow-sm">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th style="width:140px;">รูปภาพ</th>
              <th>ชื่อเครื่อง</th>
              <th>หมวดหมู่</th>
              <th>ชนิดสาย</th>
              <th>วันที่อัพเดท</th>
              <th style="width:220px;">การจัดการ</th>
            </tr>
          </thead>
          <tbody>
          <?php if ($result->num_rows === 0): ?>
            <tr><td colspan="6" class="text-center text-muted p-4">— ไม่พบข้อมูล —</td></tr>
          <?php else: ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td>
                  <img class="thumb" src="<?= htmlspecialchars(img_src($row['equipment_image'])) ?>" alt="cover">
                </td>
                <td>
                  <div class="fw-semibold"><?= htmlspecialchars($row['name']) ?></div>
                  <div class="small text-muted">#<?= (int)$row['ins_id'] ?></div>
                </td>
                <td>
                  <span class="badge rounded-pill bg-secondary-subtle text-secondary">
                    <?= htmlspecialchars($row['category_name'] ?: '—') ?>
                  </span>
                </td>
                <td>
                  <span class="badge rounded-pill badge-soft">
                    <?= htmlspecialchars($row['cable_name'] ?: '—') ?>
                  </span>
                </td>
                <td class="text-nowrap"><?= htmlspecialchars($row['created_at']) ?></td>
                <td class="text-nowrap">
                  <a class="btn btn-sm btn-outline-primary" href="controller.php?act=view&id=<?= (int)$row['ins_id'] ?>">ดู</a>
                  <a class="btn btn-sm btn-outline-warning" href="?act=edit&id=<?= (int)$row['ins_id'] ?>">แก้ไข</a>
                  
                </td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <p class="text-muted small mt-3">
      * หน้านี้ใช้ตาราง <code>instruments</code> เชื่อม <code>categories</code> (คอลัมน์ <code>categories_id</code>) และ <code>cable_types</code> (คอลัมน์ <code>cable_id</code>)
    </p>
  </div>

  <!-- Bootstrap JS (ถ้าต้องใช้ components) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
