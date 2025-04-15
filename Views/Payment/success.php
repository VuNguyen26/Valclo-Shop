<?php
$result = $_GET['resultCode'] ?? null;
$message = $_GET['message'] ?? '';
$orderIds = $_GET['oids'] ?? '';

$displayMessage = "❌ Thanh toán thất bại hoặc bị hủy.";
$callUpdate = false;

if ($result === "0" && !empty($orderIds)) {
    $displayMessage = "✅ Thanh toán MoMo thành công!";
    $callUpdate = true;
    require_once("./Function/DB.php");
    require_once("./Model/member.php");
    if (!empty($_SESSION["id"])) {
        $mem = new Member();
        $mem->clear_cart($_SESSION["id"]);
    }
    $oidArray = explode("/", $orderIds);
    $count = count($oidArray);
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
        <?= htmlspecialchars($message) ?><br>
        Vui lòng thử lại hoặc chọn phương thức khác.
      <?php endif; ?>
    </p>
    <a href="?url=Home/Home_page" class="btn btn-success btn-back">⬅️ Về trang chủ</a>
  </div>

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
