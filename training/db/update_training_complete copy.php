<?php
/* instrument/training/db/update_training_complete.php */
// save สถานะ เสร็จสิ้นเทรนเครื่องตรวจเสร็จเเล้ว สถานะเครื่องทั่งหมดจถูกเปลื่ยนเป็น หร้อม
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
    // 1. เตรียมชื่อผู้แก้ไขจาก Session
    $fname = $_SESSION['user_firstname'] ?? '';
    $lname = $_SESSION['user_lastname'] ?? '';
    $updated_by = trim($fname . " " . $lname) ?: 'System';

    // 2. อัปเดตสถานะเครื่องตรวจ (ใช้ prepare แทน query)
    $sql_update_ins = "UPDATE automate_model 
                       SET ref_atm_status_manual_id = 1, 
                           atm_model_updatedBy = ? 
                       WHERE atm_model_id IN ($ins_ids)";
    
    $stmt1 = $db->prepare($sql_update_ins);
    if (!$stmt1) {
        throw new Exception("Prepare Error (Table Model): " . $db->error);
    }
    
    $stmt1->bind_param("s", $updated_by);
    if (!$stmt1->execute()) {
        throw new Exception("Execute Error (Table Model): " . $stmt1->error);
    }

    // 3. อัปเดตสถานะการนัดหมายให้เป็น 'เสร็จสิ้น'
    $sql_update_train = "UPDATE instrument_training 
                         SET training_status = 1, 
                             confirmed_by = ?, 
                             confirmed_at = NOW() 
                         WHERE training_id = ?";
    
    // ตรงนี้ไม่มี ? ใช้ query ปกติได้ แต่แนะนำใช้ prepare เพื่อความปลอดภัยเหมือนกัน
    $stmt2 = $db->prepare($sql_update_train);
    if (!$stmt2) {
        throw new Exception("Prepare Error (Table Training): " . $db->error);
    }

    // bind_param: s (ชื่อ), i (ID การเทรน)
    $stmt2->bind_param("si", $updated_by, $training_id);
    
    if (!$stmt2->execute()) {
        throw new Exception("ไม่สามารถอัปเดตสถานะการยืนยันได้: " . $stmt2->error);
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