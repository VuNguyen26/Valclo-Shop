<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("./Function/DB.php");
require_once("./Model/member.php");

$displayMessage = "Thanh toán thất bại hoặc bị hủy.";
$success = false;

// MoMo trả về resultCode = 0 là thanh toán thành công
$result = $_GET['resultCode'] ?? null;

if ($result === "0" && !empty($_SESSION["id"])) {
    $uid = (int)$_SESSION["id"];
    $db = new DB();
    $conn = $db->connect;
    $mem = new Member();

    // 1. Lấy sản phẩm trong giỏ
    $query = "SELECT p.PRICE, c.QUANTITY FROM cart c JOIN product p ON c.PID = p.ID WHERE c.UID = $uid";
    $res = mysqli_query($conn, $query);

    // 2. Kiểm tra giỏ có dữ liệu không
    if ($res && mysqli_num_rows($res) > 0) {
        $total = 0;
        while ($row = mysqli_fetch_assoc($res)) {
            $total += $row["PRICE"] * $row["QUANTITY"];
        }

        if ($total > 0) {
            // 3. Tạo đơn hàng
            $today = date("Y-m-d");
            $status = "Chờ xác nhận";
            $method = "Momo";

            $stmt = $conn->prepare("INSERT INTO `order` (UID, TIME, STATUS, TOTAL_PRICE, METHOD) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issds", $uid, $today, $status, $total, $method);
            $stmt->execute();
            $oid = $conn->insert_id;

            // 4. Ghi chi tiết đơn hàng
            $mem->insert_order_detail($oid, $uid);

            // 5. Xóa giỏ hàng
            $mem->clear_cart($uid);
            unset($_SESSION["cart"]);

            // 6. Thành công
            $success = true;
            $displayMessage = "Thanh toán MoMo thành công!";
        } else {
            $displayMessage = "Không thể tính tổng giá trị đơn hàng.";
        }
    } else {
        $displayMessage = "Giỏ hàng trống hoặc đã được xử lý trước đó.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán MoMo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f7f7f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .result-box {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      position: relative;
      width: 420px;
    }
    .result-box.success {
      border-top: 6px solid #28a745;
    }
    .result-box .icon {
      font-size: 50px;
      margin-bottom: 20px;
      color: #28a745;
    }
    .result-box h3 {
      font-weight: bold;
      margin-bottom: 10px;
    }
    .result-box p {
      margin-bottom: 10px;
    }
    .btn-primary {
      background-color: #198754;
      border-color: #198754;
    }
    .confetti-canvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
    }
  </style>
</head>
<body>
  <div class="result-box <?= $success ? 'success' : '' ?>">
    <div class="icon"><?= $success ? "✅" : "❌" ?></div>
    <h3 style="color: <?= $success ? '#198754' : '#dc3545' ?>;">
      <?= $displayMessage ?>
    </h3>
    <p><strong>Phương thức:</strong> Thanh toán qua ví MoMo.</p>
    <p>Cảm ơn bạn đã mua sắm tại <strong>Valclo Shop</strong>.</p>

    <!-- Nút hiển thị khi thanh toán thành công -->
    <?php if ($success): ?>
      <a href="?url=Home/order_detail&oids=<?= $oid ?>" class="btn btn-primary mt-3">📦 Xem chi tiết đơn hàng</a>
    <?php else: ?>
      <!-- Nút hiển thị khi thanh toán thất bại -->
      <a href="?url=Home/Home_page" class="btn btn-secondary mt-3">Quay lại trang chủ</a>
    <?php endif; ?>
  </div>

  <canvas class="confetti-canvas" id="confetti"></canvas>

  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
  <script>
    if (<?= json_encode($success) ?>) {
      confetti({
        particleCount: 120,
        spread: 120,
        origin: { y: 0.6 }
      });
      const audio = new Audio("https://cdn.pixabay.com/download/audio/2022/03/15/audio_6c6abdb845.mp3");
      audio.play();
    }
  </script>
</body>
</html>
