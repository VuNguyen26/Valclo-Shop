<?php
    include 'connect.php';     
?>

<section class="dashboard">
    <div class="header_container">
        <div class="left">
            <img src="./assets/img/np.png" alt="Logo" class="logo_header" style="width: 40px; height: 40px; margin-right: 10px;">
            <span style="font-size: 1.05em; color: rgb(204, 204, 255);"><?php echo ucfirst($_SESSION['username']); ?></span>
            <form action="logout.php" method="post">
                <button type="submit" class="btn_header" style="font-size: smaller;">Đăng xuất</button>
            </form>
        </div>
        <div class="right">
            <a href="index.php" class="btn_header">Trang chủ</a>
            <a href="qlngdung.php" class="btn_header">Quản lý tài khoản người dùng</a>
            <a href="qlnv.php" class="btn_header">Quản lý tài khoản nhân viên</a>
            <a href="gopy.php" class="btn_header">Xem góp ý</a>            
        </div>
    </div>
</section>
