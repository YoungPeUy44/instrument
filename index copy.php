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

// --- ส่วนบนของ HTML (Header/CSS) สามารถวางที่นี่ หรือ include มาก็ได้ ---
?>
<!doctype html>
<html lang="th">
<head>
    <style>
        /* Sticky Footer: บังคับให้ Footer อยู่ล่างสุดเสมอ */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        main {
            flex: 1; /* ดันเนื้อหาให้ขยายเต็มพื้นที่ที่เหลือ */
        }
    </style>
</head>
<body>

<main>
    <?php
    // เรียก controller เพื่อดึงเนื้อหาตามค่า ?act=
    require_once __DIR__ . '/controller.php';
    ?>
</main>

<?php
// ✅ เรียก Footer กลางมาแสดง (ใช้ข้อความเดิมที่คุณต้องการ)
require_once __DIR__ . '/config/footer.php'; 
?>

</body>
</html>