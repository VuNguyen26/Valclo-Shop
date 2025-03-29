<?php

if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {

    if(isset($_GET['delete_admin'])) {

        $admin_id = $_GET['delete_admin'];

        $deleteQuery = "delete from admin where ID='$admin_id'";


        $execute = $MyConn->query($deleteQuery);

        if($execute) {
            echo "<script>alert('Xóa Quản Trị Viên Thành Công')</script>";

            echo "<script>window.open('index.php?view_admin','_self')</script>";
        }
    }
}

?>
