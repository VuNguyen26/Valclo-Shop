<?php
// Nhận dữ liệu JSON từ MoMo
$data = json_decode(file_get_contents("php://input"), true);

// Kiểm tra nếu thanh toán thành công
if (isset($data['resultCode']) && $data['resultCode'] == 0) {
    // ✅ Thanh toán thành công

    // Lấy oids từ query string (đã đính kèm ở momo_payment.php)
    $oids = $_GET['oids'] ?? '';

    if (!empty($oids)) {
        $count = count(explode("/", $oids));

        // Gọi hàm xử lý cập nhật giỏ hàng + phương thức thanh toán là momo
        file_get_contents("http://localhost/?url=Home/update_cart_combo/$count/$oids/momo");

        http_response_code(200);
        echo "Cập nhật đơn hàng thành công";
    } else {
        http_response_code(400);
        echo "Thiếu mã đơn hàng (oids)";
    }
} else {
    // ❌ Thanh toán thất bại hoặc bị hủy
    http_response_code(400);
    echo "Thanh toán thất bại hoặc bị hủy";
}
header("Location: ?url=Payment/success&oids=123");
exit;
