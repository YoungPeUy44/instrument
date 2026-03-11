<?php
session_start();
require_once __DIR__ . '/../config/paths.php'; // ให้มี BASE_URL

$reason = $_GET['reason'] ?? 'permission';

switch ($reason) {
    case 'permission':
        $title = "จำกัดการเข้าถึง";
        $message = "คุณไม่มีสิทธิ์ดำเนินการในส่วนนี้";
        break;

    case 'login':
        $title = "กรุณาเข้าสู่ระบบ";
        $message = "กรุณาเข้าสู่ระบบก่อนใช้งานระบบ";
        break;

    default:
        $title = "ไม่สามารถเข้าถึงได้";
        $message = "เกิดข้อผิดพลาดในการเข้าถึงระบบ";
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }
    </style>

    <!-- Auto Redirect 5 วิ -->
    <script>
        setTimeout(function(){
            window.location.href = "<?= BASE_URL ?>";
        }, 5000);
    </script>
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg border-0 text-center p-4" style="max-width:460px; width:100%;">
        
        <div class="mb-3">
            <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size:70px;"></i>
        </div>

        <h4 class="fw-bold"><?= $title ?></h4>

        <p class="text-muted mt-3">
            <?= $message ?><br>
            กรุณาติดต่อผู้ดูแลระบบ
        </p>

        <?php if(isset($_SESSION['user_firstname'])): ?>
            <p class="small text-secondary mt-2">
                ผู้ใช้งาน: <?= $_SESSION['user_firstname'] ?> <?= $_SESSION['user_lastname'] ?>
            </p>
        <?php endif; ?>

        <div class="mt-4">
            <a href="<?= BASE_URL ?>" class="btn btn-dark px-4">
                กลับหน้าหลัก
            </a>
        </div>

        <div class="mt-3 text-muted small">
            ระบบจะพาคุณกลับหน้าหลักอัตโนมัติใน 5 วินาที
        </div>

    </div>
</div>

</body>
</html>