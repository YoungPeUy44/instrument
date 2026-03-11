<?php
/**
 * instrument/index.php
 * Entry point กลางของระบบ instrument
 * - ห้ามมี logic อื่น
 * - ห้าม include ไฟล์ view โดยตรง
 */

declare(strict_types=1);

session_start();

// เรียก controller ตัวเดียว
require_once __DIR__ . '/controller.php';
