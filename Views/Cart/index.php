<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$city = $district = $ward = $detail = '';
$address_confirmed = false;

if (isset($_SESSION["id"])) {
    $conn = new mysqli("localhost", "root", "", "web_db");
    if (!$conn->connect_error) {
        $uid = $_SESSION["id"];
        $result = $conn->query("SELECT ADDRESS FROM account WHERE ID = $uid");
        if ($result && $row = $result->fetch_assoc()) {
            if (!empty($row["ADDRESS"])) {
                $_SESSION["address_confirmed"] = true;
                $_SESSION["address_from_db"] = $row["ADDRESS"];
                $address_confirmed = true;

                $parts = explode(', ', $row["ADDRESS"]);
                if (count($parts) >= 4) {
                    $detail = $parts[0];
                    $ward = $parts[1];
                    $district = $parts[2];
                    $city = $parts[3];
                }
            }
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Cart page">
    <meta name="author" content="Phạm Khánh Huy">

    <title>Valcloshop - Giỏ Hàng</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="./Views/images/avatar.png"
    />
    <script src="https://kit.fontawesome.com/320d0ac08e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="./Views/Cart/style.css" rel="stylesheet">
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

    <?php require_once("./Views/Navbar/index.php"); ?>
    <script src="./Views/Navbar/navbarScript.js" type="text/javascript"></script>

    <div class="container-fuild">
        <div class="row nonemg d-flex">
            <div class="col-12">
                <div class="row nonemg d-flex flex-wrap justify-content-center">
                    <div class="col-12 col-xxl-11 d-flex flex-wrap justify-content-center">
                        <h2>Giỏ hàng</h2>
                    </div>
                    <?php
                            $count = 0;
                            $total = 0;
                    
                            echo "<div class=\"col-12 col-xxl-11\">
                            <div class=\"row nonemg d-flex flex-wrap\">";                  
                    if(!empty($data["product_in_cart"])){
                            foreach($data["product_in_cart"] as $row){
                                $count += 1;
                                echo    "<div class=\"col-12 col-md-6 col-xl-4 col-xxl-4\">
                                            <div class=\"row node nonemg\">
                                                <div class=\"col-4 d-flex flex-wrap align-content-center justify-content-center\">
                                                    <img src=\"" . $row["img"] . "\" alt=\"item\">
                                                </div>
                                                <div class=\"demo\" hindden>" . $row["id"] . "</div>
                                                <div class=\"col-7\">
                                                    <div class=\"row\">
                                                        <div class=\"col-12\">
                                                            <h5>" . $row["name"] . "</h5>
                                                        </div>
                
                                                        <div class=\"col-12\">
                                                            <div class=\"row\">
                                                                <div class=\"col-6\">Size: </div>
                                                                <div class=\"col-6\">
                                                                  <div class=\"col-6\">" . htmlspecialchars($row["size"]) . "</div>
                                                                </div>
                                                            </div>
                                                        </div>           
                                                        <div class=\"col-12\">
                                                            <div class=\"row\">
                                                                <div class=\"col-6\">Giá: </div>
                                                                <div class=\"col-6 price\">" . $row["price"] . "(đ)</div>
                                                            </div>
                                                        </div>
                
                                                        <div class=\"col-12\">
                                                            <div class=\"row d-flex flex-wrap align-content-center justify-content-center\">
                                                                <div class=\"col-2 d-flex flex-wrap align-content-center justify-content-center click\" onclick=\"minusnode(this);\"><i class=\"fas fa-minus\"></i></div>
                                                                <div class=\"col-2 d-flex flex-wrap align-content-center justify-content-center\"><div class=\"value_click\">" . $row["num"] ."</div></div>
                                                                <div class=\"col-2 d-flex flex-wrap align-content-center justify-content-center click\" onclick=\"plusnode(this);\"><i class=\"fas fa-plus\"></i></div>
                                                            </div>
                                                        </div>
                
                                                        <div class=\"col-12\">
                                                            <div class=\"row\">
                                                                <div class=\"col-6\">Tổng cộng: </div>
                                                                <div class=\"col-6 total\">" . (int)$row["price"] * (int)$row["num"] . "(đ)</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                       
                                                <div class=\"col-1\" onclick=\"remove_product_incart(this)\">
                                                    <i class=\"fas fa-times\"></i>    
                                                </div>
                        
                                            </div>
                                        </div>";                                           
                            }
                        echo "
                        </div>
                    </div>
                </div>
            </div>
            <div class=\"col-12\">
                <div class=\"row nonemg d-flex flex-row-reverse\">
                    <div class=\"col-12 col-sm-8 col-md-6 col-lg-5 col-xxl-4\">
                        <h3>Tổng thanh toán (".  $count ." sản phẩm)</h3>
                        <h5>" . $total . "</h5>
                        <div class=\"d-flex flex-wrap justify-content-center\">
                            <button id=\"myBtn\" type=\"button\" class=\"btn btn-primary\">Địa chỉ giao hàng</button>
                            <button type=\"button\" class=\"btn btn-primary\">Mua hàng</button>
                        </div>
                    </div>
                </div>
            </div>
            ";
            }
            else{
                echo "<h1>Không có sản phẩm</h1>";
            }
            ?>
        </div>
    </div>
    
    <?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2>Thông tin cá nhân</h2>
      <span class="close">&times;</span>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-4">Họ và tên:</div>
            <div class="col-8">
              <input type="text" name="name" value="<?php echo $data['user']['name']; ?>">
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-4">Số điện thoại:</div>
            <div class="col-8">
              <input type="text" name="numberphone" value="<?php echo $data['user']['phone']; ?>">
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-4">Tỉnh/Thành phố:</div>
            <div class="col-8"><select id="province" class="form-control"></select></div>
          </div>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-4">Quận/Huyện:</div>
            <div class="col-8"><select id="district" class="form-control"></select></div>
          </div>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-4">Phường/Xã:</div>
            <div class="col-8"><select id="ward" class="form-control"></select></div>
          </div>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-4">Địa chỉ chi tiết:</div>
            <div class="col-8">
              <input type="text" id="detail_address" class="form-control" placeholder="Số nhà, tên đường...">
            </div>
          </div>
        </div>
        <input type="hidden" id="user_id" value="
        <?php
             if (session_status() === PHP_SESSION_NONE) session_start();
             echo isset($_SESSION['id']) ? $_SESSION['id'] : '';
        ?>">

        <button id="confirmAddressBtn" type="button" class="btn btn-primary">Hoàn tất</button>
      </div>
    </div>
  </div>
</div>

<?php require_once("./Views/footer/index.php"); ?>
<script src="./Views/Cart/cart.js" type="text/javascript"></script>

<script>
window.onload = function () {
  const savedCity = "<?php echo isset($city) ? addslashes($city) : ''; ?>";
  const savedDistrict = "<?php echo isset($district) ? addslashes($district) : ''; ?>";
  const savedWard = "<?php echo isset($ward) ? addslashes($ward) : ''; ?>";
  const savedDetail = "<?php echo isset($detail) ? addslashes($detail) : ''; ?>";

  document.getElementById("detail_address").value = savedDetail;
  fetch("https://provinces.open-api.vn/api/?depth=3")
    .then(res => res.json())
    .then(data => {
      const provinceSelect = document.getElementById("province");
      const districtSelect = document.getElementById("district");
      const wardSelect = document.getElementById("ward");

      data.forEach(province => {
        const opt = new Option(province.name, province.code);
        if (province.name === savedCity) opt.selected = true;
        provinceSelect.appendChild(opt);
      });

      const selectedProvince = data.find(p => p.name === savedCity);
      if (selectedProvince) {
        selectedProvince.districts.forEach(district => {
          const opt = new Option(district.name, district.code);
          if (district.name === savedDistrict) opt.selected = true;
          districtSelect.appendChild(opt);
        });

        const selectedDistrict = selectedProvince.districts.find(d => d.name === savedDistrict);
        if (selectedDistrict) {
          selectedDistrict.wards.forEach(ward => {
            const opt = new Option(ward.name, ward.name);
            if (ward.name === savedWard) opt.selected = true;
            wardSelect.appendChild(opt);
          });
        }
      }

      provinceSelect.addEventListener("change", function () {
        const province = data.find(p => p.code == this.value);
        districtSelect.innerHTML = '<option value="">-- Chọn Huyện --</option>';
        wardSelect.innerHTML = '<option value="">-- Chọn Xã --</option>';
        province.districts.forEach(district => {
          const opt = new Option(district.name, district.code);
          districtSelect.appendChild(opt);
        });

        districtSelect.addEventListener("change", function () {
          const district = province.districts.find(d => d.code == this.value);
          wardSelect.innerHTML = '<option value="">-- Chọn Xã --</option>';
          district.wards.forEach(ward => {
            const opt = new Option(ward.name, ward.name);
            wardSelect.appendChild(opt);
          });
        });
      });
    });

  document.getElementById("confirmAddressBtn").onclick = function () {
  const id = document.getElementById("user_id")?.value?.trim();
  const name = document.querySelector('input[name="name"]').value.trim();
  const phone = document.querySelector('input[name="numberphone"]').value.trim();
  const detail = document.getElementById("detail_address").value.trim();
  const province = document.getElementById("province");
  const district = document.getElementById("district");
  const ward = document.getElementById("ward");

  const phoneRegex = /^0[0-9]{9}$/;
  if (!phoneRegex.test(phone)) {
    alert("❌ Số điện thoại không hợp lệ. Vui lòng nhập 10 chữ số và bắt đầu bằng số 0.");
    return;
  }

  if (!id || !name || !phone || !detail || !province.value || !district.value || !ward.value) {
    alert("❌ Vui lòng điền đầy đủ thông tin");
    return;
  }

  const fullAddress = `${detail}, ${ward.options[ward.selectedIndex].text}, ${district.options[district.selectedIndex].text}, ${province.options[province.selectedIndex].text}`;

  const data = {
    id,
    name,
    phone,
    address: fullAddress
  };

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "?url=Home/update_user", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      if (xhr.responseText === "ok") {
        alert("✅ Địa chỉ đã được cập nhật thành công!");
        document.getElementById("myModal").style.display = "none";
        location.reload();
      } else {
        alert("❌ Cập nhật thất bại.");
      }
    }
  };
  xhr.send(JSON.stringify(data));
};

};
</script>

</body>
</html>

