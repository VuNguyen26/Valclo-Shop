function enformat(element){
  let nodestr = "";
  for (var j = element.length; j > 3; j -= 3) {
    nodestr = "," + element[j-3] + element[j-2] + element[j-1] + nodestr;
  }
  if (element.length % 3 == 0){
    nodestr = element[0] + element[1] + element[2] + nodestr;
  } else if (element.length % 3 == 2){
    nodestr = element[0] + element[1] + nodestr;
  } else {
    nodestr = element[0] + nodestr;
  }
  return nodestr;
}

function deformat(element){
  var list = element.split(",");
  var string = ""
  for (var i = 0; i < list.length; i++) string += list[i];
  return string;
}

var node = document.getElementsByClassName("node");
var list_oid = [];
var string_check = "";

for (var i = 0; i < node.length; i++) {
  node[i].getElementsByClassName("price")[0].innerText = enformat(node[i].getElementsByClassName("price")[0].innerText.split("(")[0]) + "(đ)";
  if (string_check != node[i].getElementsByTagName("span")[0].innerText) { 
    list_oid[list_oid.length] = node[i].getElementsByTagName("span")[0].innerText;
    string_check = node[i].getElementsByTagName("span")[0].innerText;
  }
  node[i].getElementsByTagName("span")[0].remove();
}

document.getElementsByClassName("total")[0].getElementsByClassName("col-12")[3].getElementsByTagName("span")[0].innerText =
  enformat(String(Number(document.getElementsByClassName("total")[0].getElementsByClassName("col-12")[0].getElementsByTagName("span")[0].innerText) + 10000)) + "(đ)";
document.getElementsByClassName("total")[0].getElementsByClassName("col-12")[0].getElementsByTagName("span")[0].innerText =
  enformat(document.getElementsByClassName("total")[0].getElementsByClassName("col-12")[0].getElementsByTagName("span")[0].innerText) + "(đ)";

document.getElementsByClassName("btn btn-primary")[0].onclick = function(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function(){
    console.log(this.responseText);
    if (this.readyState == 4 && this.status == 200){
      if(this.responseText != "null"){
        document.getElementById("notice").innerHTML = add_notice("success", "Hủy đơn combo thành công" );
        document.getElementsByClassName("alert")[0].style.display = "block";
        setTimeout(function(){
          document.getElementsByClassName("alert")[0].style.opacity = 0;
        }, 1500);
        var text = this.responseText;
        setTimeout(function(){
          window.location.href = text;
        }, 800);
      } else {
        document.getElementById("notice").innerHTML = add_notice("fail", "Hủy đơn combo thất bại" );
        document.getElementsByClassName("alert")[0].style.display = "block";
        setTimeout(function(){
          document.getElementsByClassName("alert")[0].style.opacity = 0;
        }, 1500);
      }
    }
  };
  xmlhttp.open("GET", "?url=Home/delete_order_combo/", true);
  xmlhttp.send();
}

function add_notice(alert, string){
  return '<div class="alert ' + alert + '" role="alert"><strong>' + string + '</strong></div>';
}

console.log("list_oid", list_oid);
