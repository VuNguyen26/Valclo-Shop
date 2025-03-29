<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}
else {

?>
<div class="row">
    <div class="col-lg-12">
        <div class="card text-dark mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-clipboard-list"></i> Danh Sách Hóa Đơn</div></h6>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="product_table" class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên Khách Hàng</th>
                                <th>Mã Hóa Đơn</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                                <th>Xem Chi Tiết Hóa Đơn</th>
                                <th>Xóa Hóa Đơn</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                $getBillQuery = "SELECT TEN_KH, MA_HD, HOADON.TRANGTHAI, TONGTIEN FROM HOADON, KH WHERE (KH.MA_KH = HOADON.MA_KH)";
                                $result = $MyConn->query($getBillQuery);
                                while($row = mysqli_fetch_array($result)) {
                                    $tenkh = $row['TEN_KH'];
                                    $mahd = $row['MA_HD'];
                                    $trangthaihd = $row['TRANGTHAI'];  
                                    $tongtien = $row['TONGTIEN'];   
                            ?>
                            <tr>
                                <td> <?php echo $tenkh ?> </td>
                                <td> <?php echo $mahd ?> </td>
                                <td> <?php echo number_format($tongtien,0,",",".")."<sup>₫</sup>" ?></td>
                                <td> <?php echo $trangthaihd ?></td>
                                <td>
                                    <!--  < ? p h p echo $pro_id; ?> -->
                                    <a href="index.php?view_detail_bill=<?php echo $mahd ?>" style="text-decoration: none">
                                        <i class="fas fa-eye"></i>
                                            Xem
                                        </a>
                                </td>
                                <td>
                                    <!--  < ? p h p echo $pro_id; ?> -->
                                    <a href="index.php?delete_bill=<?php echo $mahd ?>" class="text-danger" style="text-decoration: none">
                                        <i class="fas fa-trash-alt"></i>
                                            Xóa
                                    </a>
                                </td>

                            </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>