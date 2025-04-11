<?php
$result = $_GET['result'] ?? '0';
$oids = $_GET['oids'] ?? '';

$displayMessage = "❌ Thanh toán thất bại hoặc bị hủy.";
$success = false;

if ($result === "1" && !empty($oids)) {
    $displayMessage = "✅ Bạn đã thanh toán PayPal thành công!";
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Kế Quả Thanh Toán PayPal</title>
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
        Cảm ơn bạn đã mua hàng tại <strong>Valclo Shop</strong>.
      <?php else: ?>
        Vui lòng thử lại hoặc chọn phương thức khác.
      <?php endif; ?>
    </p>
    <a href="?url=Home/Home_page" class="btn btn-success btn-back">⬅️ Về trang chủ</a>
  </div>

  <?php if ($success): ?>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
    <script>
  // Bắn confetti và nhạc
  confetti({
    particleCount: 100,
    spread: 80,
    origin: { y: 0.6 }
  });

  const audio = new Audio("https://cdn.pixabay.com/download/audio/2022/03/15/audio_6c6abdb845.mp3");
  audio.play();

  // 👉 Thêm logic đếm số lượng OID
  const oids = "<?= $oids ?>"; // Ví dụ: "66" hoặc "66/67/68"
  const count = oids.split("/").length;

  fetch("?url=Home/update_cart_combo/customer/<?= $oids ?>")
  .then(res => res.text())
  .then(data => console.log("✅ Cập nhật giỏ hàng:", data));
</script>
  <?php endif; ?>
</body>
</html>
