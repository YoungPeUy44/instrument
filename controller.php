<?php
require __DIR__ . '/config/auth.php';
include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instruments/authentication.php');
$act = $_GET['act'] ?? 'manual_guide';

switch ($act) {

    case 'manual_guide':
        require __DIR__ . '/oop/manual_guide.php';
        break;

    case 'manual_add':
        require __DIR__ . '/oop/add_instrument.php';
        break;

    case 'view':
        require __DIR__ . '/oop/view_instrument.php';
        break;

    case 'edit':
        require __DIR__ . '/oop/edit_instrument.php';
        break;

    case 'save':
        require __DIR__ . '/db/save_instrument.php';
        break;

    case 'delete':
        require __DIR__ . '/db/delete_file.php';
        break;

    case 're_images':
        require __DIR__ . '/db/re_images.php';
        break;

    case 'old':
        require __DIR__ . '/oop/info.php';
        break;

    case 'train':
        require __DIR__ . '/training/oop/train_form.php';
        break;

    case 'training_history':
        require __DIR__ . '/training/oop/training_history.php';
        break;

    case 'update_training_status':
        require __DIR__ . '/training/db/update_status.php';
        break;

    case 'delete_training':
        require __DIR__ . '/training/db/delete_training.php';
        break;

    case 'update_training_complete':
        require __DIR__ . '/training/db/update_training_complete.php';
        break;

    default:
        require __DIR__ . '/oop/error404.php';
}
