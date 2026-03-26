<?php
/* xct\alt\instrument\training\db\update_status.php */
session_start();
ob_start();

// 1. เชื่อมต่อฐานข้อมูล
if (!function_exists('db')) {
    // ถอยจาก db/ ไปหา training/db/db.php
    require_once __DIR__ . '/db.php'; 
}

require_once __DIR__ . '/../config/paths.php';
$conn = db();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$status = isset($_GET['status']) ? (int)$_GET['status'] : 2; // 2 = ยกเลิก

if ($id > 0) {
    // --- เริ่มการดึงข้อมูลเพื่อสร้าง Payload (ล้อตาม save_training) ---
    $instrument_list = [];
    $topic = $location = $start_mysql = $end_mysql = $detail = "";

    // 1. ดึงข้อมูลหลักของการเทรน
    $sql_info = "SELECT * FROM instrument_training WHERE training_id = ?";
    $stmt_info = $conn->prepare($sql_info);
    $stmt_info->bind_param("i", $id);
    $stmt_info->execute();
    $res_info = $stmt_info->get_result();
    $data = $res_info->fetch_assoc();

    if ($data) {
        $topic = $data['training_topic'];
        $location = $data['training_location'];
        $start_mysql = $data['training_start'];
        $end_mysql = $data['training_end'];
        $detail = $data['training_detail'];
        $cancel_reason = "ยกเลิกการเทรนเครื่องตรวจ";

        // 2. ดึงข้อมูลเครื่องตรวจ (ดึงทั้ง ID และ Name มาทำเป็น Array ของ Object)
        $sql_ins = "SELECT ti.instrument_id, m.atm_model_name 
                    FROM instrument_training_items ti
                    JOIN automate_model m ON ti.instrument_id = m.atm_model_id
                    WHERE ti.training_id = ?";
        $stmt_ins = $conn->prepare($sql_ins);
        $stmt_ins->bind_param("i", $id);
        $stmt_ins->execute();
        $res_ins = $stmt_ins->get_result();
        
        while ($row_ins = $res_ins->fetch_assoc()) {
            $instrument_list[] = [
                'id' => $row_ins['instrument_id'],
                'name' => $row_ins['atm_model_name']
            ];
        }

        // 3. จัดการชื่อผู้ยกเลิก (cancel_by) ดึงจาก Session เหมือน save_training
        $fname = $_SESSION['user_firstname'] ?? '';
        $lname = $_SESSION['user_lastname'] ?? '';
        $session_full_name = trim($fname . " " . $lname);
        
        $cancel_by = !empty($session_full_name) ? $session_full_name : ($_SESSION['full_name'] ?? ($_SESSION['username'] ?? 'System'));

        // --- สร้าง Payload สำหรับส่งแจ้งเตือน ---
        $line_payload = [
            'topic'       => $topic,
            'location'    => $location,
            'start'       => $start_mysql,
            'end'         => $end_mysql,
            'detail'      => $detail,
            'instruments' => $instrument_list, 
            'cancel_by'   => $cancel_by,
            'cancel_reason' => $cancel_reason
        ];
        

               // ===============================
        // ||       NOTIFY TYPE         ||
        // ===============================
        // $notify_type = 'debug';
        
        $notify_type = 'cancel';
        include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instruments/line_notify_training.php');
    }

    // --- เริ่มกระบวนการ UPDATE ฐานข้อมูล ---
    $conn->begin_transaction();
    try {
        // 1. อัปเดตสถานะการเทรนเป็น 2 (ยกเลิก)
        $stmt_up = $conn->prepare("UPDATE instrument_training SET training_status = ? WHERE training_id = ?");
        $stmt_up->bind_param("ii", $status, $id);
        $stmt_up->execute();

        // 2. คืนค่าสถานะเครื่องตรวจเป็น 3 (ไม่พร้อม) ตามเงื่อนไขคุณ
        if ($status == 2) {
            $stmt_model = $conn->prepare("UPDATE automate_model SET ref_atm_status_manual_id = 3 
                                          WHERE atm_model_id IN (SELECT instrument_id FROM instrument_training_items WHERE training_id = ?)");
            $stmt_model->bind_param("i", $id);
            $stmt_model->execute();
        }

        $conn->commit();

        
        
        // Redirect กลับหน้าประวัติผ่าน Controller
        header("Location: " . BASE_URL . "?act=manual_guide&status=cancel_success");
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href = 'index.php?act=manual_guide';</script>";
        exit;
    }
}
ob_end_flush();