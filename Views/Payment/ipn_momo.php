<?php
$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['resultCode']) && $data['resultCode'] == 0) {
    $oids = $_GET['oids'] ?? '';

    if (!empty($oids)) {
        $count = count(explode("/", $oids));
        file_get_contents("http://localhost/?url=Home/update_cart_combo/$count/$oids/momo");
        http_response_code(200);
        echo "Cập nhật đơn hàng thành công";
    } else {
        http_response_code(400);
        echo "Thiếu mã đơn hàng (oids)";
    }
} else {
    http_response_code(400);
    echo "Thanh toán thất bại hoặc bị hủy";
}
header("Location: ?url=Payment/success&oids=123");
exit;
