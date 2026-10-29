<?php
// db.php

$log = "log";



function connectDB()
{
    $dbHost = "localhost";
    $dbUser = "secure";
    $dbPass = "1111";
    $dbName = "secure";

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    // 연결 오류 확인
    if ($conn->connect_error) {
        die("DB 연결 실패 : " . $conn->connect_error);
    }

    // 한글 처리
    $conn->set_charset("utf8mb4");

    return $conn;
}

function closeDB($conn)
{
    if ($conn instanceof mysqli) {
        $conn->close();
    }
}
?>