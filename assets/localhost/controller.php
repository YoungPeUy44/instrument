<?php
// controller.php (localhost-ready)

$act = $_GET['act'] ?? 'index';

switch ($act) {

    case 'index':
        require __DIR__ . '/index.php';
        break;

    case 'view':
        require __DIR__ . '/view_instrument.php';
        break;

    case 'edit':
        require __DIR__ . '/edit_instrument.php';
        break;

    case 'manual_add':
        require __DIR__ . '/add_instrument.php';
        break;

    case 'save':
        require __DIR__ . '/save_instrument.php';
        break;

    case 'back':
        require __DIR__ . '/save_instrument.php';
        break;

    default:
        require __DIR__ . '/error404.php';
}
