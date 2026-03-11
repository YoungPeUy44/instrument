<?php
/* config/paths.php */
require_once __DIR__ . '/env.php';

if (APP_ENV === 'local') {
    // Local: ต้องมี / ปิดท้ายเพื่อให้ URL สมบูรณ์
    define('BASE_URL', '/xct/alt/instrument/'); 
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instrument');
} else {
    // ⭐ Production: ต้องมี / ปิดท้ายเพื่อป้องกันข้อมูล POST สูญหายจากการ Redirect
    define('BASE_URL', 'https://loginsmedical.co.th/xct/instrument/'); 
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/xct/instrument');
}

// define('ASSETS_URL', BASE_URL . 'assets/');

// ⭐ เพิ่มพาร์ทสำหรับรูปหน้าปกเครื่องตรวจ (Equipment Image)
define('EQ_IMG_URL',  BASE_URL . 'assets/imgs/');
define('EQ_IMG_PATH', rtrim(BASE_PATH, '/') . '/assets/imgs/');

// กำหนด URL (สำหรับ Browser) - ใช้ BASE_URL ที่มี / แล้วต่อด้วย assets ได้เลย
define('IMG_URL',  BASE_URL . 'assets/imgs/ins_setup/');
define('FILE_URL', BASE_URL . 'assets/files/determination/');

// กำหนด Path (สำหรับ Server) - ตรวจสอบเครื่องหมาย / ระหว่างรอยต่อ
define('IMG_PATH',  rtrim(BASE_PATH, '/') . '/assets/imgs/ins_setup/');
define('FILE_PATH', rtrim(BASE_PATH, '/') . '/assets/files/determination/');