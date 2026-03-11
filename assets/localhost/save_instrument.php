<?php
/* db/save_instrument.php */
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../config/paths.php';

$conn = db();
$conn->set_charset('utf8mb4');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST)) {
        die("ข้อมูลไม่ครบ: ไฟล์อาจใหญ่เกินไป");
    }

    /**
     * แก้ไขจุดนี้: ตรวจสอบการลบก่อน
     * ถ้าเป็นคำสั่งลบ ให้ประมวลผลแล้ว exit ทันที ไม่ต้องไปเช็คชื่อเครื่องด้านล่าง
     */
    if (isset($_POST['act']) && $_POST['act'] === 'delete') {
        $deter_id = (int)$_POST['id'];
        $ins_id = (int)$_POST['ins_id'];

        $stmt = $conn->prepare("SELECT file_name FROM instrument_determination WHERE deter_id = ?");
        $stmt->bind_param("i", $deter_id);
        $stmt->execute();
        $file = $stmt->get_result()->fetch_assoc();

        if ($file) {
            $fullPath = FILE_PATH . $file['file_name'];
            if (file_exists($fullPath)) unlink($fullPath);

            $delStmt = $conn->prepare("DELETE FROM instrument_determination WHERE deter_id = ?");
            $delStmt->bind_param("i", $deter_id);
            $delStmt->execute();
        }
        echo "OK"; 
        exit(); // จบการทำงานตรงนี้เลย
    }

    /**
     * 2. ส่วนบันทึกข้อมูล (Update / Insert)
     * ระบบจะมาถึงตรงนี้เฉพาะเมื่อ "ไม่ใช่" การกดปุ่มลบเท่านั้น
     */
    $ins_id      = (int)($_POST['ins_id'] ?? 0);
    $name        = trim($_POST['name'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);

    // เช็คชื่อเครื่องเฉพาะตอนบันทึก/แก้ไขข้อมูล
    if ($name === '' || $category_id <= 0) {
        die("ข้อมูลไม่ครบ: กรุณาระบุชื่อเครื่องตรวจ");
    }

    // ... ส่วนการ INSERT/UPDATE เดิมของคุณ ...
}