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
                <h6 class="m-0 font-weight-bold"><i class="fas fa-eye"></i> Danh Sách Loại Sản Phẩm</div></h6>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="product_table" class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên Loại Sản Phẩm</th>
                                <th>Mã Loại Sản Phẩm</th>
                                <th>Xóa Loại Sản Phẩm</th>
                                <th>Sửa Thông Tin Loại Sản Phẩm</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $getCatQry = "select * from LOAISP";

                            $result = $MyConn->query($getCatQry);

                            while($row = mysqli_fetch_array($result)) {
                                $cat_id = $row['MA_LOAISP'];
                                $cat_name = $row['TEN_LOAISP'];

                        ?>
                            <tr>
                                <td> <?php echo $cat_name ?></td>
                                <td> <?php echo $cat_id ?> </td>
                                <td>
                                    <!--  < ? p h p echo $pro_id; ?> -->
                                    <a href="index.php?delete_cat=<?php echo $cat_id ?>" class="text-danger" style="text-decoration: none">
                                        <i class="fas fa-trash-alt"></i>
                                            Xóa
                                    </a>
                                </td>
                                <td>
                                    <!--  < ? p h p echo $pro_id; ?> -->
                                    <a href="index.php?edit_cat=<?php echo $cat_id ?>" style="text-decoration: none">
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