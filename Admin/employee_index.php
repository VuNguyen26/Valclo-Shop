<?php
    include 'connect.php';

    session_start();

    if(!isset($_SESSION['username'])){
    header('location:employee_login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="./assets/css/admin_style.css">
</head>

<body>
    <?php include 'employee_header.php'; ?>

    <main>
    <?php include 'thongke.php'; ?>
    </main>
        

    <?php include 'admin_footer.php'; ?>
</body>
</html>