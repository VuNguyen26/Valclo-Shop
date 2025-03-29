<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}

else {

    if(isset($_GET['delete_customer'])){

        $delete_id = $_GET['delete_customer'];

        $delete = "delete from KH where MA_KH='$delete_id'";

        $run_delete = $MyConn->query($delete);

        if($run_delete){

            echo "<script>alert('Xóa Khách Hàng Thành Công')</script>";

            echo "<script>window.open('index.php?view_customer','_self')</script>";

        }

    }
}
?>