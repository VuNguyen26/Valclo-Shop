<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}
else {
    if(isset($_GET['edit_man'])){

        $get_id = $_GET['edit_man'];

        $get_man = "select * from HANGSX where MA_HANGSX='$get_id'";

        $run_query = $MyConn->query($get_man);

        $get_cur_man = mysqli_fetch_array($run_query);

        $cur_man_id = $get_cur_man['MA_HANGSX'];
        $cur_man_name = $get_cur_man['TEN_HANGSX'];

    } 

?>

<div class="row">
    <div class="col-lg-12">
        <div class="card text-dark mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-folder-plus"></i> Sửa Thông Tin Loại Sản Phẩm</h6>
            </div>
            <div class="card-body">
                <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Tên Loại Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="man_name" required value="<?php echo $cur_man_name ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Mã Loại Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="man_id" required value="<?php echo $cur_man_id ?>">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2"></label>
                            <div class="col-sm-6">
                                <input type="submit" name="update" value="Cập Nhật Thông Tin Loại Sản Phẩm" class="btn btn-primary form-control">
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
        
        $man_name = $_POST['man_name'];
        $man_id = $_POST['man_id'];

        
        $update_man = "update HANGSX set MA_HANGSX='$man_id', TEN_HANGSX='$man_name' where MA_HANGSX='$cur_man_id'";

        $executeUpdate = $MyConn->query($update_man);

        if($executeUpdate) {
            echo "<script>alert('Cập Nhật Thông Tin Hãng Thành Công')</script>";

            echo "<script>window.open('index.php?view_man','_self')</script>";
        }


    }


?>

<?php } ?>