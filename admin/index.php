<?php

//Kiểm Tra Đăng Nhập
session_start();

include("includes/database.php");
if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {


?>
<?php

$MyConn = new MyConnect();
$admin_session = $_SESSION['admin_email'];


$getAdminQry = "select * from admin where Email='$admin_session'";



$getAdmin = $MyConn->query($getAdminQry);

// Lấy Thông Tin Admin

$row_admin = mysqli_fetch_array($getAdmin);

$admin_id = $row_admin['ID'];

$admin_name = $row_admin['Name'];

$admin_email = $row_admin['Email'];

$admin_image = $row_admin['Image'];

$admin_address = $row_admin['Address'];

$admin_pos = $row_admin['Position'];

$admin_contact = $row_admin['Contact'];

$admin_about = $row_admin['About'];

// Lấy Hoàn Tất





?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/thumb.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php include("includes/sidebars.php");  ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php echo $admin_name ?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?php echo "admin_images/".$admin_image ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Hồ Sơ
                                </a>
                                <a class="dropdown-item" href="index.php?update_admin">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Chỉnh Sửa Hồ Sơ
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Nhật Ký Hoạt Động
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng Xuất
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Nội Dung Trang Web -->
                    <?php
                    
                    //Trang Chhính
                    if(isset($_GET['dashboard'])) {
                        include("dashboard.php");
                    }


                    //Trang Sản Phẩm
                    else if(isset($_GET['insert_product'])) {
                        include("insert_product.php");
                    }

                    else if(isset($_GET['view_product'])) {
                        include("view_product.php");
                    }

                    else if(isset($_GET['edit_product'])) {
                        include("edit_product.php");
                    }

                    else if(isset($_GET['delete_product'])) {
                        include("delete_product.php");
                    }


                    //Trang Loại Sản Phẩm
                    else if(isset($_GET['insert_cat'])) {
                        include("insert_cat.php");
                    }

                    else if(isset($_GET['view_cat'])) {
                        include("view_cat.php");
                    }

                    else if(isset($_GET['edit_cat'])) {
                        include("edit_cat.php");
                    }

                    else if(isset($_GET['delete_cat'])) {
                        include("delete_cat.php");
                    }

                    
                    //Trang Nhà Sãn Xuất
                    else if(isset($_GET['insert_man'])) {
                        include("insert_man.php");
                    }

                    else if(isset($_GET['view_man'])) {
                        include("view_man.php");
                    }

                    else if(isset($_GET['delete_man'])) {
                        include("delete_man.php");
                    }

                    else if(isset($_GET['edit_man'])) {
                        include("edit_man.php");
                    }


                    //Trang Hóa Đơn
                    else if(isset($_GET['view_bill'])) {
                        include("view_bill.php");
                    }
                    else if(isset($_GET['delete_bill'])) {
                        include("delete_bill.php");
                    }
                    else if(isset($_GET['view_detail_bill'])) {
                        include("view_detail_bill.php");
                    }

                    //Trang Khách Hàng
                    else if(isset($_GET['view_customer'])) {
                        include("view_customer.php");
                    }
                    else if(isset($_GET['lock_customer'])) {
                        include("lock_customer.php");
                    }
                    else if(isset($_GET['unlock_customer'])) {
                        include("unlock_customer.php");
                    }      
                    else if(isset($_GET['delete_customer'])) {
                        include("delete_customer.php");
                    }
                    

                    //Quản Lý admin: Xem Thêm Xóa Sửa
                    else if(isset($_GET['insert_admin'])) {
                        include("insert_admin.php");
                    }
                    
                    else if(isset($_GET['view_admin'])) {
                        include("view_admin.php");
                    }
                    
                    else if(isset($_GET['edit_admin'])) {
                        include("edit_admin.php");
                    }
                    else if(isset($_GET['delete_admin'])) {

                        include("delete_admin.php");
                    }
                    else if(isset($_GET['update_admin'])) {
                        include("update_admin.php");
                    }
                    else if(isset($_GET[''])) {
                        include("dashboard.php");
                    }
                    else {
                        include("dashboard.php");
                    }
                    
                    ?>

                    <!-- Kết Thúc Nội Dung -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sẵn Sàng Rời Đi?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Chọn Đăng Xuất nếu bạn đã sẵn sàng kết thúc phiên trình duyệt</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="logout.php">Đăng Xuất</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables.js"></script>

</body>

</html>

<?php } ?>