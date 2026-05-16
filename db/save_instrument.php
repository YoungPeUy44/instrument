<?php
/* db/save_instrument.php */
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../config/paths.php';

// สร้างไฟล์ log สำหรับ debug
$log_file = __DIR__ . '/debug_save.log';

// 1. ตรวจสอบการส่งไฟล์ที่ขนาดใหญ่เกินขีดจำกัดของ Server
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && isset($_SERVER['CONTENT_LENGTH'])) {
    $size_mb = round($_SERVER['CONTENT_LENGTH'] / (1024 * 1024), 2);
    $referrer = $_SERVER['HTTP_REFERER'] ?? '../index.php';
    header("Location: " . $referrer . "&status=error_too_big&size=" . $size_mb);
    exit;
}

$conn = db();
$conn->set_charset('utf8mb4');

// กำหนดขนาดไฟล์สูงสุด
$MAX_IMG_SIZE = 50 * 1024 * 1024;
$MAX_FILE_SIZE = 10 * 1024 * 1024;

/**
 * [SECTION 1] จัดการการลบไฟล์
 */
if (isset($_REQUEST['act'])) {
    $act = $_REQUEST['act'];
    $id = (int) ($_REQUEST['id'] ?? 0);

    if ($act === 'delete_file') {
        $stmt = $conn->prepare("SELECT file_name FROM instrument_determination WHERE deter_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $file = $stmt->get_result()->fetch_assoc();
        if ($file) {
            if (file_exists(FILE_PATH . $file['file_name'])) unlink(FILE_PATH . $file['file_name']);
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
            if (file_exists(IMG_PATH . $file['file_name'])) unlink(IMG_PATH . $file['file_name']);
            $conn->query("DELETE FROM $table WHERE $pk = $id");
        }
        echo "OK"; exit();
    }
}
    // เเจ้งเตือนปุ่มสถานะ
  // เช็คว่าถ้าส่ง status_selector มา และไม่มี config_text (แปลว่าเป็น AJAX แน่นอน)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status_selector']) && !isset($_POST['config_text'])) {
        $ins_id = (int)$_POST['ins_id'];
        $status_id = (int)$_POST['status_selector'];
        $full_name = trim(($_SESSION['user_firstname'] ?? '') . " " . ($_SESSION['user_lastname'] ?? '')) ?: "System";

        // 1. Update automate_model
        $stmt1 = $conn->prepare("UPDATE automate_model SET ref_atm_status_manual_id = ?, atm_model_updatedBy = ?, atm_model_updatedAt = NOW() WHERE atm_model_id = ?");
        $stmt1->bind_param("isi", $status_id, $full_name, $ins_id);
        $res1 = $stmt1->execute();

        // 2. Update instruments
        $stmt2 = $conn->prepare("UPDATE instruments SET updated_at = NOW(), updated_by = ? WHERE ins_id = ?");
        $stmt2->bind_param("si", $full_name, $ins_id);
        $res2 = $stmt2->execute();

        if ($res1 && $res2) {
            ob_clean();
            echo "OK"; // 🚩 ต้อง echo คำนี้เพื่อให้ JS รู้ว่าสำเร็จ
        } else {
            echo "Database Error";
        }
        exit; // 🚩 ต้อง exit เพื่อไม่ให้มันไปทำงานส่วนอื่นต่อ
    }

