<?php
if (!function_exists('img_src')) {
    function img_src(?string $file): string {
        // หากไม่มีชื่อไฟล์ ให้ใช้รูป Placeholder
        if (empty($file)) {
            return 'https://via.placeholder.com/300x200?text=No+Image';
        }

        /**
         * ดึงรูปจากโฟลเดอร์ ins_setup เสมอตามโครงสร้างใหม่
         * ใช้ BASE_URL ร่วมกับ Path assets/imgs/ins_setup/
         */
        return BASE_URL . 'assets/imgs/ins_setup/' . rawurlencode($file);
    }
}