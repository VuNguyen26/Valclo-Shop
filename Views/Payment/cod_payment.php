<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once("./Function/DB.php");
require_once("./Model/member.php");
require_once("./Controller/Home.php");

if (!isset($_GET["oids"]) || empty($_SESSION["id"])) {
    die("Thiếu thông tin để tạo đơn hàng.");
}

$user_id = $_SESSION["id"];
$oids = $_GET["oids"];
$params = ["member", "update_cart", $oids];

$home = new Home();
ob_start();
$home->update_cart("member", $params);
require_once("./Model/member.php");
$mem = new Member();
$mem->clear_cart($_SESSION["id"]);
ob_end_clean();
require_once("./Model/member.php");
$mem = new Member();
$mem->clear_cart($_SESSION["id"]);

$mem = new Member();
$mem->clear_cart($user_id);
unset($_SESSION["cart"]);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh Toán Thành Công (COD)</title>
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
    <div class="icon-success">&#10004;</div>
    <h3 class="text-success">✅ Đơn hàng của bạn đã được ghi nhận!</h3>
    <p class="mt-3">
      <strong>Phương thức:</strong> Thanh toán khi nhận hàng (COD).<br>
      Cảm ơn bạn đã mua sắm tại <strong>Valclo Shop</strong>.
    </p>
    <a href="?url=Home/member_page" class="btn btn-success btn-back">📦 Xem chi tiết đơn hàng</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
  <script>
    confetti({ particleCount: 120, spread: 100, origin: { y: 0.6 } });
    const audio = new Audio("https://cdn.pixabay.com/download/audio/2022/03/15/audio_6c6abdb845.mp3");
    audio.play();
  </script>
</body>
</html>
