<?php
/* db/save_instrument.php */
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../config/paths.php';

$conn = db();
$conn->set_charset('utf8mb4');

// กำหนดขนาดไฟล์สูงสุด (Bytes)
$MAX_IMG_SIZE = 6 * 1024 * 1024;  // 5MB สำหรับรูปภาพ
$MAX_FILE_SIZE = 20 * 1024 * 1024; // 20MB สำหรับไฟล์เอกสาร ZIP/RAR

/**
 * 1. ส่วนจัดการการลบไฟล์ (Delete Actions)
 */
if (isset($_REQUEST['act'])) {
    $act = $_REQUEST['act'];
    $id = (int)($_REQUEST['id'] ?? 0);
    $ins_id = (int)($_REQUEST['ins_id'] ?? 0);

    if ($act === 'delete_file') {
        $stmt = $conn->prepare("SELECT file_name FROM instrument_determination WHERE deter_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $file = $stmt->get_result()->fetch_assoc();
        if ($file) {
            $fullPath = FILE_PATH . $file['file_name'];
            if (file_exists($fullPath)) unlink($fullPath);
            $delStmt = $conn->prepare("DELETE FROM instrument_determination WHERE deter_id = ?");
            $delStmt->bind_param("i", $id);
            $delStmt->execute();
        }
        echo "OK"; exit();
    }

    if ($act === 'delete_img') {
        $type = $_REQUEST['type'];
        $table = ($type === 'setup') ? 'instrument_setup_images' : 'instrument_run_images';
        $pk = ($type === 'setup') ? 'setup_id' : 'run_id';

        $stmt = $conn->prepare("SELECT file_name FROM $table WHERE $pk = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $file = $stmt->get_result()->fetch_assoc();
        if ($file) {
            $fullPath = IMG_PATH . $file['file_name'];
            if (file_exists($fullPath)) unlink($fullPath);
            $conn->query("DELETE FROM $table WHERE $pk = $id");
        }
        echo "OK"; exit();
    }
}

/**
 * 2. ส่วนการประมวลผลข้อมูลผ่าน POST
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ins_id = (int)($_POST['ins_id'] ?? 0);
    $mode = $_POST['mode'] ?? 'basic'; 

    // ดึงชื่อ-นามสกุลจาก Session เพื่อบันทึกผู้แก้ไข (updated_by)
    $fname = $_SESSION['user_firstname'] ?? $_SESSION['User_Firstname'] ?? '';
    $lname = $_SESSION['user_lastname'] ?? $_SESSION['User_Lastname'] ?? '';
    $full_name = trim($fname . " " . $lname);
    
    // หากไม่มีข้อมูลชื่อใน Session ให้บันทึกเป็น System
    if (empty($full_name)) { 
        $full_name = "System"; 
    }

    // เตรียม SQL Update หลักสำหรับตาราง instruments
    $updates = ["updated_at = NOW()", "updated_by = ?"];
    $params = [$full_name];
    $types = "s";

    // เตรียมชื่อไฟล์พื้นฐานสำหรับการอัปโหลด
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    if ($name == '') {
        $res_n = $conn->query("SELECT atm_model_name FROM automate_model WHERE atm_model_id = $ins_id");
        $row_n = $res_n->fetch_assoc();
        $name = $row_n['atm_model_name'] ?? 'inst';
    }
    $safe_name = preg_replace('/[^A-Za-z0-9]/', '', $name) ?: 'inst';
    $random_num = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    $base_name = $safe_name . '_' . $random_num . '_' . date('Ymd');

    /**
     * 3. แยกการทำงานตามโหมด
     */
    if ($mode === 'basic') {
        // --- โหมดแก้ไขข้อมูลพื้นฐาน ---
        $status_manual_id = (int)($_POST['status_manual_id'] ?? 1);
        $cable_type_id = (int)($_POST['cable_type_id'] ?? 0);
        $config_text = $_POST['config_text'] ?? '';

        array_push($updates, "cable_type_id = ?", "config_text = ?");
        array_push($params, $cable_type_id, $config_text);
        $types .= "is";

        // ⭐ บันทึกทั้งสถานะ และชื่อผู้แก้ไขลงในตาราง automate_model
        $stmt_status = $conn->prepare("UPDATE automate_model SET ref_atm_status_manual_id = ?, atm_model_updatedBy = ? WHERE atm_model_id = ?");
        $stmt_status->bind_param("isi", $status_manual_id, $full_name, $ins_id);
        $stmt_status->execute();

    } else if ($mode === 'upload') {
    // ตรวจสอบไฟล์หน้าปก (Equipment Image)
    if (isset($_FILES['equipment_image']) && $_FILES['equipment_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['equipment_image'];
        
        // เช็คขนาดไฟล์ (MAX_IMG_SIZE = 5MB)
        if ($file['size'] > $MAX_IMG_SIZE) {
            header("Location: " . BASE_URL . "?act=edit&id=$ins_id&mode=$mode&status=error_size");
            exit();
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        // แนะนำให้เพิ่ม uniqid() เพื่อไม่ให้ชื่อไฟล์ซ้ำกันจน Browser ไม่อัปเดตรูปหน้าเว็บ
        $eq_img_name = $base_name . '_main_' . substr(uniqid(), -5) . '.' . $ext;

        if (!is_dir(IMG_PATH)) mkdir(IMG_PATH, 0755, true);

        if (move_uploaded_file($file['tmp_name'], IMG_PATH . $eq_img_name)) {
            // สำคัญ: เพิ่มเข้าไปในรายการ Update ของตาราง instruments
            $updates[] = "equipment_image = ?";
            $params[] = $eq_img_name; 
            $types .= "s";
        }
    }

        if (!empty($_FILES['setup_images']['name'][0])) {
            uploadCustomFiles($_FILES['setup_images'], IMG_PATH, $conn, $ins_id, 'instrument_setup_images', $base_name . '_002', $MAX_IMG_SIZE, BASE_URL, $mode);
        }
        if (!empty($_FILES['run_images']['name'][0])) {
            uploadCustomFiles($_FILES['run_images'], IMG_PATH, $conn, $ins_id, 'instrument_run_images', $base_name . '_003', $MAX_IMG_SIZE, BASE_URL, $mode);
        }
    }

    // อัปโหลดไฟล์เอกสาร (บันทึกได้จากทุกโหมด)
    if (!empty($_FILES['determinations']['name'][0])) {
        uploadCustomFiles($_FILES['determinations'], FILE_PATH, $conn, $ins_id, 'instrument_determination', $base_name . '_004', $MAX_FILE_SIZE, BASE_URL, $mode);
    }

    /**
     * 4. ประมวลผลการบันทึกลงตาราง instruments
     */
    if ($ins_id > 0) {
        $sql = "UPDATE instruments SET " . implode(', ', $updates) . " WHERE ins_id = ?";
        $params[] = $ins_id;
        $types .= "i";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
    }

    header("Location: " . BASE_URL . "?act=edit&id=$ins_id&mode=$mode&status=success");
    exit();
}

/**
 * 5. ฟังก์ชันช่วยจัดการการอัปโหลดไฟล์
 */
function uploadCustomFiles($fileInput, $targetPath, $conn, $insId, $tableName, $filePrefix, $maxSize, $baseUrl, $mode) {
    if (empty($fileInput['name'][0])) return;
    if (!is_dir($targetPath)) mkdir($targetPath, 0755, true);

    foreach ($fileInput['name'] as $key => $val) {
        if ($fileInput['error'][$key] === UPLOAD_ERR_OK) {
            if ($fileInput['size'][$key] > $maxSize) {
                header("Location: " . $baseUrl . "?act=edit&id=$insId&mode=$mode&status=error_size");
                exit();
            }
            $ext = strtolower(pathinfo($val, PATHINFO_EXTENSION));
            $newFileName = $filePrefix . '_' . substr(uniqid(), -5) . '.' . $ext;
            if (move_uploaded_file($fileInput['tmp_name'][$key], $targetPath . $newFileName)) {
                if ($tableName === 'instrument_determination') {
                    $st = $conn->prepare("INSERT INTO $tableName (instrument_id, file_name, original_name) VALUES (?, ?, ?)");
                    $st->bind_param("iss", $insId, $newFileName, $val);
                } else {
                    $res = $conn->query("SELECT MAX(sort_order) as max_sort FROM $tableName WHERE instrument_id = $insId");
                    $row = $res->fetch_assoc();
                    $nextOrder = ($row['max_sort'] !== null) ? $row['max_sort'] + 1 : 0;
                    $st = $conn->prepare("INSERT INTO $tableName (instrument_id, file_name, sort_order) VALUES (?, ?, ?)");
                    $st->bind_param("isi", $insId, $newFileName, $nextOrder);
                }
                $st->execute();
            }
        }
    }
}