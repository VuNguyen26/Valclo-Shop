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
    <link href="./Views/Navbar/navbar.css" rel="stylesheet">
  </head>
  <body>
    <!--Nav-->
    <?php require_once("./Views/Navbar/index.php"); ?>
    <script src="./Views/Navbar/navbarScript.js" type="text/javascript"></script>
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
                if(!empty($data["order_combo"])){

                    foreach($data["order_combo"] as $row){
                      $count += 1;
                      $total += (int)$row["price"];
                        echo "<div class=\"col-12 mb-4\">
                        <section>
                            <div class=\"card\">
                                <div class=\"card-header text-center py-1\">
                                    <h5 class=\"mb-0 fw-bold\">" . $row["name"] . "</h5>
                                    </div>		
                                    <div class=\"card-body\">
                                        <h3 class=\"text-warning mb-2\">" . $row["price"] . "/tháng</h3>
                                        <h6>Mỗi hộp bao gồm: </h6>
                                        <ol class=\"list-group list-group-numbered\">";
                                        foreach($row["product"] as $product){
                                            echo "<li class=\"list-group-item\">" . $product["name"] . "</li>";
                                        }
                        echo        "</ol>
                                    </div>
                                    <div class=\"card-footer d-flex justify-content-between py-3\">
                                    <h4>Chu kì: " . $row["cycle"] . "</h4><h4>Size: " . $row["size"] . "</h4>";
                      echo "</div></div></section></div>";
                    }
                }
                    if(!empty($data["product_in_cart"]))
                    {
                      foreach($data["product_in_cart"] as $row){
                        $count += 1;
                        $total += (int)$row["price"]*$row["num"];
                        echo "<div class=\"col-12\">
                        <div class=\"row node nonemg\"><span hidden>" . $row["oid"] . "</span>
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
        </div>
    </div>

    
    
    <?php require_once("./Views/footer/index.php");?>
    <!--Footer-->
    </body>
</html>
