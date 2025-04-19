<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("./Function/DB.php");
require_once("./Model/member.php");

$uid = $_SESSION["id"] ?? null;
$result = $_GET['result'] ?? '0';
$oids = $_GET['oids'] ?? '';
$success = false;
$displayMessage = "❌ Thanh toán thất bại hoặc bị hủy.";

// Nếu thanh toán thành công
if ($result === "1" && !empty($uid)) {
    $db = new DB();
    $conn = $db->connect;
    $mem = new Member();

    // Lấy sản phẩm từ giỏ hàng để tính tổng
    $query = "SELECT p.PRICE, c.QUANTITY FROM cart c JOIN product p ON c.PID = p.ID WHERE c.UID = $uid";
    $result = mysqli_query($conn, $query);
    $total = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $total += $row["PRICE"] * $row["QUANTITY"];
    }

    // Thêm vào bảng `order`
    $today = date("Y-m-d");
    $status = "Chờ xác nhận";
    $stmt = $conn->prepare("INSERT INTO `order` (UID, TIME, STATUS, TOTAL_PRICE) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $uid, $today, $status, $total);
    $stmt->execute();
    $order_id = $conn->insert_id;

    // ✅ Ghi chi tiết đơn hàng từ giỏ vào order_detail
    $mem->insert_order_detail($order_id, $uid);

    // Xoá giỏ hàng
    $mem->clear_cart($uid);
    unset($_SESSION["cart"]);

    // Cập nhật giao diện
    $success = true;
    $displayMessage = "✅ Bạn đã thanh toán PayPal thành công!";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Kết Quả Thanh Toán PayPal</title>
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
    .icon-fail {
      font-size: 60px;
      color: #dc3545;
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
    <div class="<?= $success ? 'icon-success' : 'icon-fail' ?>">
      <?= $success ? '&#10004;' : '&#10060;' ?>
    </div>
    <h3 class="<?= $success ? 'text-success' : 'text-danger' ?>">
      <?= $displayMessage ?>
    </h3>
    <p class="mt-3">
      <?php if ($success): ?>
        <strong>Phương thức:</strong> Thanh toán qua PayPal.<br>
        Cảm ơn bạn đã mua hàng tại <strong>Valclo Shop</strong>.
      <?php else: ?>
        Vui lòng thử lại hoặc chọn phương thức khác.
      <?php endif; ?>
    </p>
    <a href="<?= $success ? '?url=Home/member_page' : '?url=Home/Home_page' ?>" class="btn btn-success btn-back">
      <?= $success ? '📦 Xem chi tiết đơn hàng' : '⬅️ Về trang chủ' ?>
    </a>
  </div>

  <?php if ($success): ?>
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
  <script>
    confetti({
      particleCount: 100,
      spread: 80,
      origin: { y: 0.6 }
    });
    const audio = new Audio("https://cdn.pixabay.com/download/audio/2022/03/15/audio_6c6abdb845.mp3");
    audio.play();
  </script>
  <?php endif; ?>
</body>
</html>
