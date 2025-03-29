<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}
else {
    
    
        $admin_id = $_SESSION['admin_email'];

        $query = "select * from admin where Email='$admin_id'";

        $run_query = $MyConn->query($query);

        $getCurAdmin = mysqli_fetch_array($run_query);

        $cur_id = $getCurAdmin['ID'];
        $cur_name = $getCurAdmin['Name'];
        $cur_email = $getCurAdmin['Email'];
        $cur_pass = $getCurAdmin['Passwd'];
        $cur_image = $getCurAdmin['Image'];
        $cur_contact = $getCurAdmin['Contact'];
        $cur_address = $getCurAdmin['Address'];
        $cur_pos = $getCurAdmin['Position'];
        $cur_about = $getCurAdmin['About'];

        

?>

<div class="row">
    <div class="col-lg-12">
        <div class="card text-dark mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-user-edit"></i> Sửa Thông Hồ Sơ Cá Nhân</h6>
            </div>
            <div class="card-body">
                <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Tên Thành Viên:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_name" required value="<?php echo $cur_name; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Mã Thành Viên:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_id" required value="<?php echo $cur_id; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Email:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_email" required value="<?php echo $cur_email; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Mật Khẩu:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_passwd" required value="<?php echo $cur_pass; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Địa Chỉ:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_address" required value="<?php echo $cur_address; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Số Điện Thoại:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_contact" required value="<?php echo $cur_contact; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Chức Vụ:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_pos" required value="<?php echo $cur_pos; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Ảnh Đại Diện:</label>
                            <div class="col-sm-6">
                            <input type="file" name="admin_image" class="form-control-file">
                            <br>
                            <img src=" <?php echo "admin_images/$cur_image" ?>" width="70" height="70" class="rounded">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Giới Thiệu:</label>
                            <div class="col-sm-6">
                            <textarea name="admin_about" class="form-control" rows="3"><?php echo $cur_about; ?>
                            </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2"></label>
                            <div class="col-sm-6">
                                <input type="submit" name="update" value="Cập Nhật Thông Tin" class="btn btn-primary form-control">
                            </div>
                        </div>
                    </div>
                    
                    


                </form>
            </div>
        </div>
    </div>
</div>

<?php 
    if(isset($_POST['update'])) {
        $admin_name = $_POST['admin_name'];

        $admin_email = $_POST['admin_email'];

        $admin_pass = $_POST['admin_passwd'];

        $admin_id = $_POST['admin_id'];

        $admin_address = $_POST['admin_address'];

        $admin_contact = $_POST['admin_contact'];

        $admin_about = $_POST['admin_about'];

        $admin_pos = $_POST['admin_pos'];

        $admin_image = $_FILES['admin_image']['name'];

        $tmp_img = $_FILES['admin_image']['tmp_name'];

        if(empty($admin_image)) {
            $admin_image = $cur_image;
        }

        move_uploaded_file($tmp_img,"admin_images/$admin_image");

        $update_admin = "update admin set ID='$admin_id', Name='$admin_name', Email='$admin_email',Passwd='$admin_pass',Image='$admin_image',Contact='$admin_contact',Address='$admin_address',Position='$admin_pos',About='$admin_about' where ID='$cur_id'";


        
        $executeQry = $MyConn->query($update_admin);

        if($executeQry) {
            echo "<script>alert('Cập Nhật Thông Tin Thành Công')</script>";

            echo "<script>window.open('index.php?view_admin','_self')</script>";
        }
    }



?>

<?php } ?>