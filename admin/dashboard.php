<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}
else {

    $get_products = "select * from SP";
    $run_query = $MyConn->query($get_products);
    $count_products = mysqli_num_rows($run_query);

    $get_bill = "select * from HOADON";
    $run_query = $MyConn->query($get_bill);
    $count_bills = mysqli_num_rows($run_query);

    $get_Income = 0;
    while($row = mysqli_fetch_array($run_query)) {
        if($row['TRANGTHAI'] == "Đã Thanh Toán") {
            $get_Income += $row['TONGTIEN'];
        }
    }
    $get_Customer = "select * from KH";
    $run_query = $MyConn->query($get_Customer);
    $count_customers = mysqli_num_rows($run_query);


?>
                    <!-- Mở Header-->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 " style="color:#615c84">Dashboard</h1>
                        <a href="#" style="background-color:#615c84" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50" ></i> In Báo Cáo Thống Kê</a>
                    </div>                    <!-- Đóng Header -->


                    <!-- Mở Thống Kê -->
                    <div class="row">

                        <!-- Card Sản Phẩm -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-body btn-danger rounded-top">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2"  >
                                            <div class="text-xs font-weight-bold text-light text-uppercase mb-1" >
                                                <h5>Sản phẩm</h5></div>
                                            <div class="h5 mb-0 font-weight-bold text-light"> <?php echo $count_products; ?>  </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tshirt fa-2x text-light"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer rounded-bottom">
                                    <span><a href="index.php?view_product" class="card-link small text-danger">Xem Chi Tiết</a></span>
                                    <span class="float-right "><i class="fa fa-arrow-circle-right text-danger"></i></span>

                                </div>
                            </div>
                        </div>                        <!-- Đóng Card Sản Phẩm -->


                        <!-- Card Khách Hàng -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-body bg-info rounded-top">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-light text-uppercase mb-1">
                                                <h5>Khách Hàng</h5></div>
                                            <div class="h5 mb-0 font-weight-bold text-light"> <?php echo $count_customers; ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-address-book fa-2x text-light"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer rounded-bottom">
                                    <span><a href="index.php?view_customer" class="card-link small text-info">Xem Chi Tiết</a></span>
                                    <span class="float-right "><i class="fa fa-arrow-circle-right text-info"></i></span>

                                </div>
                            </div>
                        </div>                        <!-- Đóng Card Khách Hàng -->


                        <!-- Card Hóa Đơn -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-body bg-warning rounded-top">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-light text-uppercase mb-1">
                                                <h5>HÓA ĐƠN</h5></div>
                                            <div class="h5 mb-0 font-weight-bold text-light"> <?php echo $count_bills; ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shopping-cart fa-2x text-light"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer rounded-bottom">
                                    <span><a href="index.php?view_bill" class="card-link small text-warning">Xem Chi Tiết</a></span>
                                    <span class="float-right "><i class="fa fa-arrow-circle-right text-warning"></i></span>

                                </div>
                            </div>
                        </div>                         <!-- Đóng Card Hóa Đơn -->


                        <!-- Card Doanh Thu -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-body bg-success rounded-top">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-light text-uppercase mb-1">
                                                <h5>DOANH THU</h5></div>
                                            <div class="h5 mb-0 font-weight-bold text-light"> <?php echo number_format($get_Income,0,",",".")."<sup>₫</sup>" ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shopping-cart fa-2x text-light"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer rounded-bottom">
                                    <span><a href="index.php?view_bill" class="card-link small text-success">Xem Chi Tiết</a></span>
                                    <span class="float-right "><i class="fa fa-arrow-circle-right text-success"></i></span>

                                </div>
                            </div>
                        </div>                         <!-- Đóng Card Doanh Thu -->


                </div>                     <!-- Đóng Thống Kê -->



                <!-- Mở Hàng 2 -->
                <div class="row mt-3">

                    <!-- Mở Bảng Hóa Đơn -->
                    <div class="col-lg-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 bg-secondary">
                                <h6 class="m-0 font-weight-bold text-light">
                                    <i class="fas fa-shipping-fast"></i>   Hóa Đơn Mới Nhất
                                </h6>
                            </div>
                            <div class="card-body ">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-striped mb-0 table">
                                        <thead class="thead-dark text-center">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Email Khách Hàng</th>
                                                <th>Mã Hóa Đơn</th>
                                                <th>Tổng Tiền</th>
                                                <th>Trạng Thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i = 1;
                                                $getTopBillQuery = "SELECT EMAIL, MA_HD, HOADON.TRANGTHAI, TONGTIEN FROM HOADON, KH WHERE (KH.MA_KH = HOADON.MA_KH) ORDER BY RAND() LIMIT 5";
                                                $result = $MyConn->query($getTopBillQuery);
                                                while($row = mysqli_fetch_array($result)) {
                                                    $email = $row['EMAIL'];
                                                    $billID = $row['MA_HD'];
                                                    $status = $row['TRANGTHAI'];
                                                    $totalbill = $row['TONGTIEN'];
                                                
                                            ?>
                                            <tr>
                                                <td class="text-center"> <?php echo $i++; ?> </td>
                                                <td> <?php echo $email; ?> </td>
                                                <td> <?php echo $billID; ?> </td>
                                                <td> <?php echo number_format($totalbill,0,",","."); ?><sup>đ</sup></td>
                                                <td> <?php echo $status; ?> </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="card-footer">
                                <span class="float-right"><i class="fa fa-arrow-circle-right text-secondary"></i></span>
                                <span class="float-right"><a href="index.php?view_bill" class="card-link text-secondary mr-2"> Xem Chi Tiết</a></span>
                            </div>
                        </div>
                    </div>                    <!-- Đóng Bảng Hóa Đơn -->

                    
                    <!-- Mở Card User -->
                    <div class="col-md-4">
                        <div class="panel shadow mb-4 rounded">
                            <div class="panel-body">
                                <div class="thumb-info mb-md p-3 mb-3"><!-- thumb-info mb-md Starts -->
                                    <img src="<?php echo "admin_images/".$admin_image ?>" class="img-responsive img-thumbnail p-0">                                    
                                    <div class="thumb-info-title ml-4 mb-0 rounded"><!-- thumb-info-title Starts -->                                    
                                        <span class="thumb-info-inner"> <?php echo $admin_name; ?> </span>                                    
                                        <span class="thumb-info-type rounded"> <?php echo $admin_pos; ?> </span>                                    
                                    </div><!-- thumb-info-title Ends -->                                   
                                </div><!-- thumb-info mb-md Ends -->                                    
                                <div class=" mb-md pl-4 "><!-- mb-md Starts -->                    
                                    <div class="widget-content-expanded mr-4"><!-- widget-content-expanded Starts -->                                    
                                        <i class="fas fa-envelope"></i><span> Email: </span> <?php echo $admin_email; ?> <br>
                                        <i class="fas fa-phone-alt"></i><span> Số Điện Thoại: </span> <?php echo $admin_contact; ?>  <br>
                                        <i class="fas fa-map-marked-alt"></i><span> Địa Chỉ: </span> <?php echo $admin_address; ?>  <br>                                   
                                    </div><!-- widget-content-expanded Ends -->                                    
                                    <hr class="dotted short mr-4">                                    
                                    <h5 class="text-muted ">Giới Thiệu</h5>                                    
                                    <p class="mb-3">
                                        <?php echo $admin_about; ?>
                                    </p>
                                    <br>
                                </div>        
                            </div>
                        </div>
                    </div>


<?php } ?>