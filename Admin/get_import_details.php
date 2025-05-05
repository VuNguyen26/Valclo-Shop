<?php
include 'connect.php';

header('Content-Type: application/json; charset=utf-8'); // Đặt header ngay từ đầu

$response = ['status' => 'error', 'message' => 'Không tìm thấy dữ liệu'];

if (isset($_GET['import_id'])) {
    $import_id = $_GET['import_id'];
    $sql = "SELECT p.NAME, id.QUANTITY, id.IMPORT_PRICE 
            FROM import_detail id 
            JOIN product p ON id.PID = p.ID 
            WHERE id.IMPORT_ID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $import_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $details = [];
        while ($row = $result->fetch_assoc()) {
            $details[] = $row;
        }
        
        $response = $details; // Trả về mảng dữ liệu nếu có
        $stmt->close();
    } else {
        $response['message'] = 'Lỗi truy vấn cơ sở dữ liệu: ' . $conn->error;
    }
    $conn->close();
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;
?>