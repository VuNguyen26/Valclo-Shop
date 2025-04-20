<?php
    $sever = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'web_db';
    $port = 3306;

    $conn = new mysqli($sever, $user, $password, $database, $port);

    if ($conn) {
        mysqLi_query($conn, "SET NAMES 'utf8'");
    } else {
        echo "Connection failed: ";
    }