<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}

else {

    if(isset($_GET['lock_customer'])){

        $lock_id = $_GET['lock_customer'];

        $lockqry = "UPDATE KH SET TRANGTHAI='LOCKED' WHERE MA_KH='$lock_id'";

        $run_lockqry = $MyConn->query($lockqry);

        if($run_lockqry){

            echo "<script> alert('Khóa Khách Hàng Thành Công') </script>";

            echo "<script>window.open('index.php?view_customer','_self')</script>";

        }

    }   
}
?>