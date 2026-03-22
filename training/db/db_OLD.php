<?php
function db() {
    static $connpeuy;
    if ($connpeuy) return $connpeuy;

    $cfg = require __DIR__.'/../config/config.php';   // โหลด array จาก config.php

    if (!is_array($cfg)) {
        die("DB connect failed: config.php not returning array");
    }

    mysqli_report(MYSQLI_REPORT_OFF);

    $connpeuy = @new mysqli(
        $cfg['db_host'],
        $cfg['db_user'],
        $cfg['db_pass'],
        $cfg['db_name'],
        (int)$cfg['db_port']
    );

    if ($connpeuy->connect_error) {
        die("DB connect failed: " . $connpeuy->connect_error);
    }

    $connpeuy->set_charset($cfg['db_charset']);
    return $connpeuy;
}
