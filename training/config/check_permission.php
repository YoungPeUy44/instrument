<?php
// config/check_permission.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 0 = จำกัดการเข้าถึง, 1 = ดูได้เท่านั้น, 2 = ดูและแก้ไขได้
$user_role = $_SESSION['user_instrument'] ?? "0";

// --- กรณีที่ 1: ไม่มีสิทธิ์เข้าถึงเลย (Level 0) ---
if ($user_role == "0") {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'จำกัดการเข้าถึง!',
                text: 'คุณไม่มีสิทธิ์เข้าถึงระบบนี้ กรุณาติดต่อผู้ดูแลระบบ',
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../';
                }
            });
        });
    </script>";
    exit;
}

// --- กรณีที่ 2: ตรวจสอบหน้าแก้ไข (ถ้าอยู่ในหน้า Edit แต่สิทธิ์ไม่ใช่ 2 ให้เด้งออก) ---
$current_file = basename($_SERVER['PHP_SELF']);
if ($current_file == 'edit_instrument.php' && $user_role != '2') {
    header("Location: manual_guide.php?reason=no_permission");
    exit;
}

// สร้างตัวแปรลัดไว้ใช้ใน HTML
$can_edit = ($user_role == "2");

?>