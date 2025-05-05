<?php
    include 'connect.php'; 

    session_start();

    if (isset($_POST['Login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Trang đăng nhập</title>
</head>

<body>
    <form class="form_login" action="admin_login.php" method="post">
        <h2>Đăng nhập</h2>
        <label for="username">Username </label>
        <input type="text" id="username" name="username" placeholder="default username = admin" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="default password = 123" required>

        <button type="submit" name="Login">Login</button>
    </form>
</body>

<style>
    .form_login {
        width: 390px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color:rgb(118, 203, 194);
    }

    .form_login h2 {
        text-align: center;
        margin-bottom: 13px;
        color: #333;
    }

    .form_login label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .form_login input[type="text"],
    .form_login input[type="password"] {
        width: 95%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .form_login button {
        width: 50%;
        padding: 10px;
        background-color:rgb(93, 153, 216);
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        text-shadow: 2px 2px 4px #000;
        display: block;
        margin: 0 auto
    }

    .form_login button:hover {
        background-color:rgb(239, 20, 100);
    }

    .form_login p {
        text-align: center;
        margin-top: 10px;
    }
</style>