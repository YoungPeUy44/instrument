<?php
/* env.php */

// ตรวจสอบชื่อ Server ที่รันอยู่
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1') {
    define('APP_ENV', 'local');
} else {
    // ถ้าไม่ใช่ localhost ให้ถือว่าเป็น production ทันที
    define('APP_ENV', 'production');
}