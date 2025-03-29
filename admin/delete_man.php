<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}

else {

    if(isset($_GET['delete_man'])){

        $delete_id = $_GET['delete_man'];

        $delete_cat = "delete from HANGSX where MA_HANGSX='$delete_id'";

        $run_delete = $MyConn->query($delete_cat);

        if($run_delete){

            echo "<script> alert('Xóa Hãng Sản Xuất Thành Công') </script>";

            echo "<script>window.open('index.php?view_man','_self')</script>";

        }

    }   
}
?>