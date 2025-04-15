<?php

$result = $_GET['resultCode'] ?? null;
$orderIds = $_GET['oids'] ?? '';
$message = $_GET['message'] ?? '';  // Khởi tạo thông điệp mặc định

require_once("./Function/DB.php");
require_once("./Model/member.php");

$displayMessage = "Thanh toán thất bại.";
$callUpdate = false;

if ($result === "0" && !empty($orderIds)) {
    // Thanh toán thành công
    $displayMessage = "✅ Thanh toán MoMo thành công!";
    $callUpdate = true;

    // Chỉ xóa giỏ hàng khi thanh toán thành công
    if (!empty($_SESSION["id"])) {
        $uid = $_SESSION["id"];
        $mem = new Member();
        $mem->clear_cart($uid);
    }

    // Lưu thông tin vào bảng `transaction_history`
    $db = new DB(); // Create DB object
    $oidArray = explode("/", $orderIds);
    $count = count($oidArray);

    foreach ($oidArray as $orderId) {
        // Cập nhật trạng thái thanh toán trong bảng `order`
        $update_order_sql = "UPDATE `order` SET `payment_status` = 'completed' WHERE `ID` = ?";
        $stmt = mysqli_prepare($db->connect, $update_order_sql);
        mysqli_stmt_bind_param($stmt, "i", $orderId);
        mysqli_stmt_execute($stmt);

        // Save transaction info to transaction_history table
        $transaction_sql = "INSERT INTO `transaction_history` (order_id, transaction_id, payment_method, amount, status) 
                             VALUES (?, ?, 'COD', (SELECT TOTAL_PRICE FROM `order` WHERE ID = ?), 'completed')";
        $stmt = mysqli_prepare($db->connect, $transaction_sql);
        $transaction_id = uniqid('COD_'); // Generate unique transaction ID for COD
        mysqli_stmt_bind_param($stmt, "isi", $orderId, $transaction_id, $orderId);
        mysqli_stmt_execute($stmt);
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Kết quả thanh toán</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f3f3f3;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .card-box {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      text-align: center;
      animation: fadeIn 1s ease-in-out;
    }
    .icon-success {
      font-size: 60px;
      color: #28a745;
      margin-bottom: 20px;
    }
    .btn-back {
      margin-top: 20px;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="card-box">
    <div class="<?= $callUpdate ? 'icon-success' : 'icon-fail' ?>">
      <?= $callUpdate ? '&#10004;' : '&#10060;' ?>
    </div>
    <h3 class="<?= $callUpdate ? 'text-success' : 'text-danger' ?>">
      <?= $displayMessage ?>
    </h3>
    <p class="mt-3">
      <?php if ($callUpdate): ?>
        Cảm ơn bạn đã mua hàng tại <strong>Valclo Shop</strong>.
      <?php else: ?>
        Vui lòng thử lại hoặc chọn phương thức khác.
      <?php endif; ?>
    </p>
    <!-- Nút "Xem chi tiết đơn hàng" -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderDetailModal">Xem chi tiết đơn hàng</button>
  </div>

  <!-- Modal (Popup) để hiển thị chi tiết đơn hàng -->
  <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Giá</th>
              </tr>
            </thead>
            <tbody id="orderDetails">
              <!-- Chi tiết đơn hàng sẽ được tải ở đây -->
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <!-- Nút Quay về trang chủ -->
          <a href="index.php" class="btn btn-success">Quay về trang chủ</a>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript để hiển thị chi tiết đơn hàng -->
  <script>
    // Giả sử bạn có thông tin chi tiết đơn hàng từ server hoặc có dữ liệu mẫu
    let orderDetailsData = [
      { product_name: "Sản phẩm 1", quantity: 2, price: 200000 },
      { product_name: "Sản phẩm 2", quantity: 1, price: 150000 }
    ];

    // Hàm để hiển thị chi tiết đơn hàng vào modal
    function displayOrderDetails() {
      const orderDetailsTable = document.getElementById('orderDetails');
      orderDetailsTable.innerHTML = '';  // Xóa dữ liệu cũ trong bảng

      orderDetailsData.forEach(detail => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${detail.product_name}</td>
          <td>${detail.quantity}</td>
          <td>${detail.price.toLocaleString()} VND</td>
        `;
        orderDetailsTable.appendChild(row);
      });
    }

    // Lắng nghe sự kiện khi modal mở ra để hiển thị chi tiết đơn hàng
    $('#orderDetailModal').on('shown.bs.modal', function () {
      displayOrderDetails(); // Hiển thị chi tiết đơn hàng khi modal được mở
    });
  </script>

  <!-- Thêm các thư viện Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

  <?php if ($callUpdate): ?>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
    <script>
      confetti({ particleCount: 100, spread: 80, origin: { y: 0.6 } });
      const audio = new Audio("https://cdn.pixabay.com/download/audio/2022/03/15/audio_6c6abdb845.mp3");
      audio.play();

      // Gọi đúng URL update
      const updateUrl = "?url=Home/update_cart_combo/<?= $count ?>/<?= $orderIds ?>";
      fetch(updateUrl)
        .then(res => res.text())
        .then(data => console.log("✅ MoMo update:", data));
    </script>
  <?php endif; ?>
</body>
</html>
