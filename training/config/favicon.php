<?php
// config/meta_head.php

// ตรวจสอบว่ามีการโหลด paths.php หรือยัง (เพื่อให้มี BASE_URL)
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/paths.php';
}
?>

<link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>assets/imgs/logo/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>assets/imgs/logo/favicon.ico">

<link rel="apple-touch-icon" href="<?= BASE_URL ?>assets/imgs/logo/favicon.ico">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">