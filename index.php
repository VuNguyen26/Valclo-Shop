<?php
session_start();
/**
 * @return array
 */
function test_server() {
    echo'<pre>';
    print_r($_SERVER) ;
    echo'</pre>';
    exit;
}
/**
 * @param
 * @return array
 */
function test_array($array) {
    echo'<pre>';
    print_r($array) ;
    echo'</pre>';
    exit;
}
/**
 * @param
 * @return mixed
 */
function test($input) {
    var_dump($input);
    exit;
}
require_once "./Function/App.php";
require_once "./Function/controller.php";
require_once "./Function/DB.php";
$myApp = new App();
?>