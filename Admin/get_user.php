<?php
header('Content-Type: application/json');
include 'connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM account WHERE ID=$id");
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Chuẩn hóa đường dẫn ảnh
        if (!empty($user['IMG_URL'])) {
            $relativePath = $user['IMG_URL'];
            $user['IMG_URL'] = $relativePath;
        }
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'Người dùng không tồn tại']);
    }
} else {
    echo json_encode(['error' => 'Thiếu ID người dùng']);
}

$conn->close();
?>