<?php
/* xct\alt\instrument\training\db\delete_training.php */
session_start();
ob_start();

// Security Check: ถ้าไม่ใช่ Role 3 ห้ามรันไฟล์นี้เด็ดขาด
// if (($_SESSION['user_instrument'] ?? 0) != 3) {
//     header("Location: index.php?act=manual_guide&status=no_permission");
//     exit;
// }

require_once __DIR__ . '/db.php';
$conn = db();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $conn->begin_transaction();
    try {
        // ลบข้อมูล Mapping
        $stmt1 = $conn->prepare("DELETE FROM instrument_training_items WHERE training_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        // ลบข้อมูลหลัก
        $stmt2 = $conn->prepare("DELETE FROM instrument_training WHERE training_id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();

        $conn->commit();
        header("Location: ?act=manual_guide&status=delete_success");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}