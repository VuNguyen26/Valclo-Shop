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
                                <th>User ID</th>
                                <th>Họ Tên</th>
                                <th>Email</th>
                                <th>Ảnh Đại Diện</th>
                                <th>Số Điện Thoại</th>
                                <th>Địa Chỉ</th>
                                <th>Chức Vụ</th>
                                <th>Xóa Quản Trị Viên</th>
                                <th>Sửa Thông Tin Quản Trị Viên</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $getAdminQry = "select * from admin";

                        $result = $MyConn->query($getAdminQry);

                        while($row = mysqli_fetch_array($result)) {
                            $admin_id = $row['ID'];
                            $admin_name = $row['Name'];
                            $admin_email = $row['Email'];
                            $admin_image = $row['Image'];
                            $admin_contact = $row['Contact'];
                            $admin_address = $row['Address'];
                            $admin_pos = $row['Position'];

                        ?>


                        
                            <tr>
                                <td> <?php echo $admin_id ?> </td>
                                <td> <?php echo $admin_name ?> </td>
                                <td> <?php echo $admin_email ?> </td>
                                <td class="text-center">
                                    <img src="<?php echo "admin_images/".$admin_image ?>" width="65" height="65" class="rounded">
                                </td>
                                <td> <?php echo $admin_contact ?> </td>
                                <td> <?php echo $admin_address ?> </td>
                                <td> <?php echo $admin_pos ?> </td>
                                <td>
                                    <a href="index.php?delete_admin=<?php echo $admin_id ?>" class="text-danger" style="text-decoration: none">
                                        <i class="fas fa-trash-alt"></i>
                                            Xóa
                                    </a>
                                </td>
                                <td>
                                    <a href="index.php?edit_admin=<?php echo $admin_id ?>" style="text-decoration: none">
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