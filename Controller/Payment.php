<?php
class Payment {
    public function paypal_button($role = "customer") {
        require_once "./Views/Payment/paypal_button.php";
    }
    public function success_paypal($role = "customer") {
        require_once "./Views/Payment/success_paypal.php";
    }
    public function Home_page() {
        header("Location: ?url=Home");
    }
}
