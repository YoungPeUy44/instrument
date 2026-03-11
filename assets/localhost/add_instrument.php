<?php
require __DIR__ . '/db.php';
$conn = db();

// categories
$cats = [];
$r = $conn->query("SELECT categories_id, name FROM instrument_categories WHERE is_active='Y'");
while ($row = $r->fetch_assoc()) $cats[] = $row;

// cables
$cables = [];
$r = $conn->query("SELECT cable_id, cable_name FROM instrument_cable_types WHERE cable_is_active='Y'");
while ($row = $r->fetch_assoc()) $cables[] = $row;
?>
<h2>เพิ่มเครื่องตรวจ</h2>

<form method="post" action="controller.php?act=save">
  ชื่อเครื่อง*<br>
  <input name="name" required><br><br>

  หมวดหมู่*<br>
  <select name="category_id" required>
    <option value="">-- เลือก --</option>
    <?php foreach ($cats as $c): ?>
      <option value="<?= $c['categories_id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
    <?php endforeach; ?>
  </select><br><br>

  ชนิดสาย<br>
  <select name="cable_type_id">
    <option value="">-- ไม่ระบุ --</option>
    <?php foreach ($cables as $t): ?>
      <option value="<?= $t['cable_id'] ?>"><?= htmlspecialchars($t['cable_name']) ?></option>
    <?php endforeach; ?>
  </select><br><br>

  รายละเอียดการตั้งค่า<br>
  <textarea name="config_text"></textarea><br><br>

  <button type="submit">บันทึก</button>
</form>
