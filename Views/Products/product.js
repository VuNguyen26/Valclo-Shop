var forms = document.querySelectorAll('.needs-validation');
Array.prototype.slice.call(forms)
  .forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });

filterSelection("all");
function filterSelection(c) {
  let x = document.getElementsByClassName("filterDiv");
  if (c == "all") c = "";
  for (let i = 0; i < x.length; i++) {
    removeClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) addClass(x[i], "show");
  }
}

function addClass(element, name) {
  let arr1 = element.className.split(" ");
  let arr2 = name.split(" ");
  for (let i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {
      element.className += " " + arr2[i];
    }
  }
}

function removeClass(element, name) {
  let arr1 = element.className.split(" ");
  let arr2 = name.split(" ");
  for (let i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);
    }
  }
  element.className = arr1.join(" ");
}

let btnContainer = document.getElementById("myBtnContainer");
if (btnContainer) {
  let tabs = btnContainer.getElementsByClassName("tab-filter");
  for (let i = 0; i < tabs.length; i++) {
    tabs[i].addEventListener("click", function () {
      let current = btnContainer.getElementsByClassName("active-filter");
      if (current.length > 0) {
        current[0].className = current[0].className.replace(" active-filter", "");
      }
      this.className += " active-filter";
    });
  }
}

function minus(element) {
  var input = element.parentNode?.parentNode?.getElementsByTagName("input")[0];
  if (input) {
    input.value = Math.max(1, Number(input.value) - 1);
  }
}

function plus(element) {
  var input = element.parentNode?.parentNode?.getElementsByTagName("input")[0];
  if (input) {
    input.value = Number(input.value) + 1;
  }
}

var user = "guest";
var container = document.getElementsByClassName("container-fluid")[0];
if (container) {
  var span = container.getElementsByTagName("span")[0];
  if (span) {
    user = span.innerText;
    span.remove();
  }
}

let addToCartBtns = document.getElementsByClassName("addToCart");
for (let index = 0; index < addToCartBtns.length; index++) {
  let span = addToCartBtns[index].getElementsByTagName("span")[0];
  if (span) {
    addToCartBtns[index].value = span.innerText;
    span.remove();
  }
}

function add_Product(element) {
  var productId = element.querySelector('span')?.innerText;
  var quantityElement = element.parentNode?.previousElementSibling?.previousElementSibling;
  var quantity = quantityElement ? parseInt(quantityElement.value) : 0;

  if (user == "customer") {
    window.location.href = "?url=Home/Login/Products/";
    return;
  }

  if (!productId || isNaN(quantity) || quantity <= 0) {
    document.getElementById("notice").innerHTML = add_notice("fail", "Thông tin sản phẩm hoặc số lượng không hợp lệ");
    document.getElementsByClassName("alert")[0].style.display = "block";
    setTimeout(function () {
      document.getElementsByClassName("alert")[0].style.opacity = 0;
    }, 1500);
    return;
  }

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        var response = JSON.parse(this.responseText);
        var alertType = response.status === "success" ? "success" : "fail";
        document.getElementById("notice").innerHTML = add_notice(alertType, response.message);
        document.getElementsByClassName("alert")[0].style.display = "block";
        setTimeout(function () {
          document.getElementsByClassName("alert")[0].style.opacity = 0;
        }, 1500);
      } catch (e) {
        console.log("Lỗi xử lý phản hồi: ", e);
      }
    }
  };

  xmlhttp.open("POST", "?url=Home/create_cart", true);
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send("cart_date=" + encodeURIComponent(new Date().toISOString()) +
    "&product_id=" + encodeURIComponent(productId) +
    "&quantity=" + encodeURIComponent(quantity));
}

function add_notice(alert, string) {
  return '<div class="alert ' + alert + '" role="alert"><strong>' + string + '</strong></div>';
}

function upload_pic(element) {
  var fileSelected = element.files;
  if (fileSelected.length > 0) {
    var fileToLoad = fileSelected[0];
    var fileReader = new FileReader();
    fileReader.onload = function (fileLoaderEvent) {
      var srcData = fileLoaderEvent.target.result;
      var newImage = document.createElement('img');
      newImage.src = srcData;
      newImage.style = "width: 50%; margin-bottom: 1rem;";
      var target = element.parentNode?.parentNode?.children[1];
      if (target) target.appendChild(newImage);
    }
    fileReader.readAsDataURL(fileToLoad);
  }
}

function remove_item(pid, element) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.responseText == "OK") {
      var item = element.closest(".cart-item");
      if (item) item.remove();
      document.getElementById("notice").innerHTML = add_notice("success", "Xóa thành công");
    } else if (this.responseText == "Nope") {
      document.getElementById("notice").innerHTML = add_notice("fail", "Xóa thất bại");
    }
    document.getElementsByClassName("alert")[0].style.display = "block";
    setTimeout(function () {
      document.getElementsByClassName("alert")[0].style.opacity = 0;
    }, 1500);
  }
  xmlhttp.open("GET", "?url=Home/delete_item/" + pid + "/", true);
  xmlhttp.send();
}

function enformat(element) {
  let nodestr = "";
  for (var j = element.length; j > 3; j -= 3) {
    nodestr = "," + element[j - 3] + element[j - 2] + element[j - 1] + nodestr;
  }
  if (element.length % 3 == 0) {
    nodestr = element[0] + element[1] + element[2] + nodestr;
  } else if (element.length % 3 == 2) {
    nodestr = element[0] + element[1] + nodestr;
  } else nodestr = element[0] + nodestr;
  return nodestr;
}

function deformat(element) {
  return element.split(",").join("");
}

var encode_item_price = document.getElementsByClassName("each-item-price");
for (var i = 0; i < encode_item_price.length; i++) {
  var num = parseInt(encode_item_price[i].innerText.replace(/[^\d]/g, ''));
  encode_item_price[i].innerText = enformat(String(num)) + "đ";
}

var modal = document.getElementById("addItem-modal");
var btn = document.getElementById("add-itemBtn");
var span = document.getElementsByClassName("close-modal-add")[0];

if (btn) {
  btn.onclick = function () {
    if (modal) modal.style.display = "block";
  }
}
if (span && modal) {
  span.onclick = function () {
    modal.style.display = "none";
  }
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
}

function Validate() {
  var imgInput = document.getElementsByClassName("img_url")[0];
  if (imgInput && imgInput.value === "") {
    document.getElementById("notice").innerHTML = add_notice("fail", "Thiếu ảnh chính!");
    document.getElementsByClassName("alert")[0].style.display = "block";
    setTimeout(function () {
      document.getElementsByClassName("alert")[0].style.opacity = 0;
    }, 1500);
  }
}
