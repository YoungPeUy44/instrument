<?php
include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instruments/authentication.php');
$act = (isset($_GET['act']) ? $_GET['act'] : '');

if ($act == 'manual_guide') {
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/instrument/index.php');
} else if ($act == 'manual_add') {
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/instrument/add_instrument.php');
} else if ($act == 'back_index') {
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/instrument/index.php');
} else {
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/instrument/error404.php');
}
// ตัวเดิมของ controller.php