<?php
/* xct/alt/instrument/config/permission.php */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- ส่วน Auto-Login Local ---
require_once __DIR__ . '/env.php';

if (defined('APP_ENV') && APP_ENV === 'local' && !isset($_SESSION['user_instrument'])) {
    // เซตสิทธิ์การใช้งาน (Level)
    $_SESSION['user_instrument'] = "2"; 
    
    // ✅ เพิ่มการเซต user_id เป็น 3 เพื่อให้เงื่อนไขปุ่มลบ (ID=3) ทำงานได้ในเครื่อง Local
    $_SESSION['user_id'] = "3"; 
    
    $_SESSION['user_department'] = "instrument";
    // $_SESSION['user_department'] = "executive";

    // (Optional) เซตชื่อเพื่อใช้โชว์ในระบบ
    $_SESSION['user_firstname'] = "Young";
    $_SESSION['user_lastname'] = "PeUy";
}

// --- ฟังก์ชันเช็คสิทธิ์แบบสั้น ---
function checkLevel($level) {
    return isset($_SESSION['user_instrument']) && (int)$_SESSION['user_instrument'] >= $level;
}

// --- ✅ ฟังก์ชันเช็คว่าเป็นแผนกเครื่องตรวจหรือไม่ ---
function isInstrument() {
    return isset($_SESSION['user_department']) && $_SESSION['user_department'] === 'instrument';
}

// --- ฟังก์ชันเช็ค ID เฉพาะตัว ---
function isMe() {
    return isset($_SESSION['user_id']) && (string)$_SESSION['user_id'] === "3";
}