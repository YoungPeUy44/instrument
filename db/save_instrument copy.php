<?php
/* db/save_instrument.php */
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../config/paths.php';

$conn = db();
$conn->set_charset('utf8mb4');

/**
 * 1. ส่วนจัดการการลบไฟล์ (Delete Action)
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
            // ⭐ ใช้ IMG_PATH ให้ตรงกับที่เก็บรูป Setup/Run
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
    $ins_id_input = (int)($_POST['ins_id'] ?? 0);
    $ins_id = $ins_id_input; 
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    $has_eq_img = !empty($_FILES['equipment_image']['name']);
    $has_setup  = !empty($_FILES['setup_images']['name'][0]);
    $has_run    = !empty($_FILES['run_images']['name'][0]);
    $has_file   = !empty($_FILES['determinations']['name'][0]);

    /**
     * 3. จัดการรูปหน้าปกเครื่อง (Equipment Image)
     */
    $eq_img_name = null;
    if ($has_eq_img) {
        $file = $_FILES['equipment_image'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $eq_img_name = 'eq_' . uniqid() . '.' . $ext;
        
        // ⭐ กำหนดที่เก็บรูปหน้าปกแยกจากรูป Setup
        if (!is_dir(IMG_PATH)) mkdir(IMG_PATH, 0755, true);
        move_uploaded_file($file['tmp_name'], IMG_PATH . $eq_img_name);
    }

    /**
     * 4. บันทึกข้อมูลหลัก
     */
    if ($name !== '' || $eq_img_name !== null) {
        if ($ins_id > 0) {
            $updates = ["update_at=NOW()"];
            $params = []; $types = "";

            if ($name !== '') {
                array_push($updates, "name=?", "category_id=?", "cable_type_id=?", "config_text=?");
                array_push($params, $name, $_POST['category_id'], $_POST['cable_type_id'], $_POST['config_text']);
                $types .= "siis";
            }
            if ($eq_img_name) {
                $updates[] = "equipment_image=?";
                $params[] = $eq_img_name; $types .= "s";
            }

            $sql = "UPDATE instruments SET " . implode(', ', $updates) . " WHERE ins_id=?";
            $params[] = $ins_id; $types .= "i";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("INSERT INTO instruments (name, category_id, cable_type_id, config_text, equipment_image, created_at, update_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("siiss", $name, $_POST['category_id'], $_POST['cable_type_id'], $_POST['config_text'], $eq_img_name);
            $stmt->execute();
            $ins_id = $conn->insert_id;
        }
    }

    /**
     * 5. อัปโหลดรูปหลายไฟล์ (Setup / Run / Files)
     */
    if ($ins_id > 0) {
        if ($has_setup) uploadMultipleFiles($_FILES['setup_images'], IMG_PATH, $conn, $ins_id, 'instrument_setup_images');
        if ($has_run)   uploadMultipleFiles($_FILES['run_images'], IMG_PATH, $conn, $ins_id, 'instrument_run_images');
        if ($has_file)  uploadMultipleFiles($_FILES['determinations'], FILE_PATH, $conn, $ins_id, 'instrument_determination');
    }

    /**
     * 6. ระบบ Redirect
     */
    if ($ins_id_input === 0) {
        header("Location: " . BASE_URL . "?act=manual_guide&status=success");
    } else {
        $mode = ($has_setup || $has_run) ? 'upload' : 'basic';
        header("Location: " . BASE_URL . "?act=edit&id=$ins_id&mode=$mode&status=success");
    }
    exit();
}

/**
 * 7. ฟังก์ชันตัวช่วยอัปโหลดไฟล์
 */
function uploadMultipleFiles($fileInput, $targetPath, $conn, $insId, $tableName) {
    if (empty($fileInput['name'][0])) return;
    if (!is_dir($targetPath)) mkdir($targetPath, 0755, true);

    foreach ($fileInput['name'] as $key => $val) {
        if ($fileInput['error'][$key] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($val, PATHINFO_EXTENSION));
            $newFileName = uniqid('img_', true) . '.' . $ext;

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