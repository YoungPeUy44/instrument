<?php
http_response_code(404);
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>404 - ไม่พบหน้าที่คุณร้องขอ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8fafc;
        }
        .error-box {
            margin-top: 10%;
        }
        .error-code {
            font-size: 96px;
            font-weight: 700;
            color: #1e3a8a;
        }
        .error-text {
            font-size: 20px;
            color: #475569;
        }
        .btn-back {
            padding: 10px 22px;
            font-size: 16px;
        }
    </style>
</head>

<body>
<div class="container text-center error-box">
    <div class="error-code">404</div>
    <div class="fw-bold mb-2">กำลังแกไข้</div>


    <a href="/xct/alt/instrument?act=manual_guide" class="btn btn-primary btn-back">
        ⟵ กลับหน้าแรก
    </a>
</div>
</body>
</html>
