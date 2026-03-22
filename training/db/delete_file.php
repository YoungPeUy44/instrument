<?php
require __DIR__ . '/../config/paths.php';
require __DIR__ . '/db.php';

$type   = $_GET['type'] ?? '';
$id     = (int)($_GET['id'] ?? 0);
$ins_id = (int)($_GET['ins_id'] ?? 0);

if (!$type || !$id || !$ins_id) {
    exit('Invalid request');
}

$conn = db();

// 1. ตรวจสอบชื่อตารางและ PK ของแต่ละประเภทให้ถูกต้อง
switch ($type) {
    case 'setup': 
        $table = 'instrument_setup_images';
        $pk = 'setup_id';
        $subFolder = 'assets/imgs/'; // ปรับตาม PATH หลักที่คุณใช้ใน save_instrument.php
        $mode = 'sort'; // ลบเสร็จให้กลับไปหน้าจัดลำดับ
        break;
    case 'run':   
        $table = 'instrument_run_images';
        $pk = 'run_id';
        $subFolder = 'assets/imgs/';
        $mode = 'sort';
        break;
    case 'det':   
        $table = 'instrument_determination';
        $pk = 'deter_id';
        $subFolder = 'assets/files/determination/'; 
        $mode = 'basic'; // ลบไฟล์เอกสารให้กลับไปหน้าข้อมูลพื้นฐาน
        break;
    default: 
        exit('Invalid type');
}

// 2. ขั้นตอนการลบไฟล์จริงออกจาก Folder
$stmt = $conn->prepare("SELECT file_name FROM {$table} WHERE {$pk} = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

// if ($res) {
//     $fileName = basename($res['file_name']); 
//     $targetFile = $_SERVER['DOCUMENT_ROOT'] . "/xct/alt/instrument/" . $subFolder . $fileName;

//     if (file_exists($targetFile)) {
//         unlink($targetFile); // ลบไฟล์จาก disk
//     }
// }
if ($res) {
    $fileName = basename($res['file_name']); 
    // ⭐ แนะนำให้ใช้ PATH ที่ตั้งค่าไว้ใน paths.php เพื่อความแม่นยำ
    $targetFile = ($type === 'det') ? FILE_PATH . $fileName : IMG_PATH . $fileName;

    if (file_exists($targetFile)) {
        unlink($targetFile); // ลบไฟล์ออกจาก Server
    }
}

// 3. ขั้นตอนการลบข้อมูลใน Database
$stmt_del = $conn->prepare("DELETE FROM {$table} WHERE {$pk} = ?");
$stmt_del->bind_param("i", $id);
$stmt_del->execute();

// ⭐ 4. Redirect กลับไปยังหน้า Edit พร้อมระบุ Mode และ Status เพื่อให้แสดง Toast
header("Location: " . BASE_URL . "?act=edit&id={$ins_id}&mode={$mode}&status=success");
exit;

// header("Location: " . BASE_URL . "/?act=edit&id={$ins_id}");
// exit;
