
function minus(element){
    var a = Number(element.innerText) - 1;
    if(a <= 0) element.innerText = 1;
    else  element.innerText = a;
}
function plus(element){
    var a = Number(element.innerText) + 1;
    if(a <= 0) element.innerText = 1;
    else  element.innerText = a;
}
function display_total(element1, element2, element3){
    var num = Number(deformat(element3.innerText.split("(")[0]));
    element3.innerText = enformat(String(Number(deformat(element1.innerText.split("(")[0])) * Number(element2.innerText))) + "(đ)";
    list.getElementsByTagName("h5")[0].innerText = enformat(String(Number(deformat(list.getElementsByTagName("h5")[0].innerText.split("(")[0])) - num + Number(deformat(element3.innerText.split("(")[0])))) + "(đ)";
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
function minusnode(element){
    var row = element.parentNode.parentNode.parentNode;
    minus(row.getElementsByClassName("value_click")[0]);
    display_total(row.getElementsByClassName("price")[0], row.getElementsByClassName("value_click")[0], row.getElementsByClassName("total")[0]);
}
function plusnode(element){
  var row = element.parentNode.parentNode.parentNode;
  plus(row.getElementsByClassName("value_click")[0]);
  display_total(row.getElementsByClassName("price")[0], row.getElementsByClassName("value_click")[0], row.getElementsByClassName("total")[0]);
}

var node = document.getElementsByClassName("node");
var totalh5 = 0;
for(var i = 0; i < node.length ; i++){
  node[i].parentNode.value = node[i].getElementsByClassName("demo")[0].innerText;
  node[i].getElementsByClassName("demo")[0].remove();
  var price = node[i].getElementsByClassName("price")[0];
  var total = node[i].getElementsByClassName("total")[0]; 
  totalh5 += Number(total.innerText.split("(")[0]);
  price.innerText = enformat(price.innerText.split("(")[0]) + "(đ)";
  total.innerText = enformat(total.innerText.split("(")[0]) + "(đ)";
} 

document.getElementsByClassName("btn btn-primary")[3].onclick = function(){
  var input = document.getElementById("myModal").getElementsByTagName("input");
  
  for (let index = 0; index < input.length; index++) {
    if(input[index].value == ""){
      document.getElementById("notice").innerHTML = add_notice("fail", "Vui lòng cập nhật địa chỉ giao hàng" );
      document.getElementsByClassName("alert")[0].style.display = "block";
      setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
      return;
    }
  }
  var children = document.getElementsByClassName("node");
  if(children.length > 0 || document.getElementsByClassName("card").length > 0){
    var string = children.length;
      for(var i = 0; i < children.length; i++){
            string += "/" + children[i].parentNode.value + "/" + children[i].getElementsByClassName("value_click")[0].innerText + "/" + children[i].getElementsByClassName("col-6")[1].innerText;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = this.responseText;
        }
      };
      xmlhttp.open("GET", "?url=Home/update_product_in_cart/" + string + "/", true);
      xmlhttp.send();
  }
  else{
    document.getElementById("notice").innerHTML = add_notice("fail", "Bạn chưa có sản phẩm" );
    document.getElementsByClassName("alert")[0].style.display = "block";
    setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
  }
};

var list = document.getElementsByClassName("container-fuild")[0].children[0].children[1];
list.getElementsByTagName("h5")[0].innerText = enformat(String(Number(list.getElementsByTagName("h5")[0].innerText) + totalh5)) + "(đ)";

var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
var button = document.getElementsByClassName("btn btn-primary")[4];

btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
};
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
button.value = document.getElementById("user_id").value;


function add_notice(alert, string){
  return '<div class="alert ' + alert + '" role="alert"><strong>' + string + '</strong></div>';
}
button.onclick = function () {
  const input = button.parentNode.getElementsByTagName("input");
  for (let index = 0; index < input.length; index++) {
    if (input[index].value == "") {
      document.getElementById("notice").innerHTML = add_notice("fail", "Vui lòng cập nhật địa chỉ giao hàng");
      document.getElementsByClassName("alert")[0].style.display = "block";
      setTimeout(() => { document.getElementsByClassName("alert")[0].style.opacity = 0; }, 1500);
      return;
    }
  }

  const name = input[0].value;
  const phone = input[1].value;
  const city = input[2].value;
  const district = input[3].value;
  const ward = input[4].value;
  const detail = input[5].value;

  const fullAddress = encodeURIComponent(detail + ", " + ward + ", " + district + ", " + city);
  const url = `?url=Home/update_user/${button.value}/${encodeURIComponent(name)}/${encodeURIComponent(phone)}/${fullAddress}/`;

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "ok") {
        modal.style.display = "none";
        document.getElementById("notice").innerHTML = add_notice("success", "Xác nhận thành công");
      } else {
        document.getElementById("notice").innerHTML = add_notice("fail", "Xác nhận thất bại");
      }
      document.getElementsByClassName("alert")[0].style.display = "block";
      setTimeout(() => { document.getElementsByClassName("alert")[0].style.opacity = 0; }, 1500);
    }
  };
  xmlhttp.open("GET", url, true);
  xmlhttp.send();
};


function remove_product_incart(element){
  var id = element.parentNode.parentNode.value;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
      if(this.responseText == "ok"){
        document.getElementsByClassName("container-fuild")[0].children[0].children[1].getElementsByTagName("h5")[0].innerText = enformat(String(Number(deformat(list.getElementsByTagName("h5")[0].innerText.split("(")[0])) - Number(deformat(element.parentNode.getElementsByClassName("total")[0].innerText.split("(")[0])))) + "(đ)";
        var h3 = document.getElementsByClassName("container-fuild")[0].children[0].children[1].getElementsByTagName("h3")[0];
        h3.innerText = h3.innerText.split("(")[0] + "(" + String(Number(h3.innerText.split("(")[1].split(" ")[0]) - 1) + " " +  h3.innerText.split("(")[1].split(" ")[1] + " " + h3.innerText.split("(")[1].split(" ")[2];
        element.parentNode.parentNode.remove();
        document.getElementById("notice").innerHTML = add_notice("success", "Xóa sản phẩm thành công" );
        document.getElementsByClassName("alert")[0].style.display = "block";
        setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
      }
      else if(this.responseText == "null"){
        document.getElementById("notice").innerHTML = add_notice("fail", "Xóa sản phẩm thất bại" );
        document.getElementsByClassName("alert")[0].style.display = "block";
        setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
      }
    }
  };
  xmlhttp.open("GET", "?url=Home/delete_product_incart/" + id + "/", true);
  xmlhttp.send();
}

function add_Product(element) {
  var productId = element.value;
  var quantityElement = element.parentNode.parentNode.getElementsByClassName("value_click")[0];
  var quantity = quantityElement ? parseInt(quantityElement.innerText) : 0;
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
      try {
        var response = JSON.parse(this.responseText);
        if (response.status === "success") {
          document.getElementById("notice").innerHTML = add_notice("success", "Thêm sản phẩm vào giỏ hàng thành công");
        } else {
          document.getElementById("notice").innerHTML = add_notice("fail", "Thêm sản phẩm vào giỏ hàng thất bại");
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

