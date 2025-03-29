<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}

else {

    if(isset($_GET['unlock_customer'])){

        $unlock_id = $_GET['unlock_customer'];

        $unlockqry = "UPDATE KH SET TRANGTHAI='' WHERE MA_KH='$unlock_id'";

        $run_unlockqry = $MyConn->query($unlockqry);

        if($run_unlockqry){

            echo "<script> alert('Mở Khóa Khách Hàng Thành Công') </script>";

            echo "<script>window.open('index.php?view_customer','_self')</script>";

        }

    }   
}
?>