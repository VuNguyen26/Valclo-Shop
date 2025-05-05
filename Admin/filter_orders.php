<?php
header('Content-Type: application/json');
include 'connect.php';

$status = isset($_GET['status']) && !empty($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';
$whereClause = $status ? "WHERE STATUS = '$status'" : '';

$query = "SELECT * FROM `ORDER` $whereClause ORDER BY ID ASC";
$result = $conn->query($query);

$orders = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    echo json_encode(['orders' => $orders]);
} else {
    echo json_encode(['error' => 'Lỗi khi lấy dữ liệu đơn hàng: ' . $conn->error]);
}

$conn->close();
?>