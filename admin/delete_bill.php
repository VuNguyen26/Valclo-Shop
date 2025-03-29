<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

}

else {

    if(isset($_GET['delete_bill'])){

        $delete_id = $_GET['delete_bill'];

        $delete_detail_bill = "delete from CT_HOADON where MA_HD='$delete_id'";

        $run_delete1 = $MyConn->query($delete_detail_bill);

            $delete_bill = "delete from HOADON where MA_HD='$delete_id'";

            $run_delete2 = $MyConn->query($delete_bill);

            if($run_delete2){

                echo "<script> alert('Xóa Hóa Đơn Thành Công') </script>";
    
                echo "<script>window.open('index.php?view_bill','_self')</script>";
    
            }



        

    }   
}
?>