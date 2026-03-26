<?php
/* xct\alt\instrument\training\db\update_status.php */
ob_start();

if (!function_exists('db')) {
    require_once 'training/db/db.php'; 
}
$db = db();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$status = isset($_GET['status']) ? (int)$_GET['status'] : 2; // Default เป็น 2 (ยกเลิก)

if ($id > 0) {
    $db->begin_transaction();
    try {
        // 1. อัปเดตสถานะการเทรนเป็น 2 (ยกเลิก)
        $stmt1 = $db->prepare("UPDATE instrument_training SET training_status = ? WHERE training_id = ?");
        $stmt1->bind_param("ii", $status, $id);
        $stmt1->execute();

        // 2. ถ้าเป็นการยกเลิก (status 2) ให้คืนค่าเครื่องเป็น 3 (ไม่พร้อม)
        if ($status == 2) {
            $sql2 = "UPDATE automate_model SET ref_atm_status_manual_id = 3 
                     WHERE atm_model_id IN (SELECT instrument_id FROM instrument_training_items WHERE training_id = ?)";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
        }

        $db->commit();
        // ดีดกลับหน้าเดิมผ่าน Controller
        echo "<script>window.location.href = 'index.php?act=manual_guide&status=cancel_success';</script>";
        exit;

    } catch (Exception $e) {
        $db->rollback();
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href = 'index.php?act=manual_guide';</script>";
        exit;
    }
}
ob_end_flush();