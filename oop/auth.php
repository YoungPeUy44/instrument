<?php
require_once __DIR__ . '/env.php';

if (APP_ENV === 'production') {
    require $_SERVER['DOCUMENT_ROOT'] . '/xct/alt/instruments/authentication.php';
}
// local = ไม่บังคับ login
