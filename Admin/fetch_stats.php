<?php
include 'connect.php';

// Lấy tham số từ yêu cầu AJAX
$tab = $_POST['tab'] ?? 'revenue';
$selected_year = $_POST['selected_year'] ?? '';

// Truy vấn dữ liệu dựa trên tab và năm
$revenueAndOrders = [];

if (!$selected_year) {
    $query = "
        SELECT DATE_FORMAT(TIME, '%Y-%m') AS period, 
               SUM(TOTAL_PRICE) AS total_revenue, 
               COUNT(ID) AS order_count
        FROM `order`
        GROUP BY DATE_FORMAT(TIME, '%Y-%m')
        ORDER BY DATE_FORMAT(TIME, '%Y-%m')
    ";
    $result = $conn->query($query);
    if ($result) {
        $revenueAndOrders = $result->fetch_all(MYSQLI_ASSOC);
    }
} else {
    $query = "
        SELECT DATE_FORMAT(TIME, '%Y-%m') AS period, 
               SUM(TOTAL_PRICE) AS total_revenue, 
               COUNT(ID) AS order_count
        FROM `order`
        WHERE YEAR(TIME) = ?
        GROUP BY DATE_FORMAT(TIME, '%Y-%m')
        ORDER BY DATE_FORMAT(TIME, '%Y-%m')
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $selected_year);
    $stmt->execute();
    $result = $stmt->get_result();
    $revenueAndOrders = $result->fetch_all(MYSQLI_ASSOC);
}

// Chuẩn bị dữ liệu trả về
$response = [
    'success' => !empty($revenueAndOrders),
    'data' => $revenueAndOrders,
    'tab' => $tab
];

// Trả về JSON
header('Content-Type: application/json');
echo json_encode($response);
?>