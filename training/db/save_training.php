<?php
/* db/save_training.php - แก้ไขการรับค่า created_by */
session_start();
// echo '<pre>';
// print_r($_POST);
// echo '<br>';
// exit();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../config/paths.php';

$conn = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic = trim($_POST['training_topic'] ?? '');
    $location = trim($_POST['training_location'] ?? '');
    $start = $_POST['training_start'] ?? '';
    $end = $_POST['training_end'] ?? '';
    $detail = trim($_POST['training_detail'] ?? '');
    $ins_ids = $_POST['ins_ids'] ?? [];
    
    // รับค่า created_by จากฟอร์มก่อน (สำคัญที่สุด)
    $created_by = trim($_POST['created_by'] ?? '');
    
    // ถ้าฟอร์มไม่มีค่า ให้ดึงจาก session
    if (empty($created_by) || $created_by == '') {
        $fname = $_SESSION['user_firstname'] ?? '';
        $lname = $_SESSION['user_lastname'] ?? '';
        $session_full_name = trim($fname . " " . $lname);
        $created_by = !empty($session_full_name) ? $session_full_name : '';
    }
    
    // ถ้ายังไม่มี ให้ดึงจาก full_name หรือ username
    if (empty($created_by) && !empty($_SESSION['full_name'])) {
        $created_by = $_SESSION['full_name'];
    }
    if (empty($created_by) && !empty($_SESSION['username'])) {
        $created_by = $_SESSION['username'];
    }
    
    // ถ้ายังไม่มี ให้ใช้ System
    if (empty($created_by)) {
        $created_by = 'System';
    }
    
    // ตรวจสอบข้อมูลเบื้องต้น
    if (empty($topic) || empty($location) || empty($start) || empty($end) || empty($ins_ids)) {
        $error = urlencode('กรุณากรอกข้อมูลให้ครบถ้วน');
        header("Location: " . BASE_URL . "?act=train&status=error&msg=" . $error);
        exit;
    }
    
    // ตรวจสอบเวลา
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    
    if ($end_ts <= $start_ts) {
        $error = urlencode('เวลาเริ่มต้นต้องน้อยกว่าเวลาสิ้นสุด');
        header("Location: " . BASE_URL . "?act=train&status=error&msg=" . $error);
        exit;
    }
    
    $start_mysql = date('Y-m-d H:i:s', $start_ts);
    $end_mysql = date('Y-m-d H:i:s', $end_ts);
    
    // เริ่ม Transaction
    $conn->begin_transaction();
    
    try {
        // ตรวจสอบชื่อตาราง
        $result = $conn->query("SHOW TABLES LIKE 'instrument_training'");
        $table_name = ($result->num_rows > 0) ? 'instrument_training' : 'instrument_training';
        
        // บันทึกข้อมูลหลัก
        $sql = "INSERT INTO $table_name (training_topic, training_location, training_start, training_end, training_detail, created_by, created_at) 
                VALUES (?, ?, ?, ?, ?, ?,  NOW())";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("ssssss", $topic, $location, $start_mysql, $end_mysql, $detail, $created_by);
        
        if (!$stmt->execute()) {
            throw new Exception("Insert failed: " . $stmt->error);
        }
        
        $training_id = $conn->insert_id;
        $success_count = 0;
        $instrument_list = []; // สร้าง Array ไว้เก็บข้อมูลเครื่องตรวจ (ID และ ชื่อ)
        

        // บันทึกเครื่องตรวจลง mapping table
        $stmt_item = $conn->prepare("INSERT INTO instrument_training_items (training_id, instrument_id) VALUES (?, ?)");
        // เตรียม SQL สำหรับดึงชื่อเครื่องตรวจ
        $stmt_get_name = $conn->prepare("SELECT atm_model_name FROM automate_model WHERE atm_model_id = ?");

        foreach ($ins_ids as $ins_id) {
            $ins_id = (int)$ins_id;
            if ($ins_id <= 0) continue;

            // 1. บันทึกข้อมูลลงตาราง Mapping
            $stmt_item->bind_param("ii", $training_id, $ins_id);
            $stmt_item->execute();
            
            // 2. ดึงชื่อเครื่องตรวจมาเก็บไว้สำหรับส่ง Line
            $stmt_get_name->bind_param("i", $ins_id);
            $stmt_get_name->execute();
            $res_name = $stmt_get_name->get_result();
            $row_name = $res_name->fetch_assoc();
            $ins_name = $row_name['atm_model_name'] ?? 'ไม่ทราบชื่อ';

            // เก็บเข้า Array เพื่อใส่ใน Payload
            $instrument_list[] = [
                'id' => $ins_id,
                'name' => $ins_name
            ];

            $success_count++;
            
            // 3. อัปเดตสถานะเครื่องตรวจ (ถ้ามี)
            $stmt_status = $conn->prepare("UPDATE automate_model SET ref_atm_status_manual_id = 3 WHERE atm_model_id = ?");
            $stmt_status->bind_param("i", $ins_id);
            $stmt_status->execute();
        }

        $conn->commit();

        // --- ส่วน Payload สำหรับส่งแจ้งเตือน ---
        $line_payload = [
            'topic'       => $topic,
            'location'    => $location,
            'start'       => $start_mysql,
            'end'         => $end_mysql,
            'detail'      => $detail,
            'instruments' => $instrument_list, // ส่งเป็น Array ของ Object (มีทั้ง ID และ Name)
            'created_by'  => $created_by
        ];

                // ===============================
        // ||       NOTIFY TYPE         ||
        // ===============================
        // $notify_type = 'debug';
        $notify_type = 'train';
        include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instruments/line_notify_training.php');
        
        header("Location: " . BASE_URL . "?act=training_history&status=train_success");
        exit;
        
    } catch (Exception $e) {
        $conn->rollback();
        $error_msg = urlencode($e->getMessage());
        header("Location: " . BASE_URL . "?act=train&status=error&msg=" . $error_msg);
        exit;
    }
    
} else {
    header("Location: " . BASE_URL . "?act=train");
    exit;
}
// LIne noti "$line_payload"
    // 'หัวข้อการเทรน' => $topic,
    // 'ตำแหน่ง' => $location,
    // 'start' => $start_mysql,
    // 'end' => $end_mysql,
    // 'รายละเอียด' => $detail,
    // 'ID เเละชื่อเครื่องตรวจ' => $instrument_list, 
    // 'created_by' => $created_by
?>