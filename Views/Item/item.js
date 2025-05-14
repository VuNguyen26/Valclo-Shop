filterComment("all");
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

let btnContainer = document.getElementById("filter-rating-btn");
let tabs = btnContainer.getElementsByClassName("button-filter");
for (let i of tabs) {
  i.addEventListener("click", function() {
    let current = btnContainer.getElementsByClassName("current-btn");
    current[0].className = current[0].className.replace(" current-btn", "");
    this.className += " current-btn";
  });
}

$(document).ready(function(){
  $('.addition-img img').click(function(e) {
    e.preventDefault();
    $('.main-img img').attr("src", $(this).attr("src"));
  })
});



function filterComment(c) {
  let x;
  x = document.getElementsByClassName("filterCmt");
  if (c == "all") c = "";
  for (let i = 0; i < x.length; i++) {
    removeClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) addClass(x[i], "show");
  }
  if (!document.getElementById("if-no-cmt")) {
  let check = false;
  for(let i = 0; i < x.length; i++){
    if (x[i].classList.contains("show")) {
      check = true;
    }
  }
  if (!check) {
    document.getElementsByClassName("no-filter-cmt")[0].innerHTML = "<div class=\"card\"><div class=\"card-body\">No comment</div></div>";
  } else {
    document.getElementsByClassName("no-filter-cmt")[0].innerHTML = '';
  }}
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
if (!document.getElementById("edit-itemBtn") && document.getElementsByClassName("add-comment")[0]){
  document.getElementsByClassName("add-comment")[0].getElementsByTagName("button")[0].onclick = function(){
    var text = document.getElementsByClassName("add-comment")[0].getElementsByTagName("textarea");
    var selection = document.getElementsByClassName("add-comment")[0].getElementsByTagName("select");
    var pid = document.getElementsByClassName("get-item-id")[0].innerHTML;
    document.getElementsByClassName("get-item-id")[0].remove();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
      window.location.reload();
      document.getElementsByClassName("add-comment")[0].getElementsByTagName("form")[0].reset();
    };
    xmlhttp.open("POST", "?url=Home/add_item_comment/" + text[0].value + "/" + selection[0].value + "/" + pid, true);
    xmlhttp.send();
  }
}

function upload_pic(element){
  var fileSelected = element.files;
  if (fileSelected.length > 0) {
      var fileToLoad = fileSelected[0];
      var fileReader = new FileReader();
      fileReader.onload = function(fileLoaderEvent) {
          var srcData = fileLoaderEvent.target.result;
          element.parentNode.children[0].src = srcData;
      }
      fileReader.readAsDataURL(fileToLoad);
  }
}

function add_notice(string){
  if(string == "OK") return '<div class="alert success" role="alert"><strong>Xóa thành công!</strong></div>';
  return '<div class="alert fail" role="alert"><strong>Xóa thất bại!</strong></div>';
}

function add_notice1(string){
  if(string == "OK") return '<div class="alert success" role="alert"><strong>Thêm thành công!</strong></div>';
  return '<div class="alert fail" role="alert"><strong>Thêm thất bại!</strong></div>';
}

function delete_comment(cid, element){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function(){
    if(this.responseText == "OK"){
      document.getElementById("notice").innerHTML = add_notice(this.responseText);
      document.getElementsByClassName("alert")[0].style.display = "block";
      setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
      setTimeout(function(){window.location.reload()}, 600);

    } else if(this.responseText == "Nope"){
      document.getElementById("notice").innerHTML = add_notice(this.responseText);
      document.getElementsByClassName("alert")[0].style.display = "block";
      setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
    }
  }
  xmlhttp.open("GET", "?url=Home/delete_comment/" + cid + "/", true);
  xmlhttp.send();
}

function sort_comment(pid){
  var sort_value = document.getElementById("sort-with").value;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function(){
    document.getElementsByClassName("comment-script")[0].innerHTML = this.responseText;
    filterComment("all");
  }
  xmlhttp.open("GET", "?url=Home/sort_comment/" + pid + "/" + sort_value + "/", true);
  xmlhttp.send();
}

var user = document.getElementsByClassName("container-fluid")[0].getElementsByTagName("span")[0].innerText;
document.getElementsByClassName("container-fluid")[0].getElementsByTagName("span")[0].remove();


function add_Product(element) {
  if (user == "customer") {
    window.location.href = "?url=Home/Login/";
  } else {
    var pid = element.value;
    var quantityInput = element.parentNode.parentNode.getElementsByTagName("input")[0];
    var quantity = Number(quantityInput.value);

    if (quantity > maxQty) {
      alert("Bạn chỉ có thể mua tối đa " + maxQty + " sản phẩm.");
      return; // Dừng không gửi request
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        var response = JSON.parse(this.responseText);

        var alertBox = document.createElement("div");
        alertBox.classList.add("alert");
        if (response.status === "success") {
          alertBox.classList.add("alert-success");
          alertBox.innerText = response.message;
        } else {
          alertBox.classList.add("alert-danger");
          alertBox.innerText = "Có lỗi xảy ra: " + response.message;
        }

        document.body.appendChild(alertBox);
        alertBox.style.display = 'block';
        setTimeout(function () {
          alertBox.remove();
        }, 3000);
      }
    };

    xmlhttp.open("POST", "?url=Home/create_cart", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("product_id=" + pid + "&quantity=" + quantity);
  }
}


if(document.getElementById("edit-itemBtn")){
  var ival = document.getElementById("get_name_val").innerText;
  document.getElementsByClassName("editItem-modal-body")[0].getElementsByTagName("input")[0].value = ival;
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

document.getElementsByClassName("item-price")[0].innerText = enformat(String(Number(document.getElementsByClassName("item-price")[0].innerText.split("đ")[0]))) + "đ";
var encode_related_item = document.getElementsByClassName("related-item-price");
for (var i = 0; i < encode_related_item.length; i++){
  encode_related_item[i].innerText = enformat(String(Number(encode_related_item[i].innerText.split("đ")[0]))) + "đ";
}

var modal = document.getElementById("editItem-modal");
var btn = document.getElementById("edit-itemBtn");
var span = document.getElementsByClassName("close-modal-edit")[0];
if(btn){
  btn.onclick = function() {
    modal.style.display = "block";
  }
}

if(span){
  span.onclick = function() {
    modal.style.display = "none";
  }
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
function add_Product(btn) {
  const id = btn.value;
  const size = document.getElementById("size-select").value;
  const qty = document.querySelector(".qty-buy").value;
  const formData = new URLSearchParams();
  formData.append("product_id", id);
  formData.append("quantity", qty);
  formData.append("size", size);

  fetch("?url=Home/create_cart", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
    });
}

