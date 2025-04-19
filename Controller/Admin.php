<?php 
class Admin {

    // ✅ Trang đăng nhập
    public function login() {
        require_once './Views/Admin/admin_login.php';
    }

    // ✅ Dashboard chính
    public function index() {
        $this->authorize();
        require_once './Views/Admin/admin_main.php';
    }

    // ✅ Quản lý đơn hàng
    public function qldonhang() {
        $this->authorize();
        require_once './Views/Admin/qldonhang.php';
    }

    // ✅ Quản lý sản phẩm
    public function qlsp() {
        $this->authorize();
        require_once './Views/Admin/qlsp.php';
    }

    // ✅ Quản lý nhân viên
    public function qlnv() {
        $this->authorize();
        require_once './Views/Admin/qlnv.php';
    }

    // ✅ Quản lý người dùng
    public function qlngdung() {
        $this->authorize();
        require_once './Views/Admin/qlngdung.php';
    }

    // ✅ Thống kê
    public function thongke() {
        $this->authorize();
        require_once './Views/Admin/thongke.php';
    }

    // ✅ Logout admin
    public function logout() {
        session_start();
        session_destroy();
        header("Location: ?url=Admin/login");
        exit();
    }

    // ✅ Kiểm tra quyền admin
    private function authorize() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?url=Admin/login");
            exit();
        }
    }
}
