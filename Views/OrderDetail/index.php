<?php
/** @var array $order */
/** @var mysqli_result $order["items"] */
/** @var array $user */
$order = $data["order"];
$user = mysqli_fetch_array($data["user"], MYSQLI_ASSOC);
$total = 0;

function render_state($state) {
  return match($state) {
    0 => '⏳ Chờ xác nhận',
    1 => '✅ Đã thanh toán',
    2 => '🚞 Đang giao hàng',
    3 => '🛢️ Đã nhận hàng',
    4 => '❌ Đã hủy',
    default => 'Không xác định'
  };
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      margin-top: 60px;
    }
    .order-summary {
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .order-summary h2 {
      margin-bottom: 20px;
    }
    .order-product {
      border-bottom: 1px solid #ddd;
      padding: 15px 0;
    }
    .order-product:last-child {
      border-bottom: none;
    }
    .product-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 6px;
    }
    .section-title {
      margin-top: 30px;
      margin-bottom: 15px;
      font-weight: bold;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="order-summary">
    <h2>Chi tiết đơn hàng #<?= $order['id'] ?></h2>

    <div class="section-title">Thông tin đơn hàng:</div>
    <p><strong>Trạng thái:</strong> <?= render_state($order['state']) ?></p>
    <p><strong>Ngày đặt hàng:</strong> <?= $order['time'] ?></p>
    <p><strong>Địa chỉ giao hàng:</strong> <?= $user['add'] ?? 'Không có thông tin' ?></p>
    <p><strong>Ghi chú:</strong> (Chưa có ghi chú)</p>

    <?php if ($order['state'] == 0): ?>
      <form method="POST" action="?url=Order/cancel">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
        <button class="btn btn-danger mb-3">❌ Hủy đơn hàng</button>
      </form>
    <?php endif; ?>

    <div class="section-title">Sản phẩm:</div>
    <?php while($product = mysqli_fetch_array($order['items'], MYSQLI_ASSOC)): 
      $total += $product['price'] * $product['num'];
    ?>
      <div class="row order-product align-items-center">
        <div class="col-2">
          <img src="<?= $product['img'] ?>" class="product-img" alt="img">
        </div>
        <div class="col-6">
          <h5><?= $product['name'] ?></h5>
          <p>Size: <?= $product['size'] ?> | SL: <?= $product['num'] ?></p>
        </div>
        <div class="col-4 text-end">
          <strong><?= number_format($product['price'], 0, ',', '.') ?>đ</strong>
        </div>
      </div>
    <?php endwhile; ?>

    <div class="section-title">Thanh toán:</div>
    <p><strong>Tổng thanh toán:</strong> <?= number_format($total, 0, ',', '.') ?>đ</p>
    <p><strong>Phương thức thanh toán:</strong> <?= $order['method'] ? ucfirst($order['method']) : 'Không có' ?></p>

    <div class="text-center mt-4">
      <a href="?url=Home/member_page" class="btn btn-secondary">
        Quay về lịch sử giao dịch
      </a>
    </div>
  </div>
</div>
</body>
</html>
