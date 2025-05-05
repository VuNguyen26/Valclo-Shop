<?php
header('Content-Type: application/json');
include 'connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM PRODUCT WHERE ID=$id");
    
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['error' => 'Sản phẩm không tồn tại']);
    }
} else {
    echo json_encode(['error' => 'Thiếu ID sản phẩm']);
}

$conn->close();
?>