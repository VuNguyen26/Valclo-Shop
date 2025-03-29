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
                <h6 class="m-0 font-weight-bold"><i class="fas fa-eye"></i> Danh Sách Sản Phẩm</div></h6>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="product_table" class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên Sản Phẩm</th>
                                <th>Mã Sản Phẩm</th>
                                <th>Hình Ảnh Sản Phẩm</th>
                                <th>Loại Sản Phẩm</th>
                                <th>Nhà Sản Xuất</th>
                                <th>Giá Thành</th>
                                <th>Xóa Sản Phẩm</th>
                                <th>Sửa Thông Tin Sản Phẩm</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $getProductQry = "select * from SP";

                            $result = $MyConn->query($getProductQry);

                            while($row = mysqli_fetch_array($result)) {
                                $p_name = $row['TEN_SP'];
                                $p_id = $row['MA_SP'];
                                
                                $qry_cat = "select * from LOAISP where MA_LOAISP='".$row['MA_LOAISP']."'";
                                $run_qry = $MyConn->query($qry_cat);
                                $getCat = mysqli_fetch_array($run_qry);

                                $p_cat = $getCat['TEN_LOAISP'];

                                $qry_man = "select * from HANGSX where MA_HANGSX='".$row['MA_HANGSX']."'";
                                $run_qry = $MyConn->query($qry_man);
                                $getMan = mysqli_fetch_array($run_qry);

                                $p_man = $getMan['TEN_HANGSX'];


                                $p_about = $row['MIEUTA_SP'];
                                $p_image = $row['HINHANH_SP'];
                                $p_price = $row['GIA'];
                            
                        ?>
                            <tr>
                                <td> <?php echo $p_name ?></td>
                                <td> <?php echo $p_id ?> </td>
                                <td><img src="<?php echo "product_images/$p_image" ?>" width="60" height="60" class="rounded shadow"></td>
                                <td> <?php echo $p_cat ?></td>
                                <td> <?php echo $p_man ?></td>
                                <td> <?php echo number_format($p_price,0,",","."); ?><sup>đ</sup></td>
                                <td>
                                    <!--  < ? p h p echo $pro_id; ?> -->
                                    <a href="index.php?delete_product=<?php echo $p_id ?>" class="text-danger" style="text-decoration: none">
                                        <i class="fas fa-trash-alt"></i>
                                            Xóa
                                    </a>
                                </td>
                                <td>
                                    <!--  < ? p h p echo $pro_id; ?> -->
                                    <a href="index.php?edit_product=<?php echo $p_id ?>" style="text-decoration: none">
                                        <i class="fas fa-edit" ></i>
                                            Sửa
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