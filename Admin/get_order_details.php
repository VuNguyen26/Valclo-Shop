<?php
header('Content-Type: application/json');
include 'connect.php';

if (isset($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']);
    $queryDetails = "SELECT od.*, p.NAME AS PRODUCT_NAME, p.IMG_URL
                     FROM ORDER_DETAIL od 
                     LEFT JOIN PRODUCT p ON od.PID = p.ID 
                     WHERE od.ORDER_ID = $orderId";
    $resultDetails = $conn->query($queryDetails);

    $details = [];
    if ($resultDetails) {
        while ($detail = $resultDetails->fetch_assoc()) {
            $details[] = $detail;
        }
        echo json_encode(['details' => $details]);
    } else {
        echo json_encode(['error' => 'Lỗi khi lấy chi tiết đơn hàng: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'Thiếu ID đơn hàng']);
}

$conn->close();
?>