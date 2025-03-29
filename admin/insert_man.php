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
                <h6 class="m-0 font-weight-bold"><i class="fas fa-folder-plus"></i> Thêm Hãng Sản Xuất</h6>
            </div>
            <div class="card-body">
                <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Tên Hãng:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="man_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Mã Hãng:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="man_id" required>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2"></label>
                            <div class="col-sm-6">
                                <input type="submit" name="submit" value="Thêm Hãng" class="btn btn-primary form-control">
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
        
        $man_name = $_POST['man_name'];
        $man_id = $_POST['man_id'];

        
        $insert_man = "insert into HANGSX (MA_HANGSX,TEN_HANGSX) values ('$man_id','$man_name')";

        $executeUpdate = $MyConn->query($insert_man);

        if($executeUpdate) {
            echo "<script>alert('Thêm Hãng Sản Xuất Mới Thành Công')</script>";

            echo "<script>window.open('index.php?view_man','_self')</script>";
        }


    }


?>

<?php } ?>