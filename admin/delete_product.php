<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}

else {

    if(isset($_GET['delete_product'])){

        $delete_id = $_GET['delete_product'];

        $delete_p = "delete from SP where MA_SP='$delete_id'";

        $run_delete = $MyConn->query($delete_p);

        if($run_delete){

            echo "<script>alert('Xóa Sản Phẩm Thành Công')</script>";

            echo "<script>window.open('index.php?view_product','_self')</script>";

        }

    }
}
?>