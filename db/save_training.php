<?php
/* db/save_training.php */
// session_start();
require_once __DIR__ . '/db.php';
$conn = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic = $_POST['training_topic'];
    $location = $_POST['training_location'];
    $start = $_POST['training_start'];
    $end = $_POST['training_end'];
    $detail = $_POST['training_detail'];
    $ins_ids = $_POST['ins_ids'] ?? []; // Array ของ IDs
    $user = $_SESSION['full_name'] ?? 'System';

    // 1. บันทึกลงตารางหลัก instrument_training
    $stmt = $conn->prepare("INSERT INTO instrument_training (training_topic, training_location, training_start, training_end, training_detail, training_status, created_by) VALUES (?, ?, ?, ?, ?, '1', ?)");
    $stmt->bind_param("ssssss", $topic, $location, $start, $end, $detail, $user);
    $stmt->execute();
    $training_id = $conn->insert_id;

    if ($training_id > 0 && !empty($ins_ids)) {
        foreach ($ins_ids as $ins_id) {
            // 2. บันทึกลงตารางลูก instrument_training_items
            $stmt_item = $conn->prepare("INSERT INTO instrument_training_items (training_id, instrument_id) VALUES (?, ?)");
            $stmt_item->bind_param("ii", $training_id, $ins_id);
            $stmt_item->execute();

            // 3. อัปเดตสถานะเครื่องใน automate_model เป็น 3 (รอเทรน)
            $stmt_status = $conn->prepare("UPDATE automate_model SET ref_atm_status_manual_id = 3 WHERE atm_model_id = ?");
            $stmt_status->bind_param("i", $ins_id);
            $stmt_status->execute();
        }
    }

    header("Location: ../?act=manual_guide&status=train_success");
    exit;
}