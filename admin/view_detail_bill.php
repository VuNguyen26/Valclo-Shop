<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}
else {
    if(isset($_GET['view_detail_bill'])) {

    $billID = $_GET['view_detail_bill'];

    $queryCustomer = $MyConn->query("SELECT TEN_KH, EMAIL, DIENTHOAI, DIACHI, AVATAR FROM KH, HOADON WHERE KH.MA_KH = HOADON.MA_KH AND HOADON.MA_HD = '$billID'");

    $getCustomer = mysqli_fetch_array($queryCustomer);

?>
<div class="row">
    <div class="col-lg-12">
        <div class="card text-dark mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-eye"></i> Chi Tiết Hóa Đơn <?= $billID ?></div></h6>
            <div class="card-body">

                <div class="row ml-2 mr-2 mb-1">
                    <div class="col-md-4">
                        <div class="card border-0 p-0">
                            <div class="card-body text-center">
                                <img src="<?php echo "customer_images/".$getCustomer['AVATAR'] ?>" alt="" width="200" height="200" class="rounded">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0">
                            <div class="card-body">
                            <br>
                            <span>Tên Khách Hàng: <?php echo $getCustomer['TEN_KH'] ?></span><br><br>
                            <span>Email: <?php echo $getCustomer['EMAIL'] ?></span><br><br>
                            <span>Số Điện Thoại: <?php echo $getCustomer['DIENTHOAI'] ?> </span><br><br>
                            <span>Địa Chỉ: <?php echo $getCustomer['DIACHI'] ?></span><br><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="product_table" class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên Sản Phẩm</th>
                                <th>Mã Sản Phẩm</th>
                                <th>Hình Ảnh</th>
                                <th>Số Lượng</th>
                                <th>Giá Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $queryCustomer->close();
                                $MyConn->setNextRs();
                                $getDetailBill = $MyConn->query("SELECT TEN_SP, SP.MA_SP, HINHANH_SP, SOLUONG, TONGTIEN FROM SP, CT_HOADON WHERE CT_HOADON.MA_SP = SP.MA_SP AND CT_HOADON.MA_HD = '$billID'");
                            
                                while ($row = mysqli_fetch_array($getDetailBill)) {

                            ?>
                            <tr>
                                <td> <?php echo $row['TEN_SP'] ?> </td>
                                <td> <?php echo $row['MA_SP'] ?> </td>
                                <td> <img src="<?php echo "product_images/".$row['HINHANH_SP'] ?>" width="60" height="60" class="rounded"> </td>
                                <td> <?php echo $row['SOLUONG'] ?> </td>
                                <td> <?php echo number_format($row['TONGTIEN'],0,",",".")."<sup>đ</sup>" ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php }} ?>