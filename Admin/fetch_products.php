<?php
header('Content-Type: application/json; charset=UTF-8');
include 'connect.php';

// Kiểm tra kết nối cơ sở dữ liệu
if ($conn->connect_error) {
    echo json_encode([
        'error' => 'Lỗi kết nối cơ sở dữ liệu: ' . $conn->connect_error
    ]);
    exit;
}

// Phân trang
$limit = 10; // Số sản phẩm mỗi trang
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Lấy tổng số sản phẩm
$totalResult = $conn->query("SELECT COUNT(*) as total FROM PRODUCT");
if (!$totalResult) {
    echo json_encode([
        'error' => 'Lỗi truy vấn tổng số sản phẩm: ' . $conn->error
    ]);
    exit;
}
$totalRow = $totalResult->fetch_assoc();
$totalProducts = $totalRow['total'];
$totalPages = ceil($totalProducts / $limit);

// Truy vấn danh sách sản phẩm
$result = $conn->query("
    SELECT p.ID, p.NAME, p.PRICE, p.IMG_URL, p.NUMBER, p.DECS, c.name_category AS CATEGORY, p.TOP_PRODUCT 
    FROM PRODUCT p
    LEFT JOIN CATEGORY c ON p.CATEGORY = c.id
    ORDER BY p.ID ASC
    LIMIT $limit OFFSET $offset
");
if (!$result) {
    echo json_encode([
        'error' => 'Lỗi truy vấn danh sách sản phẩm: ' . $conn->error
    ]);
    exit;
}

// Tạo mảng dữ liệu sản phẩm
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Trả về dữ liệu JSON
echo json_encode([
    'products' => $products,
    'totalPages' => $totalPages,
    'currentPage' => $page,
    'error' => null
]);

$conn->close();
?>