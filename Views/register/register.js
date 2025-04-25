function add_notice(alert, string) {
  const notice = document.createElement('div');
  notice.className = `alert ${alert} mt-2`;
  notice.setAttribute("role", "alert");
  notice.innerText = string;
  return notice.outerHTML;
}

document.addEventListener("DOMContentLoaded", function () {
  const button = document.querySelector(".mybtn");
  if (!button) return;

  button.addEventListener("click", function (event) {
    event.preventDefault();

    const form = document.querySelector(".my-login-validation");
    const inputs = form.querySelectorAll("input");
    const invalids = form.querySelectorAll(".invalid-feedback");
    let check = false;

    inputs.forEach((input, index) => {
      if (input.value.trim() === "") {
        invalids[index].style.display = "block";
        check = true;
      } else {
        invalids[index].style.display = "none";
      }
    });

    if (check) return;

    if (!/^\d{6}$/.test(inputs[4].value)) {
      invalids[6].style.display = "block";
      invalids[6].innerText = "Mật khẩu phải gồm 6 chữ số.";
      return;
    } else {
      invalids[6].style.display = "none";
    }

    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailRegex.test(inputs[2].value)) {
      invalids[5].style.display = "block";
      invalids[5].innerText = "Email không hợp lệ!";
      return;
    } else {
      invalids[5].style.display = "none";
    }

    if (!/^\d{12}$/.test(inputs[1].value)) {
      invalids[1].style.display = "block";
      invalids[1].innerText = "CCCD phải gồm 12 chữ số.";
      return;
    } else {
      invalids[1].style.display = "none";
    }

    if (inputs[4].value !== inputs[5].value) {
      invalids[6].style.display = "block";
      return;
    } else {
      invalids[6].style.display = "none";
    }

    const url =
      `?url=/Home/create_account/` +
      encodeURIComponent(inputs[0].value) + "/" +  
      encodeURIComponent(inputs[1].value) + "/" +  
      encodeURIComponent(inputs[2].value) + "/" +  
      encodeURIComponent(inputs[3].value) + "/" +  
      encodeURIComponent(inputs[4].value) + "/";

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState === 4) {
        const notice = document.getElementById("notice");
    
        if (this.status !== 200) {
          alert("Lỗi kết nối đến server!");
          return;
        }
    
        const response = JSON.parse(this.responseText);
        console.log("Response message:", response.message);
    
        if (response.status === "error") {
          alert(response.message);
        } else if (response.status === "success") {
          alert(response.message);
          setTimeout(() => {
            window.location.href = "?url=/Home/Login/";
          }, 2000);
        } else {
          alert("Phản hồi không xác định từ server!");
        }
      }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
  });
});