/**
 * [SECTION 2] การบันทึกข้อมูลผ่าน POST
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ins_id = (int) ($_POST['ins_id'] ?? 0);
    $mode = isset($_POST['mode']) ? $_POST['mode'] : 'basic';
    
    // ตรวจสอบว่า ins_id ถูกต้อง
    if ($ins_id <= 0) {
        header("Location: " . BASE_URL . "?act=manual_guide&status=error&msg=invalid_id");
        exit;
    }
    
    // เตรียมชื่อผู้แก้ไข
    $fname = $_SESSION['user_firstname'] ?? '';
    $lname = $_SESSION['user_lastname'] ?? '';
    $full_name = trim($fname . " " . $lname) ?: "System";
    
    // --- เตรียมตัวแปรสำหรับ Dynamic SQL Update ---
    $updates = [];
    $params = [];
    $types = "";
    
    // ข้อมูลพื้นฐานที่อัปเดตทุกครั้ง
    $updates[] = "updated_at = NOW()";
    $updates[] = "updated_by = ?";
    $params[] = $full_name;
    $types .= "s";

    // เตรียมชื่อไฟล์พื้นฐานสำหรับการอัปโหลด
    $res_n = $conn->query("SELECT atm_model_name FROM automate_model WHERE atm_model_id = $ins_id");
    $row_n = $res_n->fetch_assoc();
    $safe_name = preg_replace('/[^A-Za-z0-9]/', '', ($row_n['atm_model_name'] ?? 'inst'));
    $base_name = $safe_name . '_' . rand(1000, 9999) . '_' . date('Ymd');
    
    /**
     * [SECTION 3] แยกประมวลผลตาม Mode
     */
    if ($mode === 'basic') {
        $status_manual_id = (int) ($_POST['status_selector'] ?? 1);
        $cable_type_id = (int) ($_POST['cable_type_id'] ?? 0);
        $config_text = $_POST['config_text'] ?? '';

        $updates[] = "cable_type_id = ?";
        $updates[] = "config_text = ?";
        $updates[] = "updated_at = NOW()";
        $params[] = $cable_type_id;
        $params[] = $config_text;
        $types .= "is";
        
        // อัปเดตตาราง automate_model (สถานะ/ผู้แก้ไข)
        $sql_status = "UPDATE automate_model 
                       SET ref_atm_status_manual_id = ?, 
                           atm_model_updatedBy = ?, 
                           atm_model_updatedAt = NOW() 
                       WHERE atm_model_id = ?";

        $stmt_status = $conn->prepare($sql_status);
        if ($stmt_status) {
            $stmt_status->bind_param("isi", $status_manual_id, $full_name, $ins_id);
            $stmt_status->execute();
            $stmt_status->close();
        } else {
            die("SQL Prepare Error (automate_model): " . $conn->error); 
        }

    } elseif ($mode === 'upload') {
        // อัปโหลดรูปหน้าปก
        if (isset($_FILES['equipment_image']) && $_FILES['equipment_image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['equipment_image'];
            if ($file['size'] <= $MAX_IMG_SIZE) {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $eq_img_name = $base_name . '_main_' . substr(uniqid(), -5) . '.' . $ext;
                if (!is_dir(IMG_PATH)) mkdir(IMG_PATH, 0755, true);
                if (move_uploaded_file($file['tmp_name'], IMG_PATH . $eq_img_name)) {
                    $updates[] = "equipment_image = ?";
                    $params[] = $eq_img_name;
                    $types .= "s";

                    $updates[] = "updated_by = ?"; // หรือ atm_model_updatedBy
                    $params[] = $full_name; // ใช้ตัวแปร trim($fname . " " . $lname)
                    $types .= "s";
                }
            }
        }
        if (!empty($_FILES['setup_images']['name'][0])) {
            uploadCustomFiles($_FILES['setup_images'], IMG_PATH, $conn, $ins_id, 'instrument_setup_images', $base_name . '_setup', $MAX_IMG_SIZE, $full_name);
        }
        if (!empty($_FILES['run_images']['name'][0])) {
            uploadCustomFiles($_FILES['run_images'], IMG_PATH, $conn, $ins_id, 'instrument_run_images', $base_name . '_run', $MAX_IMG_SIZE, $full_name);
        }

    } elseif ($mode === 'sort') {
        // ✅ แก้ไข: รับค่า ID จาก Array และใช้ type จาก POST parameter แทน
        if (isset($_POST['sort_order'])) {
            $sort_data = json_decode($_POST['sort_order'], true);
            $type = $_POST['type'] ?? ''; // รับค่า type (setup/run) ที่ส่งมาจาก JS

            if (is_array($sort_data) && !empty($type)) {
                $table = ($type === 'setup') ? 'instrument_setup_images' : 'instrument_run_images';
                $pk = ($type === 'setup') ? 'setup_id' : 'run_id';

                foreach ($sort_data as $index => $id) {
                    $id = (int)$id;
                    $order = $index + 1; // ลำดับใหม่เริ่มจาก 1

                    $stmt_sort = $conn->prepare("UPDATE $table SET sort_order = ? WHERE $pk = ? AND instrument_id = ?");
                    $stmt_sort->bind_param("iii", $order, $id, $ins_id);
                    $stmt_sort->execute();
                    $stmt_sort->close();
                }
                // ✅ สำคัญ: ต้อง echo OK เพื่อให้ JavaScript รู้ว่าสำเร็จ
                ob_clean(); 
                echo "OK"; 
                exit; 
            }
        }
    }
    
    // อัปโหลดเอกสาร Determination (ทำได้ทุกโหมด)
    if (!empty($_FILES['determinations']['name'][0])) {
        uploadCustomFiles($_FILES['determinations'], FILE_PATH, $conn, $ins_id, 'instrument_determination', $base_name . '_file', $MAX_FILE_SIZE);
    }
    
    /**
     * [SECTION 4] อัปเดตตาราง instruments
     */
    if (!empty($updates)) {
        $sql = "UPDATE instruments SET " . implode(', ', $updates) . " WHERE ins_id = ?";
        $params[] = $ins_id;
        $types .= "i";
        
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $stmt->close();
        }
    }
    
    // Redirect กลับหน้าเดิมพร้อมสถานะ Success
    header("Location: " . BASE_URL . "?act=edit&id=$ins_id&mode=$mode&status=success");
    exit();
}

/**
 * [SECTION 5] Helper Function สำหรับจัดการการอัปโหลดไฟล์
 */
function uploadCustomFiles($files, $path, $conn, $ins_id, $table, $prefix, $maxSize, $uploader_name = 'System') {
    foreach ($files['name'] as $i => $name) {
        if ($files['error'][$i] === UPLOAD_ERR_OK && $files['size'][$i] <= $maxSize) {
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $new_name = $prefix . '_' . substr(uniqid(), -5) . '_' . $i . '.' . $ext;

            if (move_uploaded_file($files['tmp_name'][$i], $path . $new_name)) {
                // ✅ เพิ่มคอลัมน์ uploaded_by เข้าไปในการ INSERT
                $sql = "INSERT INTO $table (instrument_id, file_name, uploaded_by, sort_order) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                
                // หาค่า sort_order ล่าสุดก่อน insert (ถ้าจำเป็น) หรือใส่เป็น 0 ไว้ก่อน
                $order = 0; 
                
                $stmt->bind_param("issi", $ins_id, $new_name, $uploader_name, $order);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}
?>