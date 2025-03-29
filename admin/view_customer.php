<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}
else {

        //Lâm:
        $query = "SELECT * FROM KH";

        $result = $MyConn->query($query);

?>
<div class="row">
    <div class="col-lg-12">
        <div class="card text-dark mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-address-book"></i> Danh Sách Khách Hàng</div></h6>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="product_table" class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mã Khách Hàng</th>
                                    <th>Họ Tên Khách Hàng</th>
                                    <th>Ảnh Đại Diện</th>
                                    <th>Email</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Địa Chỉ</th>
                                    <th>Khóa Tài Khoản Khách Hàng</th>
                                    <th>Xóa Khách Hàng</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- Láy dữ liệu data base echo vào từng td -->
                                <?php while($row = $result->fetch_assoc()){ 
                                    $start = "";
                                    $end = "";
                                    if($row['TRANGTHAI'] == "LOCKED") {
                                        $start = "<del>";
                                        $end = "</del>";
                                    }
                                    
                                    ?>
                                   <tr>
                                    <td style="vertical-align: middle;"><?php echo $start.$row['MA_KH'].$end; ?></td>
                                    <td style="vertical-align: middle;"><?php echo $start.$row['TEN_KH'].$end; ?></td>
                                    <td style="vertical-align: middle;">
                                        <img src="<?php echo "customer_images/".$row['AVATAR'] ?>" width="60" height="60" class="rounded">
                                    </td>
                                    <td style="vertical-align: middle;"><?php echo $start.$row['EMAIL'].$end; ?></td>
                                    <td style="vertical-align: middle;"><?php echo $start.$row['DIENTHOAI'].$end; ?></td>
                                    <td style="vertical-align: middle;"><?php echo $start.$row['DIACHI'].$end; ?></td>
                                    <td>
                                    <?php 
                                    
                                    if($row['TRANGTHAI'] == "LOCKED") {

                                        echo "<a href='index.php?unlock_customer=".$row['MA_KH']."' class='btn btn-success btn-sm active' role='button' aria-pressed='true'><i class='fas fa-unlock-alt'></i>  Mở Khóa</a>";

                                    }
                                    else {

                                        echo "<a href='index.php?lock_customer=".$row['MA_KH']."' class='btn btn-danger btn-sm active' role='button' aria-pressed='true'><i class='fas fa-lock'></i>  Khóa</a>";

                                    }
                                    
                                    ?>
                                    </td>
                                   <td>
                                       <!-- echo mã khách hàng vào sau dấu = -->
                                       <a href="index.php?delete_customer=<?= $row['MA_KH'] ?>" class="text-danger" style="text-decoration: none">
                                           <i class="fas fa-trash-alt"></i>
                                               Xóa
                                       </a>
                                   </td>
                                   </tr>        
                                <?php }?>                     
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>