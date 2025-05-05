<?php
include 'connect.php';     
?>

<nav class="sidebar bg-dark text-white d-flex flex-column p-3">
    <div class="d-flex align-items-center mb-4">
        <img src="./assets/img/np.png" alt="Logo" class="me-2" style="width: 40px; height: 40px;">
        <span class="fs-5"><?php echo ucfirst($_SESSION['username']); ?></span>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="index.php" class="nav-link text-white">Trang chủ</a>
        </li>
        <li class="nav-item">
            <a href="qlngdung.php" class="nav-link text-white">Quản lý người dùng</a>
        </li>
        <li class="nav-item">
            <a href="qlsp.php" class="nav-link text-white">Quản lý sản phẩm</a>
        </li>
        <li class="nav-item">
            <a href="qlnhaphang.php" class="nav-link text-white">Quản lý nhập hàng</a>
        </li>
        <li class="nav-item">
            <a href="qldonhang.php" class="nav-link text-white">Quản lý đơn hàng</a>
        </li>

        <li class="nav-item">
            <a href="gopy.php" class="nav-link text-white">Xem góp ý</a>
        </li>
        <li class="nav-item mt-auto">
            <form action="logout.php" method="post">
                <button type="submit" class="btn btn-danger w-100">Đăng xuất</button>
            </form>
        </li>
    </ul>
</nav>

<style>
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 250px;
    z-index: 1000;
    overflow-y: auto;
}

.nav-link {
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

@media (max-width: 768px) {
    .sidebar {
        width: 200px;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
    }

    .sidebar.active {
        transform: translateX(0);
    }
}

.toggle-btn {
    position: fixed;
    top: 10px;
    left: 10px;
    z-index: 1100;
    display: none;
}

@media (max-width: 768px) {
    .toggle-btn {
        display: block;
    }
}
</style>