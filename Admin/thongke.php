<?php

// Thong ke doanh thu theo tuan
$moneyTuanResult = $conn->query("
    SELECT SUM(TOTAL_PRICE) AS money_week
    FROM `order`
    WHERE WEEK(TIME) = WEEK(CURDATE()) AND YEAR(TIME) = YEAR(CURDATE())
");
$moneyTuan = $moneyTuanResult->fetch_assoc()['money_week'] ?? 0;

// Thong ke doanh thu theo thang
$moneyThangResult = $conn->query("
    SELECT SUM(TOTAL_PRICE) AS money_month
    FROM `order`
    WHERE MONTH(TIME) = MONTH(CURDATE()) AND YEAR(TIME) = YEAR(CURDATE())
");
$moneyThang = $moneyThangResult->fetch_assoc()['money_month'] ?? 0;

// So don hang dc dat trong tuan
$orderTuanResult = $conn->query("
    SELECT COUNT(ID) AS order_week
    FROM `order`
    WHERE WEEK(TIME) = WEEK(CURDATE()) AND YEAR(TIME) = YEAR(CURDATE())
");
$orderTuan = $orderTuanResult->fetch_assoc()['order_week'] ?? 0;

// So don hang dc dat trong thang
$orderThangResult = $conn->query("
    SELECT COUNT(ID) AS order_month
    FROM `order`
    WHERE MONTH(TIME) = MONTH(CURDATE()) AND YEAR(TIME) = YEAR(CURDATE())
");
$orderThang = $orderThangResult->fetch_assoc()['order_month'] ?? 0;

// So tai khoan ng dung hien co
$userCountResult = $conn->query("
    SELECT COUNT(ID) AS user_count
    FROM `account`
");
$userCount = $userCountResult->fetch_assoc()['user_count'] ?? 0;

// So luot gop y
$messageCountResult = $conn->query("
    SELECT COUNT(ID) AS message_count
    FROM `message`
");
$messageCount = $messageCountResult->fetch_assoc()['message_count'] ?? 0;

// Top sp ban chay

$bestSellingProductsResult = $conn->query("
    SELECT p.NAME, p.IMG_URL, 
           SUM(od.QUANTITY) AS total_quantity, 
           SUM(od.QUANTITY * p.PRICE) AS total_revenue
    FROM product p
    LEFT JOIN order_detail od ON p.ID = od.PID
    GROUP BY p.ID
    ORDER BY total_quantity DESC
    LIMIT 3
");

?>


<div class="wrapper">
    <div class="group-container">
        <div class="group">
            <h2>Thống kê doanh thu theo tuần: <?php echo number_format($moneyTuan, 0, ',', '.'); ?></h2>
            <h2>Số đơn hàng được đặt trong tuần: <?php echo ($orderTuan); ?></h2>
            <h2>Số tài khoản người dùng hiện có: <?php echo ($userCount); ?></h2>
        </div>
        <div class="group">
            <h2>Thống kê doanh thu theo tháng: <?php echo number_format($moneyThang, 0, ',', '.'); ?></h2>
            <h2>Số đơn hàng được đặt trong tháng: <?php echo ($orderThang); ?></h2>
            <h2>Số lượt góp ý: <?php echo ($messageCount); ?></h2>
        </div>
    </div>

    <h2 style="margin-top: 40px">Top 3 các sản phẩm bán chạy:</h2>
    <?php if ($bestSellingProductsResult && $bestSellingProductsResult->num_rows > 0): ?>
        <div class="product-list">
            <?php while ($product = $bestSellingProductsResult->fetch_assoc()): ?>
                <div class="product-item">
                    <p><strong><?php echo $product['NAME']; ?></strong></p>
                    <img src="<?php echo $product['IMG_URL']; ?>" alt="Sản phẩm bán chạy" style="max-width: 80px; border-radius: 8px;">
                    <p>Số lượng bán được: <?php echo $product['total_quantity']; ?></p>
                    <p>Tổng tiền bán được: <?php echo number_format($product['total_revenue'], 0, ',', '.'); ?> VND</p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>Không có sản phẩm bán chạy.</p>
    <?php endif; ?>
</div>

<style>
h2 {
    font-family: 'Arial', sans-serif; 
    font-size: 33px;
    font-weight: bold;
    color: #222;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}
</style>
