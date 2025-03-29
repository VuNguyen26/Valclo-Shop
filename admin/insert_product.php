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
                <h6 class="m-0 font-weight-bold"><i class="fas fa-folder-plus"></i> Thêm Sản Phẩm</h6>
            </div>
            <div class="card-body">
                <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Tên Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="product_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Mã Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="product_id" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Nhà Sản Xuất:</label>
                            <div class="col-sm-6">
                            <select name="manufacturer" class="form-control">
                                <option>Lựa Chọn Nhà Sản Xuất</option>
                                <?php 
                                    $getManQry = "select * from HANGSX";

                                    $result = $MyConn->query($getManQry);
                                    
                                ?>
                                
                                <?php 
                                    while($row = mysqli_fetch_array($result)) {
                                        $man_id = $row['MA_HANGSX'];
                                        $man_name = $row['TEN_HANGSX'];
                                        
                                        echo "<option value='$man_id'>$man_name</option>";
                                    }
                                ?>
                            </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Loại Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <select name="catalog" class="form-control">
                                <option>Lựa Chọn Loại Sản Phẩm</option>
                                <?php 
                                    $getCatQry = "select * from LOAISP";

                                    $result = $MyConn->query($getCatQry);
                                    
                                ?>
                                
                                <?php 
                                    while($row = mysqli_fetch_array($result)) {
                                        $cat_id = $row['MA_LOAISP'];
                                        $cat_name = $row['TEN_LOAISP'];
                                        
                                        echo "<option value='$cat_id'>$cat_name</option>";
                                    }
                                ?>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Hình Ảnh Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <input type="file" name="product_image" class="form-control-file">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Giá Thành:</label>
                            <div class="col-sm-6">
                            <input type="number" name="product_price" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Miêu Tả Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <textarea name="product_desc" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2"></label>
                            <div class="col-sm-6">
                                <input type="submit" name="submit" value="Thêm Sản Phẩm" class="btn btn-primary form-control">
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
        
        $p_id = $_POST['product_id'];
        $p_name = $_POST['product_name'];
        $p_cat = $_POST['catalog'];
        $p_man = $_POST['manufacturer'];
        $p_price = $_POST['product_price'];
        $p_about = $_POST['product_desc'];

        $p_image = $_FILES['product_image']['name'];
        $tmp_img = $_FILES['product_image']['tmp_name'];


        move_uploaded_file($tmp_img,"product_images/$p_image");


        $insert_product = "insert into SP (MA_SP,TEN_SP,MA_LOAISP,MA_HANGSX,MIEUTA_SP,HINHANH_SP,GIA) values ('$p_id','$p_name','$p_cat','$p_man','$p_about','$p_image','$p_price')";

        $executeUpdate = $MyConn->query($insert_product);

        if($executeUpdate) {
            echo "<script>alert('Thêm Sản Phẩm Mới Thành Công')</script>";

            echo "<script>window.open('index.php?view_product','_self')</script>";
        }


    }


?>

<?php } ?>