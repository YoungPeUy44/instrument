<?php
/* db/db.php */

// 1. ตรวจสอบสภาพแวดล้อมก่อนโหลดไฟล์ config (ถ้ามีระบบ env)
// 2. ใช้ require_once เพื่อป้องกันการโหลดซ้ำซ้อน
require_once __DIR__ . '/../config/database.php'; 

// 3. ใช้ if !function_exists เพื่อป้องกัน Error: Cannot redeclare db()
if (!function_exists('db')) {
    function db(): mysqli
    {
        // 4. ใช้ static เพื่อให้เชื่อมต่อเพียงครั้งเดียวต่อการโหลด 1 หน้า ช่วยให้เว็บเร็วขึ้น
        static $connpeuy;
        if ($connpeuy) return $connpeuy;

        // 5. เชื่อมต่อโดยใช้ค่าคงที่จาก database.php
        $connpeuy = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($connpeuy->connect_error) {
            die('DB Error: ' . $connpeuy->connect_error);
        }
        
        $connpeuy->set_charset('utf8mb4');
        return $connpeuy;
    }
}