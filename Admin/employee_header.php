<?php
    include 'connect.php';     
?>

<section class="dashboard">
    <div class="header_container">
        <div class="left">
            <img src="./assets/img/np.png" alt="Logo" class="logo_header" style="width: 40px; height: 40px; margin-right: 10px;">
            <span style="font-size: 1.05em; color: rgb(204, 204, 255);"><?php echo ucfirst($_SESSION['username']); ?></span>            <form action="employee_logout.php" method="post">
                <button type="submit" class="btn_header" style="font-size: smaller;">Đăng xuất</button>
            </form>
        </div>
        <div class="right">
            <a href="employee_index.php" class="btn_header">Trang chủ</a>
            <a href="qlsp.php" class="btn_header">Quản lý sản phẩm</a>
            <a href="qldonhang.php" class="btn_header">Quản lý đơn hàng</a>         
        </div>
    </div>
</section>
