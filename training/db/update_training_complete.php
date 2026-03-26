<?php
/* instrument/training/db/update_training_complete.php */
session_start();
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../../config/permission.php';

// เช็คสิทธิ์ (ต้องเป็นสิทธิ์ 2 หรือ 3 เท่านั้นถึงจะกดบันทึกได้)
$user_level = isset($_SESSION['user_instrument']) ? (int)$_SESSION['user_instrument'] : 0;
if ($user_level < 1) {
    die("คุณไม่มีสิทธิ์ดำเนินการในส่วนนี้");
}

$db = db();
$db->set_charset('utf8mb4');

// รับค่าจาก URL
$training_id = isset($_GET['training_id']) ? (int)$_GET['training_id'] : 0;
$ins_ids = isset($_GET['ins_ids']) ? $_GET['ins_ids'] : ''; // รับมาเป็น string "1,2,3"

if ($training_id > 0 && !empty($ins_ids)) {
    
    // เริ่ม Transaction เพื่อความปลอดภัยของข้อมูล
    $db->begin_transaction();

    try {
        // 1. อัปเดตสถานะเครื่องตรวจในตาราง automate_model ให้เป็น 'พร้อม' (ID = 1)
        // ใช้ WHERE IN ($ins_ids) เพื่ออัปเดตหลายเครื่องใน Query เดียว
        $sql_update_ins = "UPDATE automate_model 
                           SET ref_atm_status_manual_id = 1 
                           WHERE atm_model_id IN ($ins_ids)";
        
        if (!$db->query($sql_update_ins)) {
            throw new Exception("ไม่สามารถอัปเดตสถานะเครื่องตรวจได้: " . $db->error);
        }

        // 2. อัปเดตสถานะการนัดหมายในตาราง instrument_training ให้เป็น 'เสร็จสิ้น' (ID = 1)
        $sql_update_train = "UPDATE instrument_training 
                             SET training_status = 1 
                             WHERE training_id = $training_id";
        
        if (!$db->query($sql_update_train)) {
            throw new Exception("ไม่สามารถอัปเดตสถานะการเทรนได้: " . $db->error);
        }

        // บันทึกการเปลี่ยนแปลงทั้งหมด
        $db->commit();

        // ส่งกลับไปหน้าประวัติพร้อมแจ้งเตือนสำเร็จ
        header("Location: ?act=training_history&status=update_success");
        exit;

    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาดให้ยกเลิกสิ่งที่ทำมาทั้งหมด (Rollback)
        $db->rollback();
        header("Location: ?act=training_history&status=error&msg=" . urlencode($e->getMessage()));
        exit;
    }

} else {
    // ข้อมูลไม่ครบ
    header("Location: ?act=training_history&status=error&msg=" . urlencode("ข้อมูลไม่ถูกต้อง"));
    exit;
}
?>