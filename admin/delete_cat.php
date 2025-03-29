<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}

else {

    if(isset($_GET['delete_cat'])){

        $delete_id = $_GET['delete_cat'];

        $delete_cat = "delete from LOAISP where MA_LOAISP='$delete_id'";

        $run_delete = $MyConn->query($delete_cat);

        if($run_delete){

            echo "<script> alert('Xóa Loại Sản Phẩm Thành Công') </script>";

            echo "<script>window.open('index.php?view_cat','_self')</script>";

        }

    }   
}
?>