<?php

if (!function_exists('img_src')) {
    function img_src(?string $file): string {
        if (empty($file)) {
            return 'https://placehold.co/300x200?text=No+Image';
        }

        // ตรวจสอบว่าใน DB ระบุโฟลเดอร์มาด้วยหรือไม่ (เช่น cables/cable_lan.png)
        if (strpos($file, '/') !== false) {
            // ใช้ IMG_URL (ที่ตอนนี้ชี้ไปที่ imgs/) แล้วต่อด้วยชื่อไฟล์ที่มีโฟลเดอร์ติดมาได้เลย
            return IMG_URL . $file;
        }

        // ถ้าไม่มี / (รูปเครื่องตรวจปกติ) ให้ดึงจากโฟลเดอร์ ins_setup (Default)
        return IMG_URL . 'ins_setup/' . rawurlencode($file);
    }
}
