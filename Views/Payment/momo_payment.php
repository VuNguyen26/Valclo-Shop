<?php
session_start(); // Đảm bảo có session để lấy dữ liệu

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

// Cấu hình từ MoMo
$partnerCode = "MOMO";
$accessKey = "F8BBA842ECF85";
$secretKey = "K951B6PE1waDMi640xX08PD3vg6EkVlz";

// Nhận oids từ URL
$oids = isset($_GET['oids']) ? $_GET['oids'] : '';

// ✅ Lấy tổng tiền từ session
if (!isset($_SESSION['total_amount'])) {
    echo "❌ Không có tổng tiền thanh toán trong session!";
    exit;
}
$amount = strval($_SESSION['total_amount']); // ✅ Đảm bảo là string

// Các tham số đơn hàng
$orderInfo = "Thanh toán đơn hàng tại Valclo Shop";
$orderId = time() . "";
$redirectUrl = "http://localhost/?url=Payment/success";
if (!empty($oids)) {
    $redirectUrl .= "&oids=" . urlencode($oids) . "&method=momo";
}
$ipnUrl = "http://localhost/Valclo-Shop/Views/Payment/ipn_momo.php";
$requestId = time() . "";
$requestType = "payWithATM";
$extraData = "";

// Tạo chữ ký
$rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
$signature = hash_hmac("sha256", $rawHash, $secretKey);

// Dữ liệu gửi đi
$data = array(
    'partnerCode' => $partnerCode,
    'accessKey' => $accessKey,
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature,
    'lang' => 'vi'
);

// Gửi request
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$result = curl_exec($ch);
curl_close($ch);

$jsonResult = json_decode($result, true);

// Chuyển hướng đến trang thanh toán MoMo
if (isset($jsonResult['payUrl'])) {
    header('Location: ' . $jsonResult['payUrl']);
    exit;
} else {
    echo "❌ Không nhận được payUrl từ MoMo";
    exit;
}
