


<?php
require_once __DIR__ . '/env.php';

if (APP_ENV === 'local') {
    define('BASE_URL', '/xct/alt/instrument/'); 
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instrument');
} else {
    define('BASE_URL', 'https://loginsmedical.co.th/xct/instrument/'); 
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/xct/instrument');
}

// ⭐ ปรับปรุง: กำหนด URL หลักของรูปภาพไว้ที่ imgs/ (ถอยออกมา 1 ระดับ)
define('EQ_IMG_URL',  BASE_URL . 'assets/imgs/');
define('EQ_IMG_PATH', rtrim(BASE_PATH, '/') . '/assets/imgs/');

// ⭐ ปรับปรุง: IMG_URL ควรชี้ไปที่โฟลเดอร์ imgs กลาง เพื่อให้เรียก cables/ ได้ด้วย
define('IMG_URL',  BASE_URL . 'assets/imgs/'); 
define('FILE_URL', BASE_URL . 'assets/files/determination/');

define('IMG_PATH',  rtrim(BASE_PATH, '/') . '/assets/imgs/');
define('FILE_PATH', rtrim(BASE_PATH, '/') . '/assets/files/determination/');