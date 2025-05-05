<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("./Function/DB.php");
require_once("./Model/member.php");

$displayMessage = "Thanh toán thất bại hoặc bị hủy.";
$success = false;
$oid = null;
$result = $_GET['resultCode'] ?? null;

if ($result === "0" && !empty($_SESSION["id"])) {
    $uid = (int)$_SESSION["id"];
    $db = new DB();
    $conn = $db->connect;
    $mem = new Member();

    $query = "SELECT p.PRICE, c.QUANTITY FROM cart c JOIN product p ON c.PID = p.ID WHERE c.UID = $uid";
    $res = mysqli_query($conn, $query);
    if ($res && mysqli_num_rows($res) > 0) {
        $total = 0;
        while ($row = mysqli_fetch_assoc($res)) {
            $total += $row["PRICE"] * $row["QUANTITY"];
        }

        if ($total > 0) {
            $today = date("Y-m-d");
            $status = "Chờ xác nhận";
            $method = "Momo";

            $stmt = $conn->prepare("INSERT INTO `order` (UID, TIME, STATUS, TOTAL_PRICE, METHOD) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issds", $uid, $today, $status, $total, $method);
            $stmt->execute();
            $oid = $conn->insert_id;
            $mem->insert_order_detail($oid, $uid);

            $mem->clear_cart($uid);
            unset($_SESSION["cart"]);

            $success = true;
            $displayMessage = "Bạn đã thanh toán MoMo thành công!";
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
  <title>Kết Quả Thanh Toán MoMo</title>
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
      <strong>Phương thức:</strong> Thanh toán qua ví MoMo.<br>
      Cảm ơn bạn đã mua sắm tại <strong>Valclo Shop</strong>.
    </p>
    <?php if ($success): ?>
      <a href="?url=Home/order_detail&oids=<?= $oid ?>" class="btn btn-success btn-back">📦 Xem chi tiết đơn hàng</a>
    <?php else: ?>
      <a href="?url=Home/Home_page/" class="btn btn-secondary btn-back">↩ Quay về trang chủ</a>
    <?php endif; ?>
  </div>

  <?php if ($success): ?>
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
  <script>
    confetti({
      particleCount: 120,
      spread: 100,
      origin: { y: 0.6 }
    });
    const audio = new Audio("https://cdn.pixabay.com/download/audio/2022/03/15/audio_6c6abdb845.mp3");
    audio.play();
  </script>
  <?php endif; ?>
</body>
</html>
