<?php
function db() {
    $conn = new mysqli(
        "127.0.0.1",     // host
        "logins",          // user (แก้ตามเครื่องคุณ)
        "iamlgm",              // password
        "automate_manual_db",       // ชื่อ database
        3306             // port
    );

    if ($conn->connect_error) {
        die("DB connect failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");
    return $conn;
}
