<?php
/* xct/alt/instrument/config/permission.php */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (session_status() === PHP_SESSION_NONE) { session_start(); }

// --- ส่วน Auto-Login Local (ย้ายมาไว้ที่นี่ที่เดียว) ---
require_once __DIR__ . '/env.php';
if (defined('APP_ENV') && APP_ENV === 'local' && !isset($_SESSION['user_instrument'])) {
    $_SESSION['user_instrument'] = "3"; 
}

// --- ฟังก์ชันเช็คสิทธิ์แบบสั้น ---
function checkLevel($level) {
    return isset($_SESSION['user_instrument']) && (int)$_SESSION['user_instrument'] >= $level;
}