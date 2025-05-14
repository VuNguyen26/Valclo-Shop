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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/721412f694.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <div class="company-product">
      <?php require_once("./Views/Navbar/index.php"); ?>
      <div class="container-fluid">
      <?php
if ($data["user"] == "customer" || $data["user"] == "member") {
  $select_pname = isset($_GET['sort-by']) && $_GET['sort-by'] === 'pname' ? 'selected' : '';
  $select_price = isset($_GET['sort-by']) && $_GET['sort-by'] === 'price' ? 'selected' : '';
  $select_asc = isset($_GET['order-by']) && $_GET['order-by'] === 'ASC' ? 'selected' : '';
  $select_desc = isset($_GET['order-by']) && $_GET['order-by'] === 'DESC' ? 'selected' : '';
  $page = $data['product']['active_page'];
  $choose_all = isset($_GET['category']) && $_GET['category'] == 'all' ? 'selected' : '';

  $render_option_category = '<option '. $choose_all .' value="all">Tất cả</option>';
  foreach ($data["cate"] as $row) {
    $name_category = $row["name_category"];
    $choose = isset($_GET['category']) && $_GET['category'] == $name_category ? 'selected' : '';
    $render_option_category .= "<option {$choose} value=\"{$name_category}\">{$name_category}</option>";
  }

  $selected_price = $_GET['price-range'] ?? '';

$price_option_1 = $selected_price == '0-100000' ? 'selected' : '';
$price_option_2 = $selected_price == '100000-200000' ? 'selected' : '';
$price_option_3 = $selected_price == '200000-300000' ? 'selected' : '';
$price_option_4 = $selected_price == '300000-400000' ? 'selected' : '';
$price_option_5 = $selected_price == '400000-500000' ? 'selected' : '';
$price_option_6 = $selected_price == '500000-1000000' ? 'selected' : '';
$price_option_7 = $selected_price == '1000000-' ? 'selected' : '';


  echo <<<HTML
<form id="filter-form" class="bg-light border border-1 rounded rounded-5 p-3 my-3" action="/" method="GET">
  <input type="hidden" name="url" value="Home/Products">
  <input type="hidden" name="search" value="">
  <input type="hidden" name="page" value="{$page}">
  
  <div class="row g-3">
    <!-- Hàng 1 -->
    <div class="col-12 col-md-6">
      <label for="category-select">Danh mục</label>
      <select class="form-select" name="category" id="category-select">
        {$render_option_category}
      </select>
    </div>
    <div class="col-12 col-md-6">
      <label for="price-range">Khoảng giá</label>
      <select class="form-select" name="price-range" id="price-range">
        <option value="">-- Chọn khoảng giá --</option>
        <option value="0-100000" {$price_option_1}>Dưới 100.000</option>
        <option value="100000-200000" {$price_option_2}>100.000 - 200.000</option>
        <option value="200000-300000" {$price_option_3}>200.000 - 300.000</option>
        <option value="300000-400000" {$price_option_4}>300.000 - 400.000</option>
        <option value="400000-500000" {$price_option_5}>400.000 - 500.000</option>
        <option value="500000-1000000" {$price_option_6}>500.000 - 1.000.000</option>
        <option value="1000000-" {$price_option_7}>Trên 1.000.000</option>
      </select>
    </div>

    <!-- Hàng 2 -->
    <div class="col-6 col-md-4">
      <label for="sort-by">Sắp xếp theo</label>
      <select class="form-select" name="sort-by" id="sort-by">
        <option {$select_pname} value="pname">Tên sản phẩm</option>
        <option {$select_price} value="price">Giá sản phẩm</option>
      </select>
    </div>
    <div class="col-6 col-md-4">
      <label for="order-by">Thứ tự</label>
      <select class="form-select" name="order-by" id="order-by">
        <option {$select_asc} value="ASC">Tăng dần</option>
        <option {$select_desc} value="DESC">Giảm dần</option>
      </select>
    </div>
    <div class="col-12 col-md-4 d-flex align-items-end">
      <button class="btn btn-warning w-100" type="submit"><i class="fa-sm fas fa-search me-2"></i>Lọc</button>
    </div>
  </div>
</form>

HTML;
}
?>

      </div>
      <div class="container-fluid"><span hidden><?php echo $data["user"]; ?></span>
        <div class="list-product">
          <div class="row">
              <?php
                  if(empty($data["product"]["list"])) echo "empty product";
                  else{
                    foreach($data["product"]["list"] as $row){
    $id = $row['id'];
    $img = $row['img'];
    $name = $row['name'];
    $price = number_format($row['price'],0,',','.');
    $number = isset($row['number']) ? (int)$row['number'] : 0;

    $status = $number <= 0 
        ? '<span class="badge bg-danger d-block text-center mb-2">Hết hàng</span>' 
        : '';

    $pointer = $number <= 0 ? 'none' : 'auto';
    $opacity = $number <= 0 ? '0.6' : '1';

    echo <<<HTML
    <div class="col-6 col-md-4 col-lg-3 mb-5">
      <div class="border border-1 rounded rounded-5 bg-light p-1 shadow">
        <a href="?url=Home/Item/{$id}/">
          <img src="{$img}" class="product-img d-block w-100" alt="card-grid-image" />
        </a>
        <div class="card-body px-3">
          <h5 class="card-title text-center">{$name}</h5>
          {$status}
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <span class="card-text fw-bold fs-5">{$price} <sup>vnđ</sup></span>
            <a href="?url=Home/Item/{$id}" class="btn btn-warning"
              style="pointer-events: {$pointer}; opacity: {$opacity};">
              Mua ngay <i class="fas fa-angle-right"></i>
            </a>
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
  <?php $active_price_range = $_GET['price-range'] ?? ''; ?>
  <div class="my-3 d-flex align-items-center justify-content-center gap-2">
    <?php for ($i = 1; $i <= $data['product']['total_page']; $i++) : ?>
      <a href="/?url=Home/Products&search=<?= $data['product']['active_search'] ?>&category=<?= $data['product']['active_category'] ?>&sort-by=<?= $data['product']['sort_1'] ?>&order-by=<?= $data['product']['sort_2'] ?>&price-range=<?= $active_price_range ?>&page=<?= $i ?>"
         class="btn btn-outline-warning <?= $i == $data['product']['active_page'] ? 'active' : '' ?>">
        <?= $i ?>
      </a>
    <?php endfor ?>
  </div>
<?php endif ?>

      </div>
      <div id="notice"></div>
    <?php require_once("./Views/footer/index.php");?>
    </div>
    <script src="./Views/Navbar/navbarScript.js"></script>
    <script src="./Views/Products/product.js"></script>
    <script>
      document.getElementById("category-select").addEventListener("change", function () {
        document.getElementById("filter-form").submit();
      });
      document.getElementById("price-range").addEventListener("change", function () {
        document.getElementById("filter-form").submit();
      });
    </script>
  </body>
</html>