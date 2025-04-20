<?php
    include 'connect.php'; 

    session_start();

    if (isset($_POST['Login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM employee_account WHERE username='$username' AND password='$password'";
        
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $username;
            header("Location: employee_index.php");
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
    <form class="form_login" action="employee_login.php" method="post">
        <h2>Đăng nhập</h2>
        <label for="username">Username: </label>
        <input type="text" id="username" name="username"  required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="Login">Login</button>
        <p>Login as <a href="admin_login.php" style="color: rgb(215, 65, 93); text-decoration: none">Admin</a></p>
    </form>
</body>

<style>
.form_login {
    width: 360px;
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
    width: 100%;
    padding: 10px;
    background-color:rgb(93, 153, 216);
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

.form_login button:hover {
    background-color: #0056b3;
}

.form_login p {
    text-align: center;
    margin-top: 10px;
}

</style>