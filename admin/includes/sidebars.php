<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}
else {

?>


<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Admin</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="index.php?dashboard">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-tshirt"></i>
        <span>Sản Phẩm</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="index.php?insert_product">Thêm Sản Phẩm</a>
            <a class="collapse-item" href="index.php?view_product">Danh Sách Sản Phẩm</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-tags"></i>
        <span>Loại Sản Phẩm</span>
    </a>
    <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="index.php?insert_cat">Thêm Loại Sản Phẩm</a>
            <a class="collapse-item" href="index.php?view_cat">Danh Sách Loại Sản Phẩm</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-industry"></i>
        <span>Nhà Sản Xuất</span>
    </a>
    <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="index.php?insert_man">Thêm Nhà Sản Xuất</a>
            <a class="collapse-item" href="index.php?view_man">Danh Sách Nhà Sản Xuất</a>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<li class="nav-item">
    <a class="nav-link" href="index.php?view_bill">
        <i class="fas fa-shopping-cart"></i>
        <span>Đơn Đặt Hàng</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<li class="nav-item">
    <a class="nav-link" href="index.php?view_customer">
        <i class="fas fa-address-book"></i>
        <span>Khách Hàng</span></a>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-users-cog"></i>
        <span>Quản Trị Viên</span>
    </a>
    <div id="collapseAdmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="index.php?insert_admin">Thêm Quản Trị Viên</a>
            <a class="collapse-item" href="index.php?view_admin">Danh Sách Quản Trị Viên</a>
            <a class="collapse-item" href="index.php?update_admin">Chỉnh Sủa Hồ Sơ</a>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<li class="nav-item">
    <a class="nav-link" href="logout.php">
        <i class="fas fa-sign-out-alt"></i>
        <span>Đăng Xuất</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->

<?php } ?>