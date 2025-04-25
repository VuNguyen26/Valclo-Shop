<?php
class Payment extends Controller {
    public function paypal_button($role = "customer") {
        require_once "./Views/Payment/paypal_button.php";
    }
    public function success_paypal($role = "customer") {
        require_once "./Views/Payment/success_paypal.php";
    }
    
    public function Home_page() {
        header("Location: ?url=Home");
    }
    public function success($role = "customer") {
        require_once "./Views/Payment/success.php";
    }    
    public function cod_payment($role = "customer") {
        $mem     = $this->model('member');
        $new_oid = $mem->create_order_from_cart($_SESSION['id']);
        if (!$new_oid) {
            die("Tạo đơn hàng thất bại.");
        }
        require_once "./Views/Payment/cod_payment.php";
    }    
}
