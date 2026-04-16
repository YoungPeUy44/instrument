<?php
/* instrument/training/db/update_training_complete.php */
session_start();
ob_start();
// echo "ID: ".$training_id." | INS: ".$ins_ids; exit;
// echo '<pre>';
// print_r($_POST);
// echo '<br>';
// exit();

require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../../config/permission.php';

// เช็คสิทธิ์ (ต้องเป็นสิทธิ์ 1 ขึ้นไป)
$user_level = isset($_SESSION['user_instrument']) ? (int)$_SESSION['user_instrument'] : 0;
if ($user_level < 1) {
    die("คุณไม่มีสิทธิ์ดำเนินการในส่วนนี้");
}

$db = db();
$db->set_charset('utf8mb4');

$training_id = isset($_GET['training_id']) ? (int)$_GET['training_id'] : 0;
$ins_ids = isset($_GET['ins_ids']) ? $_GET['ins_ids'] : ''; 

if ($training_id > 0 && !empty($ins_ids)) {
    
    // --- เริ่มการดึงข้อมูลเพื่อสร้าง Payload สำหรับ LINE Notify ---
    $instrument_list = [];
    $topic = $location = $start_mysql = $end_mysql = $detail = "";

    // 1. ดึงข้อมูลหลักของการเทรน
    $sql_info = "SELECT * FROM instrument_training WHERE training_id = ?";
    $stmt_info = $db->prepare($sql_info);
    $stmt_info->bind_param("i", $training_id);
    $stmt_info->execute();
    $res_info = $stmt_info->get_result();
    $data_info = $res_info->fetch_assoc();

    if ($data_info) {
        $topic = $data_info['training_topic'];
        $location = $data_info['training_location'];
        $start_mysql = $data_info['training_start'];
        $end_mysql = $data_info['training_end'];
        $detail = $data_info['training_detail'];

        // 2. ดึงชื่อเครื่องตรวจ (ดึงจาก ID ที่ส่งมา)
        $sql_ins = "SELECT atm_model_id, atm_model_name FROM automate_model WHERE atm_model_id IN ($ins_ids)";
        $res_ins = $db->query($sql_ins);
        while ($row_ins = $res_ins->fetch_assoc()) {
            $instrument_list[] = [
                'id' => $row_ins['atm_model_id'],
                'name' => $row_ins['atm_model_name']
            ];
        }

        // 3. ชื่อผู้ยืนยัน
        $fname = $_SESSION['user_firstname'] ?? '';
        $lname = $_SESSION['user_lastname'] ?? '';
        $confirm_by = trim($fname . " " . $lname) ?: ($_SESSION['full_name'] ?? 'System');

        // --- สร้าง Payload สำหรับส่งแจ้งเตือน ---
        $line_payload = [
            'tid'           => (int)$training_id,
            'topic'       => $topic,
            'location'    => $location,
            'start'       => $start_mysql,
            'end'         => $end_mysql,
            'detail'      => $detail,
            'instruments' => $instrument_list, 
            'confirm_by' => $confirm_by // confirm_by        
        ];
        
        // echo '<pre>'; print_r($line_payload); echo '</pre>'; exit;

        // ===============================
        // ||       NOTIFY TYPE         ||
        // ===============================
        // $notify_type = 'debug';
        // $notify_type = 'confirm';
        // include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instruments/line_notify_training.php');
    }

    // --- เริ่มกระบวนการ UPDATE ฐานข้อมูล ---
    $db->begin_transaction();

    try {
        // 1. อัปเดตสถานะเครื่องตรวจเป็น 1 (พร้อม)
        $sql_update_ins = "UPDATE automate_model 
                           SET ref_atm_status_manual_id = 1, 
                                inst_training_status = 1,
                                atm_model_updatedBy = ? 
                           WHERE atm_model_id IN ($ins_ids)";
        $stmt1 = $db->prepare($sql_update_ins);
        $stmt1->bind_param("s", $confirm_by);
        $stmt1->execute();

        // 2. อัปเดตสถานะการนัดหมายเป็น 1 (เสร็จสิ้น)
        $sql_update_train = "UPDATE instrument_training 
                             SET training_status = 1, 
                                 confirmed_by = ?, 
                                 confirmed_at = NOW() 
                             WHERE training_id = ?";
        $stmt2 = $db->prepare($sql_update_train);
        $stmt2->bind_param("si", $confirm_by, $training_id);
        $stmt2->execute();

        $db->commit();

        // Redirect พร้อม status (อันเดียวกับที่ใช้เช็คใน JS)
        header("Location: ?act=manual_guide&status=update_success");
        exit;

    } catch (Exception $e) {
        $db->rollback();
        header("Location: ?act=training_history&status=error&msg=" . urlencode($e->getMessage()));
        exit;
    }

} else {
    header("Location: ?act=training_history&status=error");
    exit;
}
ob_end_flush();
?>