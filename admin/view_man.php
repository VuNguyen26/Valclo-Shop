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
                                <th>Tên Nhà Sản Xuất</th>
                                <th>Mã Nhà Sản Xuất</th>
                                <th>Xóa Sản Phẩm</th>
                                <th>Sửa Thông Tin</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $getManQry = "select * from HANGSX";

                            $result = $MyConn->query($getManQry);

                            while($row = mysqli_fetch_array($result)) {
                                $man_id = $row['MA_HANGSX'];
                                $man_name = $row['TEN_HANGSX'];

                        ?>
                            <tr>
                                <td> <?php echo $man_name ?></td>
                                <td> <?php echo $man_id ?> </td>
                                <td>
                                    <!--  < ? p h p echo $pro_id; ?> -->
                                    <a href="index.php?delete_man=<?php echo $man_id ?>" class="text-danger" style="text-decoration: none">
                                        <i class="fas fa-trash-alt"></i>
                                            Xóa
                                    </a>
                                </td>
                                <td>
                                    <!--  < ? p h p echo $pro_id; ?> -->
                                    <a href="index.php?edit_man=<?php echo $man_id ?>" style="text-decoration: none">
                                        <i class="fas fa-edit" ></i>
                                            Sửa
                                        </a>
                                </td>
                            </tr>
                            <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>