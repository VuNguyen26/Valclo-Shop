<link rel="stylesheet" href="./Views/Navbar/navbar.css?v=<?= filemtime('./Views/Navbar/navbar.css') ?>">
<div id="navbar" class="sticky-top">
  <nav>
    <h1><i class="fab fa-shopify"></i><a href="?url=Home/Home_page/">VCS</a></h1>

    <div class="burger">  
      <div class="line1"></div>
      <div class="line2"></div>
      <div class="line3"></div>
    </div>

    <ul class="nav-links">
      <li><a href="?url=Home/Home_page/">Trang chủ</a></li>
      <li><a href="?url=Home/About_us/">Về chúng tôi</a></li>
      <li><a href="?url=Home/Products/">Sản phẩm</a></li>
      <li><a href="?url=Home/News/">Tin tức</a></li>
      <li><a href="?url=Home/Contact_us/">Liên hệ</a></li>
    </ul>

    <form class="form" onsubmit="return false;">
  <div class="form-group">
    <input id="search-box" class="form-control" type="text" placeholder="Search...">
  </div>
  <button class="btn btn-dark" type="button" onclick="search_item(this)">
    <i class="fas fa-search"></i>
  </button>
</form>

    <div class="cart">
      <button id="cart-button-nav" class="btn btn-primary" type="button"><a href="<?php if(!isset($_SESSION["user"]) || isset($_SESSION["user"]) && $_SESSION["user"] != "manager") echo "?url=Home/Cart/"; else echo "#";?>"><i class="fas fa-shopping-cart"></i> Giỏ</a></button>
    </div>

    <div class="login-button">
  <?php
  if (!isset($_SESSION["user"]) || $_SESSION["user"] == "customer") {
    echo "<button class=\"btn btn-primary\" type=\"button\">
            <a href=\"?url=Home/Login/\"><i class=\"fas fa-sign-in-alt\"></i> Login</a>
          </button>";
  } else if (isset($_SESSION["user"]) && $_SESSION["user"] == "member") {
    echo "<div class=\"dropdown\" data-bs-auto-close=\"outside\">
            <button type=\"button\" class=\"btn btn-primary\" id=\"userBtn\">
              <i class=\"fas fa-user\"></i>
            </button>
            <ul class=\"dropdown-menu\" id=\"userDropdown\">
              <li><a class=\"dropdown-item\" href=\"?url=/Home/member_page/\">Hồ sơ cá nhân</a></li>
              <li><a class=\"dropdown-item\" href=\"?url=/Home/logout/\">Thoát <i class=\"fas fa-sign-out-alt\"></i></a></li>
            </ul>
          </div>";
  }
  ?>
</div>

  </nav>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const dropdownButton = document.getElementById("userBtn");
    const dropdownMenu = document.getElementById("userDropdown");
    if (dropdownButton && dropdownMenu) {
      dropdownButton.addEventListener("click", function (e) {
        e.stopPropagation();
        dropdownMenu.classList.toggle("show");
      });
      document.addEventListener("click", function (e) {
        if (!dropdownMenu.contains(e.target) && !dropdownButton.contains(e.target)) {
          dropdownMenu.classList.remove("show");
        }
      });
    }
  });
</script>


