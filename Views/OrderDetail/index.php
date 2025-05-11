<?php
/** @var array $order */
/** @var mysqli_result $order["items"] */
/** @var array $user */
$order = $data["order"];
$user  = mysqli_fetch_array($data["user"], MYSQLI_ASSOC);

$total = $order['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .container { margin-top: 60px; }
    .order-summary { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .order-summary h2 { margin-bottom: 20px; }
    .order-product { border-bottom: 1px solid #ddd; padding: 15px 0; }
    .order-product:last-child { border-bottom: none; }
    .product-img { width: 80px; height: 80px; object-fit: cover; border-radius: 6px; }
    .section-title { margin-top: 30px; margin-bottom: 15px; font-weight: bold; }
  </style>
</head>
<body>
<div class="container">
  <div class="order-summary">
    <h2>Chi tiết đơn hàng #<?= htmlspecialchars($order['id']) ?></h2>

    <div class="section-title">Thông tin đơn hàng:</div>
    <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['state']) ?></p>
    <p><strong>Ngày đặt hàng:</strong> <?= htmlspecialchars($order['time']) ?></p>
    <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($user['add'] ?? 'Không có thông tin') ?></p>

    <?php if ($order['state'] == 'Chờ xác nhận'): ?>
      <form method="POST" action="?url=Order/cancel">
        <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
        <button class="btn btn-danger mb-3">❌ Hủy đơn hàng</button>
      </form>
    <?php endif; ?>

    <div class="section-title">Sản phẩm:</div>
    <?php while ($product = mysqli_fetch_array($order['items'], MYSQLI_ASSOC)): ?>
      <div class="row order-product align-items-center">
        <div class="col-2">
          <img src="<?= htmlspecialchars($product['img']) ?>" class="product-img" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="col-6">
          <h5><?= htmlspecialchars($product['name']) ?></h5>
          <p>Size: <?= htmlspecialchars($product['size']) ?> | SL: <?= htmlspecialchars($product['num']) ?></p>
        </div>
        <div class="col-4 text-end">
          <strong><?= number_format($product['price'] * $product['num'], 0, ',', '.') ?>đ</strong>
        </div>
      </div>
    <?php endwhile; ?>

    <div class="section-title">Thanh toán:</div>
    <p><strong>Tổng thanh toán:</strong> <?= number_format($total, 0, ',', '.') ?>đ</p>
    <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars(ucfirst($order['method'] ?? '')) ?: 'Không có' ?></p>

    <div class="text-center mt-4">
      <a href="?url=Home/member_page" class="btn btn-secondary">
        Quay về lịch sử giao dịch
      </a>
    </div>
  </div>
</div>
</body>
</html>
