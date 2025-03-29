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
                <h6 class="m-0 font-weight-bold"><i class="fas fa-user-plus"></i> Thêm Quản Trị Viên</h6>
            </div>
            <div class="card-body">
                <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Tên Thành Viên:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Mã Thành Viên:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_id" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Email:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_email" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Mật Khẩu:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_passwd" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Địa Chỉ:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_address" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Số Điện Thoại:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_contact" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Chức Vụ:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="admin_pos" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Ảnh Đại Diện:</label>
                            <div class="col-sm-6">
                            <input type="file" name="admin_image" class="form-control-file">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Giới Thiệu:</label>
                            <div class="col-sm-6">
                            <textarea name="admin_about" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2"></label>
                            <div class="col-sm-6">
                                <input type="submit" name="submit" value="Thêm Thành Viên" class="btn btn-primary form-control">
                            </div>
                        </div>
                    </div>
                    
                    


                </form>
            </div>
        </div>
    </div>
</div>

<?php 
    if(isset($_POST['submit'])) {
        $admin_name = $_POST['admin_name'];

        $admin_email = $_POST['admin_mail'];

        $admin_pass = $_POST['admin_passwd'];

        $admin_id = $_POST['admin_id'];

        $admin_address = $_POST['admin_address'];

        $admin_contact = $_POST['admin_contact'];

        $admin_about = $_POST['admin_about'];

        $admin_pos = $_POST['admin_pos'];

        $admin_image = $_FILES['admin_image']['name'];

        $tmp_img = $_FILES['admin_image']['tmp_name'];

        move_uploaded_file($tmp_img,"admin_images/$admin_image");

        $insertQry = "insert into `admin` (`ID`, `Name`, `Email`, `Passwd`, `Image`, `Contact`, `Address`, `Position`, `About`) VALUES ('$admin_id', '$admin_name', '$admin_email', '$admin_pass', '$admin_image', '$admin_contact', '$admin_address', '$admin_pos', '$admin_about');";
    
        $executeQry = $MyConn->query($insertQry);

        if($executeQry) {
            echo "<script>alert('Thêm Thành Viên Thành Công')</script>";

            echo "<script>window.open('index.php?view_admin','_self')</script>";
        }
    }



?>

<?php } ?>