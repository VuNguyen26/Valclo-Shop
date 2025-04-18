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

var click = document.getElementsByClassName("click");
click[0].onclick = function(){
    document.getElementsByClassName("click")[0].parentNode.parentNode.style.backgroundColor  = "#f6dcb8";
    document.getElementsByClassName("click")[0].parentNode.parentNode.style.borderLeft   = "3px solid #ffa62b";
    document.getElementsByClassName("click")[1].parentNode.parentNode.style.backgroundColor  = "white";
    document.getElementsByClassName("click")[1].parentNode.parentNode.style.borderLeft   = "none";
    document.getElementsByClassName("click")[2].style.display = "flex";
    document.getElementsByClassName("click")[3].style.display = "none";
};
click[1].onclick = function(){
    document.getElementsByClassName("click")[1].parentNode.parentNode.style.backgroundColor  = "#f6dcb8";
    document.getElementsByClassName("click")[1].parentNode.parentNode.style.borderLeft   = "3px solid #ffa62b";
    document.getElementsByClassName("click")[0].parentNode.parentNode.style.backgroundColor  = "white";
    document.getElementsByClassName("click")[0].parentNode.parentNode.style.borderLeft   = "none";
    document.getElementsByClassName("click")[3].style.display = "flex";
    document.getElementsByClassName("click")[2].style.display = "none";
};
for (var i = 0; i < click[3].getElementsByClassName("node").length; i++) {
    var node = click[3].getElementsByClassName("node")[i];
    var price = node.getElementsByClassName("price");
    var h5 = node.getElementsByTagName("h5");

    if (h5.length > 0) {
        var check = h5[0];
        if (check.innerText !== "Chưa thanh toán") {
            if ((Date.now() - new Date(check.innerText)) / 86400000 > 15) {
                check.innerText = "Đã giao";
            } else {
                check.innerText = "Đang giao";
            }
        }
    }

    for (let index = 0; index < price.length; index++) {
        let parts = price[index].innerText.split(" ");
        if (parts.length >= 3) {
            price[index].innerText = `${parts[0]} ${parts[0]} ${enformat(parts[2])}(đ)`;
        }
    }
}

var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];
var button = document.getElementsByClassName("btn btn-primary")[4];

span.onclick = function() {
  modal.style.display = "none";
};
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

function upload_pic(element){
    var fileSelected = element.files;
    if (fileSelected.length > 0) {
        var fileToLoad = fileSelected[0];
        var fileReader = new FileReader();
        fileReader.onload = function(fileLoaderEvent) {
            var srcData = fileLoaderEvent.target.result;
            var newImage = document.createElement('img');
            newImage.src = srcData;
            element.parentNode.children[0].innerHTML = newImage.outerHTML;
        }
        fileReader.readAsDataURL(fileToLoad);
    }
}
function add_notice(alert, string){
    return '<div class="alert ' + alert + '" role="alert"><strong>' + string + '</strong></div>';
}
function myFunction(index){
    var input = document.getElementsByClassName("col-12 border_bot mt-3 mb-3 ")[0].getElementsByTagName("input")[index];
    if (input.type === "password") {
        input.type = "text";
      } else {
        input.type = "password";
      }
}
function changePwd(){
    modal.style.display = "block";
}
var old
function changeProfile(element){
    if(element.innerText != "Xong"){
        document.getElementsByClassName("frame_profile")[0].style.display = "none";
        document.getElementsByClassName("frame_edit_profile")[0].style.display = "block";
    }
    else{
        var input = element.parentNode.parentNode.getElementsByTagName("input");
        var check = 0;
        for (let index = 0; index < input.length; index++) {
            if(input[index] == ""){
                document.getElementById("notice").innerHTML = add_notice("fail", "Hãy điền thông tin còn thiếu");
                document.getElementsByClassName("alert")[0].style.display = "block";
                setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
                return;
            }
            if(input[index].value != input[index].defaultValue) check = 1;
        }
        if(check == 1){
            document.getElementById("notice").innerHTML = add_notice("success", "Thông tin đã thay đổi");
            document.getElementsByClassName("alert")[0].style.display = "block";
            setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
            element.parentNode.parentNode.submit();
        }
        document.getElementsByClassName("frame_profile")[0].style.display = "block";
        document.getElementsByClassName("frame_edit_profile")[0].style.display = "none";
    }
}

function completechange(element){
    var input = element.parentNode.parentNode.getElementsByTagName("input");
    if(input[1].value != input[2].value){
        document.getElementById("notice").innerHTML = add_notice("fail", "Mật khẩu xác nhận không khớp");
        document.getElementsByClassName("alert")[0].style.display = "block";
        setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
        return;
    }
    if(input[0].value == input[1].value || input[0].value == input[2].value){
        document.getElementById("notice").innerHTML = add_notice("fail", "Mật khẩu trùng với mật khẩu cũ");
        document.getElementsByClassName("alert")[0].style.display = "block";
        setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
        return;
    }
    if(input[1].value == input[2].value && input[1].value == ""){
        modal.style.display = "none";
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
      if (this.readyState == 4 && this.status == 200) {
          if(this.responseText != "null"){
              modal.style.display = "none";
              input[0].value = input[1].value;
              input[1].value = "";
              input[2].value = "";
            document.getElementById("notice").innerHTML = add_notice("success", "Thay đổi mật khẩu thành công");
            document.getElementsByClassName("alert")[0].style.display = "block";
            setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
          }
          else{
            console.log(this.responseText);
            document.getElementById("notice").innerHTML = add_notice("fail", "Thay đổi mật khẩu thất bại");
            document.getElementsByClassName("alert")[0].style.display = "block";
            setTimeout(function(){document.getElementsByClassName("alert")[0].style.opacity = 0;}, 1500);
          }
      }
    };
    xmlhttp.open("GET", "?url=Home/update_password_profile/" + input[1].value + "/", true);
    xmlhttp.send();
}

var cart = document.getElementsByClassName("card");
for (let index = 0; index < cart.length; index++) {
    var check = cart[index].getElementsByTagName("h5")[3];
    if((Date.now() - new Date(check.innerText))/86400000 > 15) check.innerText = "Đã giao";
    else check.innerText = "Đang giao";
    cart[index].getElementsByTagName("h3")[0].innerText = enformat(cart[index].getElementsByTagName("h3")[0].innerText.split("/")[0]) + "(đ)/" + cart[index].getElementsByTagName("h3")[0].innerText.split("/")[1];
}
