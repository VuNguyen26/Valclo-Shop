var forms = document.querySelectorAll('.needs-validation')
Array.prototype.slice.call(forms)
  .forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })

filterSelection("all");
function filterSelection(c) {
  let x;
  x = document.getElementsByClassName("filterDiv");
  if (c == "all") c = "";
  for (let i = 0; i < x.length; i++) {
    removeClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) addClass(x[i], "show");
  }
}

function addClass(element, name) {
  let arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (let i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {
      element.className += " " + arr2[i];
    }
  }
}

function removeClass(element, name) {
  var arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (let i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);
    }
  }
  element.className = arr1.join(" ");
}

let btnContainer = document.getElementById("myBtnContainer");
let tabs = btnContainer.getElementsByClassName("tab-filter");
for (let i = 0; i < tabs.length; i++) {
  tabs[i].addEventListener("click", function() {
    let current = btnContainer.getElementsByClassName("active-filter");
    current[0].className = current[0].className.replace(" active-filter", "");
    this.className += " active-filter";
  });
}

function minus(element){
  var input = element.parentNode.parentNode.getElementsByTagName("input")[0]
  input.value = Number(input.value) - 1;
  if(input.value <= 1) input.value = 1;
}
function plus(element){
  var input = element.parentNode.parentNode.getElementsByTagName("input")[0]
  input.value = Number(input.value) + 1;
}

var user = document.getElementsByClassName("container-fluid")[0].getElementsByTagName("span")[0].innerText;
document.getElementsByClassName("container-fluid")[0].getElementsByTagName("span")[0].remove();

for (let index = 0; index < document.getElementsByClassName("addToCart").length; index++) {
  document.getElementsByClassName("addToCart")[index].value = document.getElementsByClassName("addToCart")[index].getElementsByTagName("span")[0].innerText;
  document.getElementsByClassName("addToCart")[index].getElementsByTagName("span")[0].remove();
}

function add_Product(element) {
  var productId = element.querySelector('span').innerText; 
  var quantityElement = element.parentNode.previousElementSibling.previousElementSibling;
  var quantity = quantityElement ? parseInt(quantityElement.value) : 0;
  if (user == "customer") {
      window.location.href = "?url=Home/Login/Products/";
      return;
  }

  if (!productId || isNaN(quantity) || quantity <= 0) {
      console.log("Thông tin sản phẩm không hợp lệ");
      document.getElementById("notice").innerHTML = add_notice("fail", "Thông tin sản phẩm hoặc số lượng không hợp lệ");
      document.getElementsByClassName("alert")[0].style.display = "block";
      setTimeout(function() {
          document.getElementsByClassName("alert")[0].style.opacity = 0;
      }, 1500);
      return;
  }

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          console.log("Response Text:", this.responseText);
          try {
              var response = JSON.parse(this.responseText);
              if (response.status === "success") {
                  document.getElementById("notice").innerHTML = add_notice("success", response.message);
              } else {
                  document.getElementById("notice").innerHTML = add_notice("fail" ,response.message);
              }
              document.getElementsByClassName("alert")[0].style.display = "block";
              setTimeout(function() {
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


function upload_pic(element){
  var fileSelected = element.files;
  if (fileSelected.length > 0) {
      var fileToLoad = fileSelected[0];
      var fileReader = new FileReader();
      fileReader.onload = function(fileLoaderEvent) {
          var srcData = fileLoaderEvent.target.result;
          var newImage = document.createElement('img');
          newImage.src = srcData;
          newImage.style = "width: 50%; margin-bottom: 1rem;";
          element.parentNode.parentNode.children[1].appendChild(newImage);
      }
      fileReader.readAsDataURL(fileToLoad);
  }
}

function add_notice(alert, string){
  return '<div class="alert ' + alert + '" role="alert"><strong>' + string + '</strong></div>';
}

function remove_item(pid, element){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function(){
    if(this.responseText == "OK"){
      element.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
      document.getElementById("notice").innerHTML = add_notice("success", "Xóa thành công");
      document.getElementsByClassName("alert")[0].style.display = "block";
      setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
    }
    else if(this.responseText == "Nope"){
      document.getElementById("notice").innerHTML = add_notice("fail", "Xóa thất bại");
      document.getElementsByClassName("alert")[0].style.display = "block";
      setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
    }
    
  }
  xmlhttp.open("GET", "?url=Home/delete_item/" + pid + "/", true);
  xmlhttp.send();
}

function enformat(element){
  let nodestr = "";
    for(var j = element.length; j > 3; j -= 3){
        nodestr = "," + element[j-3] + element[j-2] + element[j-1] + nodestr;
    }
    if (element .length % 3 == 0){
        nodestr = element[0] + element[1] + element[2] + nodestr;
    }
    else if(element.length % 3 == 2){
        nodestr = element[0] + element[1] + nodestr;
    }
    else nodestr = element[0] + nodestr;
    return nodestr;
}
function deformat(element){
  var list = element.split(",");
  var string = ""
  for(var i = 0; i < list.length; i++) string += list[i];
  return string;
}

var encode_item_price = document.getElementsByClassName("each-item-price");
for (var i = 0; i < encode_item_price.length; i++){
  encode_item_price[i].innerText = enformat(String(Number(encode_item_price[i].innerText.split("đ")[0]))) + "đ";
}

// modal add item
var modal = document.getElementById("addItem-modal");

var btn = document.getElementById("add-itemBtn");

var span = document.getElementsByClassName("close-modal-add")[0];

if(btn){
  btn.onclick = function() {
    modal.style.display = "block";
  }
}
if(modal){
  span.onclick = function() {
    modal.style.display = "none";
  }
}
if(span){
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
}


function Validate(){
  var img = document.getElementsByClassName("img_url")[0].value;
  if(img === ""){
    document.getElementById("notice").innerHTML = add_notice("fail", "Thiếu ảnh chính!");
    document.getElementsByClassName("alert")[0].style.display = "block";
    setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
  }
}

function add_notice(alert, string){
  return '<div class="alert ' + alert + '" role="alert"><strong>' + string + '</strong></div>';
}

