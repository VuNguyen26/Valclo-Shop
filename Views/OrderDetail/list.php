<?php
/** @var mysqli_result $orders */
/** @var array $user */
$user = mysqli_fetch_array($data["user"], MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách đơn hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      margin-top: 60px;
    }
    .order-card {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.05);
    }
    .order-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
    .badge-status {
      font-size: 0.9em;
    }
  </style>
</head>
<body>
<div class="container">
  <h2 class="mb-4">🧾 Danh sách đơn hàng của bạn</h2>

  <?php
    function render_state($state) {
      return match((int)$state) {
        0 => '<span class="badge bg-warning text-dark badge-status">Chờ xác nhận</span>',
        1 => '<span class="badge bg-success badge-status">Đã thanh toán</span>',
        2 => '<span class="badge bg-info text-dark badge-status">Đang giao hàng</span>',
        3 => '<span class="badge bg-primary badge-status">Đã nhận hàng</span>',
        4 => '<span class="badge bg-danger badge-status">Đã hủy</span>',
        default => '<span class="badge bg-secondary badge-status">Không xác định</span>'
      };
    }
  ?>

  <?php while ($order = mysqli_fetch_array($data['orders'], MYSQLI_ASSOC)): ?>
    <div class="order-card">
      <div class="order-header">
        <h5>Đơn hàng #<?= $order['id'] ?> - <?= date("d/m/Y H:i", strtotime($order['time'])) ?></h5>
        <?= render_state($order['state']) ?>
      </div>
      <p><strong>Tổng tiền:</strong> <?= number_format($order['total'], 0, ',', '.') ?>đ</p>
      <p><strong>Phương thức thanh toán:</strong> <?= ucfirst($order['method'] ?? 'Không rõ') ?></p>
      <a href="?url=OrderDetail/index&id=<?= $order['id'] ?>" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
    </div>
  <?php endwhile; ?>

  <div class="text-center mt-4">
    <a href="?url=Home/member_page" class="btn btn-secondary">⬅️ Quay về trang thành viên</a>
  </div>
</div>
</body>
</html>
