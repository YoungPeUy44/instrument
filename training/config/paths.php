<?php
/* config/paths.php */
require_once __DIR__ . '/env.php';

if (APP_ENV === 'local') {
    define('BASE_URL', '/xct/alt/instrument/'); 
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instrument/'); // เติม / ปิดท้าย
} else {
    define('BASE_URL', 'https://loginsmedical.co.th/xct/instrument/'); 
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/xct/instrument/'); // เติม / ปิดท้าย
}

// --- Path สำหรับเครื่องตรวจ ---
define('EQ_IMG_URL',  BASE_URL . 'assets/imgs/');
define('EQ_IMG_PATH', BASE_PATH . 'assets/imgs/');

// --- Path สำหรับระบบ Training ---
// ใช้รอยต่อที่แน่นอนระหว่าง BASE_URL กับโฟลเดอร์ training
define('TRAIN_URL',         BASE_URL . 'training/');
define('TRAIN_ASSETS_URL',  TRAIN_URL . 'assets/');
define('TRAIN_CSS_URL',     TRAIN_ASSETS_URL . 'css/');
define('TRAIN_JS_URL',      TRAIN_ASSETS_URL . 'js/');

// สำหรับไฟล์บันทึกข้อมูล (ใช้ใน action ของฟอร์ม)
define('TRAIN_DB_URL',      TRAIN_URL . 'db/');