<?php
session_start();

// ===== LOCALHOST MODE =====
$isLocal = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']);

// auth จากเว็บหลัก → ปิดบน localhost
if (!$isLocal) {
    include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instruments/authentication.php');
}

// รับ act
$act = $_GET['act'] ?? 'manual_guide';

// routing
switch ($act) {
    case 'manual_guide':
        include __DIR__ . '/add_instrument.php';
        break;

    case 'save':
        include __DIR__ . '/save_instrument.php';
        break;

    case 'view':
        include __DIR__ . '//view_instrument.php';
        break;

    case 'edit':
        include __DIR__ . '/edit_instrument.php';
        break;

    default:
        include __DIR__ . '/instrument/error404.php';
        break;
}
