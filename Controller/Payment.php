<?php
class Payment extends Controller {
    public function paypal_button($role = "customer") {
        require_once "./Views/Payment/paypal_button.php";
    }

    public function success_paypal($role = "customer") {
        $mem = $this->model('member');
        $new_oid = $mem->create_order_from_cart($_SESSION['id'], 'PayPal');
        if (!$new_oid) {
            die("Tạo đơn hàng thất bại (PayPal).");
        }
        require_once "./Views/Payment/success_paypal.php";
    }

    public function success($role = "customer") {
    if (isset($_GET['resultCode']) && $_GET['resultCode'] == '0') {
        if (!isset($_SESSION['id'])) {
            $_SESSION['payment_result'] = [
                'success' => false,
                'message' => "Vui lòng đăng nhập để hoàn tất đơn hàng.",
                'oid' => null
            ];
            require_once "./Views/Payment/success.php";
            return;
        }

        $uid = $_SESSION['id'];
        $mem = $this->model('member');

        // Tránh xử lý lại nếu đã có kết quả
        if (!isset($_SESSION['payment_result'])) {
            $oid = $mem->create_order_from_cart($uid, 'MoMo');
            if ($oid) {
                $_SESSION['payment_result'] = [
                    'success' => true,
                    'message' => "Bạn đã thanh toán MoMo thành công!",
                    'oid' => $oid
                ];
            } else {
                $_SESSION['payment_result'] = [
                    'success' => false,
                    'message' => "Giỏ hàng trống hoặc đã được xử lý trước đó.",
                    'oid' => null
                ];
            }
        }

        require_once "./Views/Payment/success.php";
    } else {
        $_SESSION['payment_result'] = [
            'success' => false,
            'message' => "Thanh toán thất bại hoặc bị hủy.",
            'oid' => null
        ];
        require_once "./Views/Payment/success.php";
    }
}


    public function cod_payment($role = "customer") {
        $mem = $this->model('member');
        $new_oid = $mem->create_order_from_cart($_SESSION['id'], 'COD');
        if (!$new_oid) {
            die("Tạo đơn hàng thất bại (COD).");
        }
        require_once "./Views/Payment/cod_payment.php";
    }

    public function Home_page() {
        header("Location: ?url=Home");
    }
}
