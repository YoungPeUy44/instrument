<?php
// re_images.php (version for instrument_* tables)
require __DIR__ . '/db.php';
$connpeuy = db();
$connpeuy->set_charset('utf8mb4');

function fail($msg, $code=400){ http_response_code($code); exit($msg); }

// อ่านค่าจาก POST เป็นหลัก; ถ้าไม่มีและเผลอเปิดด้วย GET จะลอง map ให้
$instrument_id = isset($_POST['instrument_id']) ? (int)$_POST['instrument_id']
              : (isset($_GET['instrument_id']) ? (int)$_GET['instrument_id'] : 0);

// เผื่อบางหน้าส่งมาเป็น id= แทน instrument_id (เช่นที่คุณเปิด URL ตรง ๆ)
if ($instrument_id <= 0 && isset($_GET['id'])) {
  $instrument_id = (int)$_GET['id'];
}

$type       = $_POST['type']  ?? $_GET['type']  ?? '';
$order_raw  = $_POST['order'] ?? $_GET['order'] ?? null;

if ($instrument_id <= 0) fail('instrument_id ว่างหรือไม่ถูกต้อง');
if (!in_array($type, ['setup','run'], true)) fail('type ต้องเป็น setup หรือ run');

// แปลง order ให้เป็น array ของ int
$order = [];
if (is_array($order_raw)) {
  $order = $order_raw;
} elseif (is_string($order_raw)) {
  $decoded = json_decode($order_raw, true);
  if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
    $order = $decoded;
  } elseif (preg_match('/^\s*\d+(?:\s*,\s*\d+)*\s*$/', $order_raw)) {
    $order = array_map('trim', explode(',', $order_raw));
  }
}
$order = array_values(array_filter(array_map('intval', (array)$order), fn($n)=>$n>0));
if (empty($order)) fail('order ว่าง หรือรูปแบบไม่ถูกต้อง (ต้องเป็น array ของ id รูป)');

// ✅ แก้ชื่อตารางให้ตรงกับฐาน
if ($type === 'setup') {
  $sql = "UPDATE instrument_setup_images SET sort_order=? WHERE setup_id=? AND instrument_id=?";
} else {
  $sql = "UPDATE instrument_run_images SET sort_order=? WHERE run_id=? AND instrument_id=?";
}

$stmt = $connpeuy->prepare($sql) ?: fail('เตรียมคำสั่ง SQL ไม่สำเร็จ: '.$connpeuy->error, 500);

$connpeuy->begin_transaction();
try {
  foreach($order as $idx=>$rowId){
    $sort = (int)$idx;
    $id   = (int)$rowId;
    $stmt->bind_param('iii', $sort, $id, $instrument_id);
    $stmt->execute();
  }
  $connpeuy->commit();
  echo 'OK';
} catch(Throwable $e) {
  $connpeuy->rollback();
  fail('อัปเดตลำดับไม่สำเร็จ: '.$e->getMessage(), 500);
} finally {
  $stmt->close();
}
