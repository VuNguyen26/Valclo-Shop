<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}

else {

    if(isset($_GET['edit_product'])) {
        $edit_id = $_GET['edit_product'];

        $query = "select * from SP where MA_SP='$edit_id'";

        $runQry = $MyConn->query($query);

        $get_p = mysqli_fetch_array($runQry);

        $cur_p_id = $get_p['MA_SP'];
        $cur_p_name = $get_p['TEN_SP'];
        $cur_p_cat = $get_p['MA_LOAISP'];
        $cur_p_man = $get_p['MA_HANGSX'];
        $cur_p_image = $get_p['HINHANH_SP'];
        $cur_p_price = $get_p['GIA'];
        $cur_p_about = $get_p['MIEUTA_SP'];
    }

?>
<div class="row">
    <div class="col-lg-12">
        <div class="card text-dark mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-edit"></i> Sửa Thông Tin Sản Phẩm</h6>
            </div>
            <div class="card-body">
                <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Tên Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="product_name" required value="<?php echo $cur_p_name ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Mã Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" name="product_id" required value="<?php echo $cur_p_id ?>">
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
                                        
                                        $isSelected_man = "";
                                        if($man_id == $cur_p_man) {
                                            $isSelected_man = "selected";
                                        }

                                        echo "<option value='$man_id' $isSelected_man>$man_name</option>";

                                        $isSelected_man = "";


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
                                        
                                        $isSelected_cat = "";
                                        if($cat_id == $cur_p_cat) {
                                            $isSelected_cat = "selected";
                                        }

                                        echo "<option value='$cat_id' $isSelected_cat>$cat_name</option>";

                                        $isSelected_cat = "";


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
                            <br>
                            <img src="<?php echo "product_images/$cur_p_image" ?>" width="60" height="60" class="rounded">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Giá Thành:</label>
                            <div class="col-sm-6">
                            <input type="number" name="product_price" class="form-control" required value="<?php echo $cur_p_price ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2">Miêu Tả Sản Phẩm:</label>
                            <div class="col-sm-6">
                            <textarea name="product_desc" class="form-control" rows="10"><?php echo $cur_p_about ?> 
                            </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-3 text-right mt-2"></label>
                            <div class="col-sm-6">
                                <input type="submit" name="update" value="Cập Nhật Sản Phẩm" class="btn btn-primary form-control">
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
        
        $p_id = $_POST['product_id'];
        $p_name = $_POST['product_name'];
        $p_cat = $_POST['catalog'];
        $p_man = $_POST['manufacturer'];
        $p_price = $_POST['product_price'];
        $p_about = $_POST['product_desc'];

        $p_image = $_FILES['product_image']['name'];
        $tmp_img = $_FILES['product_image']['tmp_name'];

        if(empty($p_image)) {
            $p_image = $cur_p_image;
        }

        move_uploaded_file($tmp_img,"product_images/$p_image");


        $update_product = "update SP set MA_SP='$p_id', TEN_SP='$p_name', MA_LOAISP='$p_cat', MA_HANGSX='$p_man', MIEUTA_SP='$p_about', HINHANH_SP='$p_image',GIA='$p_price' where MA_SP='$cur_p_id'";

        $executeUpdate = $MyConn->query($update_product);

        if($executeUpdate) {
            echo "<script>alert('Cập Nhật Thông Tin Sản Phẩm Thành Công')</script>";

            echo "<script>window.open('index.php?view_product','_self')</script>";
        }


    }


?>

<?php } ?>