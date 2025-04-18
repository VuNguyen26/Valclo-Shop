<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Valcloshop - Sản phẩm</title>
    <link rel="icon" type="image/x-icon" href="./Views/images/avatar.png">

    <link href="./Views/Products/style.css" rel="stylesheet" type="text/css" />
    <link href="./Views/Navbar/navbar.css" rel="stylesheet" type="text/css" />
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
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
      integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
      crossorigin="anonymous"
    ></script>
    <!-- Latest compiled and minified CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <div class="company-product">

      <!-- Navigation -->
      <?php require_once("./Views/Navbar/index.php"); ?>
      
      <!-- Filter bar and sort -->
      <div class="header-product">
          <?php
            if($data["user"] == "customer" || $data["user"] == "member"){
              (isset($_GET['sort-by']) && $_GET['sort-by'] === 'pname') ? $select_pname = 'selected' : $select_pname = '';
              (isset($_GET['sort-by']) && $_GET['sort-by'] === 'price') ? $select_price = 'selected' : $select_price = '';
              (isset($_GET['order-by']) && $_GET['order-by'] === 'ASC') ? $select_asc = 'selected' : $select_asc = '';
              (isset($_GET['order-by']) && $_GET['order-by'] === 'DESC') ? $select_desc = 'selected' : $select_desc = '';
              $page = $data['product']['active_page'];

              # render option category
              (isset($_GET['category']) && $_GET['category'] == 'all') ? $choose_all = 'selected' : $choose_all = '';

              $render_option_category = '<option '. $choose_all .' value="all">Tất cả</option>';
              foreach($data["cate"] as $row){
                $name_category = $row["name_category"];
                (isset($_GET['category']) && $_GET['category'] == $name_category) ? $choose = 'selected' : $choose = '';
                $render_option_category .= <<<HTML
                    <option {$choose} value="{$name_category}">{$name_category}</option>
                HTML;
              }
                
              echo 
              <<<HTML
              <form class="container-fluid px-5 d-flex justify-content-between" action="/" method="GET">
                <input type="hidden" name="url" value="Home/Products">
                <input type="hidden" name="search" value="">
                <div class="col-6 p-0">
                  <div class="w-50">
                    <label for="sort-by">Danh mục</label>
                    <select class="w-100" name="category" id="sort-by">
                      {$render_option_category}
                    </select>
                  </div>
                </div>
                <div class="col-6 p-0 d-flex justify-content-end gap-2">
                  <div class="col-3">
                    <label for="sort-by">Sắp xếp theo</label>
                    <select class="w-100" name="sort-by" id="sort-by">
                      <option {$select_pname} value="pname">Tên sản phẩm</option>
                      <option {$select_price} value="price">Giá sản phẩm</option>
                    </select>
                  </div>
                  <div class="col-3">
                    <label for="order-by">Thứ tự</label>
                    <select class="w-100" name="order-by" id="order-by">
                      <option {$select_asc} value="ASC">Tăng dần</option>
                      <option {$select_desc} value="DESC">Giảm dần</option>
                    </select>
                  </div>
                  <input type="hidden" name="page" value="{$page}">
                  <div class="col-3 d-flex flex-column">
                    <label class="invisible" for="order-by">Action</label>
                    <button class="btn btn-warning" type="submit"><i class="fa-sm fas fa-search me-2"></i>Lọc</button>
                  </div>
                </div>
            </form>
            HTML;
            } else if($data["user"] == "manager") {
              echo "<div class=\"form-sort\">
                    <button type=\"button\" id=\"add-itemBtn\"><i class=\"fas fa-plus\"></i> Thêm sản phẩm</button></div>
                    <div id=\"addItem-modal\" class=\"add-item-modal\">
                    <div class=\"addItem-modal-content\">
                      <div class=\"addItem-modal-header\">
                        <span class=\"close-modal-add\">&times;</span>
                        <h2>Thêm sản phẩm</h2>
                      </div>
                      <div class=\"addItem-modal-body\">
                        <form action=\"?url=Home/add_new_item\" method=\"POST\" class=\"needs-validation \" novalidate=\"\" enctype=\"multipart/form-data\">
                          <div class=\"row\">
                            <label class=\"col-lg-4\" for=\"iname\">
                              Tên sản phẩm:
                            </label>
                            <div class=\"col-lg-8\"><input type=\"text\" name=\"iname\" placeholder=\"Nhập tên sản phẩm\" class=\"form-control is-valid\" id=\"validationSuccess\" required></div>
                          </div>
                          <div class=\"row\">
                            <label class=\"col-lg-4\" for=\"price\">
                              Giá:
                            </label>
                            <div class=\"col-lg-8\"><input type=\"number\" name=\"price\" placeholder=\"Nhập giá của sản phẩm\" class=\"form-control is-valid\" id=\"validationSuccess\" required></div>
                          </div>
                          <div class=\"row\">
                            <label class=\"col-lg-4\" for=\"image-url\">
                            <i class=\"far fa-image\"></i> Ảnh sản phẩm: 
                            </label>
                            <div class=\"col-lg-8\"><input class =\"img_url\" type=\"file\" id=\"image-url\" name=\"image-url[]\" onchange=\"upload_pic(this)\"  class=\"form-control is-valid\" id=\"validationSuccess\" required hidden></div>
                          </div>
                          <div class=\"row\">
                            <label class=\"col-lg-4\" for=\"image-url-1\">
                            <i class=\"far fa-image\"></i> Ảnh phụ thứ 1: 
                            </label>
                            <div class=\"col-lg-8\"><input type=\"file\" id=\"image-url-1\" name=\"image-url[]\" onchange=\"upload_pic(this)\" hidden></div>
                          </div>
                          <div class=\"row\">
                            <label class=\"col-lg-4\" for=\"image-url-2\">
                            <i class=\"far fa-image\"></i> Ảnh phụ thứ 2: 
                            </label>
                            <div class=\"col-lg-8\"><input type=\"file\" id=\"image-url-2\" name=\"image-url[]\" onchange=\"upload_pic(this)\" hidden></div>
                          </div>
                          <div class=\"row\">
                            <label class=\"col-lg-4\" for=\"image-url-3\">
                            <i class=\"far fa-image\"></i> Ảnh phụ thứ 3: 
                            </label>
                            <div class=\"col-lg-8\"><input type=\"file\" id=\"image-url-3\" name=\"image-url[]\" onchange=\"upload_pic(this)\" hidden></div>
                          </div>
                          <div class=\"row\">
                            <label class=\"col-lg-4\" for=\"image-url-4\">
                            <i class=\"far fa-image\"></i> Ảnh phụ thứ 4: 
                            </label>
                            <div class=\"col-lg-8\"><input type=\"file\" id=\"image-url-4\" name=\"image-url[]\" onchange=\"upload_pic(this)\" hidden></div>
                          </div>
                          <div class=\"row\">
                            <label class=\"col-lg-4\" for=\"description\">
                              Mô tả:
                            </label>
                            <div class=\"col-lg-8\"><textarea name=\"description\" placeholder=\"Nhập mô tả sản phẩm\" class=\"form-control is-valid\" id=\"validationSuccess\" required></textarea></div>
                          </div>
                          <div class=\"row\">
                            <label class=\"col-lg-4\" for=\"remain\">
                              Số lượng tồn kho:
                            </label>
                            <div class=\"col-lg-8\"><input type=\"number\" name=\"remain\" placeholder=\"Nhập số lượng sản phẩm\" class=\"form-control is-valid\" id=\"validationSuccess\" required></div>
                          </div>
                          <div class=\"row\">
                            <label class=\"col-lg-4\" for=\"category\" class=\"form-control is-valid\" id=\"validationSuccess\" required>
                              Loại:
                            </label>
                            <div class=\"col-lg-8\">
                              <label for=\"validationCustom04\" class=\"form-label\"></label>
                              <select name=\"category\" class=\"form-select\" id=\"validationCustom04\" required=\"\">
                                <option selected=\"\" disabled=\"\" value=\"\">Chọn loại</option>
                                <option value=\"Shirt\">Áo</option>
                                <option value=\"Trousers\">Quần</option>
                                <option value=\"Accessories\">Phụ kiện</option>
                              </select>
                              <div class=\"invalid-feedback\">
                                Vui lòng chọn loại.
                              </div>
                            </div>
                          </div>
                          <div class=\"btn-conf-add\">
                            <button type=\"submit\" onclick = \"Validate()\">Thêm</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>";
            }
          ?>
      </div>
      
      <!-- Main content -->
      <div class="container-fluid"><span hidden><?php echo $data["user"]; ?></span>
        <div class="list-product">
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
              <?php
                  if(empty($data["product"]["list"])) echo "empty product";
                  else{
                    $count = 0;
                    foreach($data["product"]["list"] as $row){
                      $id = $row['id'];
                      $img = $row['img'];
                      $name = $row['name'];
                      $price = number_format($row['price'],0,',','.');
                      echo <<<HTML
                      <div class="col">
                        <div class="card">
                          <a href="?url=Home/Item/{$id}/"><img src="{$img}"class="card-img-top" alt="card-grid-image" /></a>
                          <div class="card-body">
                            <h5 class="card-title">{$name}</h5>
                              <p class="card-text fw-bold fs-5">{$price} <sup>vnđ</sup></p>
                              <div class="d-flex justify-content-between">
                                <div style="text-align: left;" class="quantity-section">
                                  <div class="plus-qty-btn">
                                      <i class="fas fa-minus-circle" onclick="minus(this);"></i>
                                  </div>
                                  <input type="text" class="qty-buy" value="1" id="quantity-{$id}">
                                  <div class="minus-qty-btn">
                                      <i class="fas fa-plus-circle" onclick="plus(this);"></i>
                                  </div>
                                  <div style="text-align: right">
                                      <button type="button" class="btn btn-primary addToCart" onclick="add_Product(this);">
                                          <span hidden>{$id}</span>Thêm vào giỏ
                                      </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      HTML;
                    }
                  }
              ?>
          </div>
        </div>
        <?php if($data['product']['total_page'] > 1) : ?>
          <div class="my-3 d-flex align-items-center justify-content-center gap-2">
          <?php for ($i=1; $i <= $data['product']['total_page']; $i++) : ?>
            <a href="/?url=Home/Products&search=<?= $data['product']['active_search']?>&category=<?= $data['product']['active_category'] ?>&sort-by=<?= $data['product']['sort_1'] ?>&order-by=<?= $data['product']['sort_2'] ?>&page=<?= $i ?>" class="btn btn-outline-warning <?= $i == $data['product']['active_page'] ? 'active' : '' ?>">
              <?= $i ?>
            </a>
          <?php endfor ?>
          </div>
        <?php endif ?>
        
      </div>
      <div id="notice"></div>
      <!--div class="footer-holder"></div>
      <script src="../Views/footer/footerScript.js"></script-->
    <?php require_once("./Views/footer/index.php");?>
    </div>
    <script src="./Views/Navbar/navbarScript.js"></script>
    <script src="./Views/Products/product.js"></script>
  </body>
</html>

