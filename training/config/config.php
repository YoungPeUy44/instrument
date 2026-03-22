<?php
/* config/database.php */
require_once __DIR__ . '/env.php';

if (APP_ENV === 'local') {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'logins');
    define('DB_PASS', 'iamlgm');
    define('DB_NAME', 'automate_manual_db');
} else {
    // แก้ User เป็น U ใหญ่ และลองใช้ localhost
    define('DB_HOST', 'localhost'); 
    define('DB_USER', 'YoungPeUy'); 
    define('DB_PASS', '445524');
    define('DB_NAME', 'executive_web');
}