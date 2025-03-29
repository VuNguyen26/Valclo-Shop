<?php
    session_start();
    include("includes/database.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Quản Trị</title>
    <!--<link rel="shortcut icon" href="img/iconweb.png" type="image/png"> -->

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .center-screen {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 100vh;
            }
    </style>
</head>
    
<!-- <body class="bg-gradient-secondary"> -->
<body style="background-image: url('./admin_images/login-background.jpg');">  
    
    <div class="center-screen">
        <div class="container">
            <div class="row justify-content-center a">
                <div class="col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row h-100">
                                <div class="col-md-6" style="background: url('./admin_images/3f9470b34a8e3f526dbdb022f9f19cf7.jpg') 50%;"></div>
                                <div class="col-md-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Đăng Nhập Admin</h1>
                                        </div>
                                        <form class="user" method="post" class="was-validated">
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp"
                                                    placeholder="Địa Chỉ Email..." required name="admin_email" >
                                                    <div class="invalid-feedback">
                                                        Địa Chỉ Email Không Hợp Lệ.
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" placeholder="Mật Khẩu" required name="passwd" >
                                                    <div class="invalid-feedback">
                                                        Mật Khẩu Không Hợp Lệ.
                                                    </div>
                                            </div>
                                            <button class="btn btn-info btn-user btn-block" type="submit" name="admin_login">Đăng Nhập</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        
    </div>
</body>
</html>

<?php
    if(isset($_POST['admin_login'])) {

        $MyConn = new MyConnect();


        $admin_email = mysqli_real_escape_string($MyConn->getConn(),$_POST['admin_email']);
        $admin_pass = mysqli_real_escape_string($MyConn->getConn(),$_POST['passwd']);

        $query = "select * from admin where Email='$admin_email' AND Passwd='$admin_pass'";

        $result = $MyConn->query($query);


        $count = mysqli_num_rows($result);

        $MyConn->closeConnect();


        if($count == 1) {
            $_SESSION['admin_email'] = $admin_email;

            echo "<script>alert('Bạn Đang Đăng Nhập Vào Trang Quản Trị Viên')</script>";

            echo "<script>window.open('index.php?dashboard','_self')</script>";
            
        }
        else {
            
            echo "<script>alert('Địa Chỉ Email Hoặc Mật Khẩu Không Đúng')</script>";
            
        }
    }
?>