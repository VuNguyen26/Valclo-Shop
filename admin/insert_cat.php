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
                <h6 class="m-0 font-weight-bold"><i class="fas fa-folder-plus"></i> Thêm Loại Sản Phẩm</h6>
            </div>
            <div class="card-body">
                <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Tên Loại Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="cat_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Mã Loại Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="cat_id" required>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2"></label>
                            <div class="col-sm-6">
                                <input type="submit" name="submit" value="Thêm Loại Sản Phẩm" class="btn btn-primary form-control">
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
        
        $cat_name = $_POST['cat_name'];
        $cat_id = $_POST['cat_id'];

        
        $insert_cat = "insert into LOAISP (MA_LOAISP,TEN_LOAISP) values ('$cat_id','$cat_name')";

        $executeUpdate = $MyConn->query($insert_cat);

        if($executeUpdate) {
            echo "<script>alert('Thêm Loại Sản Phẩm Mới Thành Công')</script>";

            echo "<script>window.open('index.php?view_cat','_self')</script>";
        }


    }


?>

<?php } ?>