<?php
  $oids = isset($_GET['oids']) ? $_GET['oids'] : ''; // ví dụ: 3/5/7
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán PayPal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://www.paypal.com/sdk/js?client-id=ARm_K-bIBP2LBlHQOouy40v8FxMcZn8wyNHQa6ENS2GJq2NSR6fvGpvdeFIJhE0GYZZtf0OKzOfgUFlk&currency=USD"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
    }
    .container-box {
      max-width: 500px;
      margin: 100px auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      text-align: center;
    }
    h2 {
      margin-bottom: 20px;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container-box">
    <h2>Thanh toán đơn hàng bằng PayPal</h2>
    <div id="paypal-button-container"></div>
  </div>

  <script>
    const orderIds = "<?= $oids ?>";

    paypal.Buttons({
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '10.00'
            }
          }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          if (orderIds !== '') {
            fetch("?url=Home/update_cart_combo/" + orderIds)
              .then(() => {
                window.location.href = "?url=Payment/success_paypal&result=1&oids=" + orderIds;
              });
          } else {
            window.location.href = "?url=Payment/success_paypal&result=0";
          }
        });
      }
    }).render('#paypal-button-container');
  </script>
</body>
</html>
