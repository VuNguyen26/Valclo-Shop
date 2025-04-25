<?php
session_start();

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = "MOMO";
$accessKey = "F8BBA842ECF85";
$secretKey = "K951B6PE1waDMi640xX08PD3vg6EkVlz";
$oids = isset($_GET['oids']) ? $_GET['oids'] : '';

if (!isset($_SESSION['total_amount'])) {
    echo "Không có tổng tiền thanh toán trong session!";
    exit;
}
$amount = strval($_SESSION['total_amount']);
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

$rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
$signature = hash_hmac("sha256", $rawHash, $secretKey);

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

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$result = curl_exec($ch);
curl_close($ch);
$jsonResult = json_decode($result, true);

if (isset($jsonResult['payUrl'])) {
    header('Location: ' . $jsonResult['payUrl']);
    exit;
} else {
    echo "Không nhận được payUrl từ MoMo";
    exit;
}
