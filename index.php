<?php
session_start();
// Process URL from browser
require_once "./app/Function/App.php";

// How controllers call Views & Models
require_once "./app/Function/controller.php";

// Connect Database
require_once "./app/Function/DB.php";
$myApp = new App();
?>