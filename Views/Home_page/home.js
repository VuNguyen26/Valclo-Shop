const swiper1 = new Swiper(".slider-1", {
  autoplay: {
    delay: 3500,
    disableOnInteraction: false,
  },
  grabCursor: true,
  effect: "fade",
  loop: true,
  navigation: {
    nextEl: ".swiper-next",
    prevEl: ".swiper-prev",
  },
});

const swiper2 = new Swiper(".slider-2", {
  grabCursor: true,
  spaceBetween: 30,
  navigation: {
    nextEl: ".custom-next",
    prevEl: ".custom-prev",
  },
  breakpoints: {
    640: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 3,
    },
    1024: {
      slidesPerView: 4,
    },
  },
});

const swiper3 = new Swiper(".slider-3", {
  loop: true,
  grabCursor: true,
  autoplay: {
    delay: 3500,
    disableOnInteraction: false,
  },
  spaceBetween: 30,
  slidesPerView: 2,
  breakpoints: {
    768: {
      slidesPerView: 3,
    },
    1024: {
      slidesPerView: 5,
    },
  },
});

var user = document.getElementsByClassName("featured")[0].getElementsByTagName("span")[0].innerText;
document.getElementsByClassName("featured")[0].getElementsByTagName("span")[0].remove();

for (let index = 0; index < document.getElementsByClassName("addToCart").length; index++) {
document.getElementsByClassName("addToCart")[index].value = document.getElementsByClassName("addToCart")[index].getElementsByTagName("span")[0].innerText;
document.getElementsByClassName("addToCart")[index].getElementsByTagName("span")[0].remove();
}

const addToCartButtons = document.getElementsByClassName("addToCart");

for (let button of addToCartButtons) {
console.log(button.value);
}

function add_Product(element){
if(user == "customer"){
  window.location.href = "?url=Home/Login/"; 
}
else{
  var day_str = new Date();
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200){
      // Parse response JSON
      var response = JSON.parse(this.responseText);
      // Check if the response status is success
      if(response.status === "success"){
        alert(response.message); // Display success message
      } else {
        alert("Có lỗi xảy ra: " + response.message); // Display error message
      }
    }
  };

  // Send product_id and quantity via POST method
  xmlhttp.open("POST", "?url=Home/create_cart", true);
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send("product_id=" + element.value + "&quantity=1");  // Sending product_id and quantity correctly via POST
}
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

var encode_item_price = document.getElementsByClassName("feature-item-price");
for (var i = 0; i < encode_item_price.length; i++){
encode_item_price[i].innerText = enformat(String(Number(encode_item_price[i].innerText.split("đ")[0]))) + "đ";
}
