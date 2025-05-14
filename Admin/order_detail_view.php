<?php 
include 'connect.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('location:admin_login.php');
    exit;
}

$order_id = $_GET['order_id'] ?? 0;

if ($order_id) {
    // Lấy thông tin đơn hàng
    $orderQuery = "
        SELECT o.ID, o.TIME, o.TOTAL_PRICE, o.STATUS, o.METHOD, a.FNAME, a.EMAIL
        FROM `order` o
        JOIN account a ON o.UID = a.ID
        WHERE o.ID = ?
    ";
    $stmt = $conn->prepare($orderQuery);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    // Lấy chi tiết đơn hàng
    $detailsQuery = "
        SELECT p.NAME, p.PRICE, od.QUANTITY, od.SIZE, p.IMG_URL
        FROM order_detail od
        JOIN product p ON od.PID = p.ID
        WHERE od.ORDER_ID = ?
    ";
    $stmt = $conn->prepare($detailsQuery);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $details = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #<?php echo $order_id; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .main-content {
            margin-left: 250px; /* Để chừa chỗ cho sidebar */
            padding: 2rem;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <div class="container-fluid d-flex p-0">
        <?php include 'admin_header.php'; ?>

        <main class="main-content flex-grow-1">
            <?php if ($order): ?>
                <h2 class="mb-4">Chi tiết đơn hàng #<?php echo $order['ID']; ?></h2>
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['FNAME']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['EMAIL']); ?></p>
                        <p><strong>Ngày đặt:</strong> <?php echo $order['TIME']; ?></p>
                        <p><strong>Tổng tiền:</strong> <?php echo number_format($order['TOTAL_PRICE'], 0, ',', '.'); ?> VND</p>
                        <p><strong>Trạng thái:</strong> <?php echo $order['STATUS']; ?></p>
                        <p><strong>Phương thức thanh toán:</strong> <?php echo $order['METHOD']; ?></p>
                    </div>
                </div>

                <h4 class="mt-4">Sản phẩm trong đơn hàng</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Size</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($details as $item): ?>
                                <tr>
                                    <td><img src="<?php echo $item['IMG_URL']; ?>" alt="Sản phẩm" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                    <td><?php echo htmlspecialchars($item['NAME']); ?></td>
                                    <td><?php echo $item['SIZE']; ?></td>
                                    <td><?php echo $item['QUANTITY']; ?></td>
                                    <td><?php echo number_format($item['PRICE'], 0, ',', '.'); ?> VND</td>
                                    <td><?php echo number_format($item['PRICE'] * $item['QUANTITY'], 0, ',', '.'); ?> VND</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a href="index.php" class="btn btn-secondary mt-3">Quay lại</a>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Đơn hàng không tồn tại.
                </div>
            <?php endif; ?>
        </main>
    </div>

    <?php include 'admin_footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
