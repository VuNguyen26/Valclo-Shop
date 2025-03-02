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
  var node = document.getElementsByClassName("card");
  node[0].getElementsByTagName("h3")[0].innerText = enformat(node[0].getElementsByTagName("h3")[0].innerText.split("/")[0]) + "(đ)/" + node[0].getElementsByTagName("h3")[0].innerText.split("/")[1];
  document.getElementsByClassName("total")[0].getElementsByClassName("col-12")[3].getElementsByTagName("span")[0].innerText = enformat(String(Number(document.getElementsByClassName("total")[0].getElementsByClassName("col-12")[0].getElementsByTagName("span")[0].innerText)+ 10000)) + "(đ)";
  document.getElementsByClassName("total")[0].getElementsByClassName("col-12")[0].getElementsByTagName("span")[0].innerText = enformat(document.getElementsByClassName("total")[0].getElementsByClassName("col-12")[0].getElementsByTagName("span")[0].innerText) + "(đ)";
  
  // ----------------------------------------------------------
