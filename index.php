<?php
session_start();
/**
 * Dùng để trả về các thông số của $array
 * @param $array Mảng cần hiển thị
 * @return array
 */
function test_array($array) {
    echo'<pre>';
    print_r($array) ;
    echo'</pre>';
    exit;
}

/**
 * Dùng để trả về các thông số của $input
 * @param $input Giá trị cần hiển thị
 * @return mixed
 */
function test($input) {
    var_dump($input);
    exit;
}

// Process URL from browser
require_once "./Function/App.php";

// How controllers call Views & Models
require_once "./Function/controller.php";

// Connect Database
require_once "./Function/DB.php";
$myApp = new App();
?>