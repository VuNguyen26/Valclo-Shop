<!DOCTYPE html>
<html>
  <head>
    <!-- setting page -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Payment page">
    <meta name="author" content="Phạm Khánh Huy">

    <title>Valcloshop - Thanh Toán</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="./Views/images/avatar.png"
    />

    <!-- link icon -->
    <script src="https://kit.fontawesome.com/320d0ac08e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="./Views/Payment/style.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,400;0,500;0,600;0,700;0,800;1,200;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/721412f694.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"></script>
    <link href="./Views/Navbar/navbar.css" rel="stylesheet">
  </head>
  <body>
    <!--Nav-->
    <?php require_once("./Views/Navbar/index.php"); ?>
    <!--Nav-->

    <!--Body-->
    <div class="container-fuild payment">
        <div class="row nonemg d-flex justify-content-center">
          <div class="col-12 col-md-6 white nonepad">
            <h3>Các sản phẩm của bạn</h3>
            <div class="row nonemg text-center">
              <?php
              $count = 0;
              $total = 0;
              $check = 0;
                    if(!empty($data["product_in_cart"]))
                    {
                      foreach($data["product_in_cart"] as $row){
                        $count += 1;
                        $total += (int)$row["price"]*$row["num"];
                        echo "<div class=\"col-12\">
                        <div class=\"row node nonemg\">
                            <div class=\"col-4 d-flex flex-wrap align-content-center justify-content-center\">
                                <img src=\"" . $row["img"] . "\" alt=\"item\">
                            </div>
                            <div class=\"col-8\">
                                <div class=\"row\">
                                    <div class=\"col-12\">
                                        <h5>" . $row["name"] . "</h5>
                                    </div>
        
                                    <div class=\"col-12\">Size: <span>" . $row["size"] . "</span></div>
                                    <div class=\"col-12\">Số lượng: <span>" . $row["num"] . "</span></div>
                                    <div class=\"col-12\">Tổng cộng: <span class=\"price\">" . $row["price"]*$row["num"] . "(đ)</span></div>
                                </div>
                            </div>
                        </div>
                      </div>";
                    }
                }
              ?>
            </div>
          </div>
          <div class="col-12 col-md-6 col-xl-4 white nonepad body_2">
              <h3>Phương thức thanh toán</h3>
              <div class="row d-flex justify-content-center nonemg">
                <div class="col-12 cart_node">
                  <div class="row">
                    <div class="col-2"><input type="radio" name="cart_node" id="cod"></div>
                    <div class="col-5"><label for="cod"><h5>Thanh toán tiền mặt</h5></label></div>
                    <div class="col-5 d-flex justify-content-end"><label for="cod"><img src="https://png.pngtree.com/png-clipart/20210530/original/pngtree-green-banner-cod-cash-on-delivery-flat-hand-grab-money-and-png-image_6351009.jpg" alt="COD picture" ></label></div>
                  </div>
                </div>
                <div class="col-12 cart_node">
                  <div class="row">
                    <div class="col-2"><input type="radio" name="cart_node" id="momo"></div>
                    <div class="col-5"><label for="momo"><h5>MoMo</h5></label></div>
                    <div class="col-5 d-flex justify-content-end"><label for="momo"><img src="./Views/images/MoMo Logo.png" alt="MoMo picture" ></label></div>
                  </div>
                </div>
                <div class="col-12 cart_node">
                  <div class="row">
                    <div class="col-2"><input type="radio" name="cart_node" id="paypal"></div>
                    <div class="col-5"><label for="paypal"><h5>Paypal</h5></label></div>
                    <div class="col-5 d-flex justify-content-end"><label for="paypal"><img src="./Views/images/paypal.png" alt="paypal picture" ></label></div>
                  </div>
                </div>
              </div>

              <div class="row nonemg flex-wrap total">
                <h4>Tổng kết hóa đơn</h4>
                <div class="col-12">
                  <div class="d-flex justify-content-between">
                    <h6>Tổng phụ (<?php echo $count;?> sản phẩm)</h6><span><?php echo $total ?></span>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-flex justify-content-between">
                    <h6>Phí ưu đãi thành viên</h6><span>23,000(đ)</span>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-flex justify-content-between">
                    <h6>Giảm giá sản phẩm</h6><span>5,000(đ)</span>
                  </div>
                </div>
                
                <div class="col-12">
                  <div class="d-flex justify-content-between line-top">
                    <h6>Tổng cộng: </h6><span></span>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-flex flex-wrap justify-content-end">
                    <?php 
                          echo "<button id=\"myBtn\" type=\"button\" class=\"btn btn-primary\">Hủy đơn</button>";
                    ?>
                    <button id="payButton" type="button" class="btn btn-primary">Đặt Hàng</button>
                  </div>
                </div>
              </div>

          </div>
        </div>
    </div>

    <div id="myModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Credit Card <i class="fab fa-cc-visa"></i></h2>
          <span class="close">&times;</span>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-12"><div class="row">
                  <div class="col-4">Số card:  </div>
                  <div class="col-8"><input type="number" name="number" placeholder="Credit card number">
              </div></div></div>
              <div class="col-12"><div class="row">
                  <div class="col-4">Hiệu lực thẻ: </div>
                  <div class="col-8"><input type="text" name="date" placeholder="mm/yyyy">
              </div></div></div>
               <div class="col-12"><div class="row">
                  <div class="col-4">CVV: </div>
                  <div class="col-8"><input type="number" name="cvv">
              </div></div></div>
              <button type="button" class="btn btn-primary">Hoàn tất</button>
          </div>
        </div>
      </div>
    </div>
    <!--Body-->

    <!--Footer-->
    <!--div class="footer-holder"></div>
    <script src="./Views/footer/footerScript.js"></script-->
    
    <?php require_once("./Views/footer/index.php");?>
    <!--Footer-->
  <?php
        echo "<script src=\"./Views/Payment/myScript.js\"></script>";
  ?>
<script>
  document.getElementById("payButton").addEventListener("click", function () {
    const momo = document.getElementById("momo").checked;
    const paypal = document.getElementById("paypal").checked;
    const cod = document.getElementById("cod").checked;

    var string = list_oid.join("/"); // danh sách id sản phẩm trong giỏ hàng

    if (momo) {
      window.location.href = "./Views/Payment/momo_payment.php?oids=" + string;
    } else if (paypal) {
      window.location.href = "?url=Payment/paypal_button&oids=" + string;
    } else if (cod) {
      window.location.href = "?url=Payment/cod_payment";
    } else {
      alert("❌ Vui lòng chọn phương thức thanh toán");
    }
  });
</script>


  </body>
</html>
