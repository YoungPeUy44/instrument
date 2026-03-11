<?php
include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/inc/auth_check.php');
include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/inc/user_info.php');

$act = (isset($_GET['act']) ? $_GET['act'] : '');

if ($act == 'manual_guide') {
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/instrument/index.php'); // ป๋วย ทดสอบทำคู่มือเชื่อมเครื่องตรวจ                
} else if ($act == 'manual_add') {
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/manual_list/automate/add_instrument.php');  // ป๋วย ดึงเข้า XCT menu Guide (ยกเลิกใช้งาน) 
} else if ($act == 'back_index') {
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/manual_list/automate/index.php');  // เต้ ทดสอบโหลดฟอร์ม bb 
} else if ($act == '__') {
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/manual_list/reportform/edit_instrument.php?id=');  // เต้ ทดสอบโหลดฟอร์ม bb 
  
} else {
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/inc/auth_check.php');
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/inc/user_info.php');
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/inc/version.php');
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/inc/header.php');
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/inc/nav.php');
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/inc/aside.php');
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/xct404_errorpage.php');       
      include($_SERVER['DOCUMENT_ROOT'] . '/xct/alt/inc/footer.php');
}
