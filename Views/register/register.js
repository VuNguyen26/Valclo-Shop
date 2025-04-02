function add_notice(alert, string) {
    return '<div class="alert ' + alert + ' mt-2" role="alert"><strong>' + string + '</strong></div>';
  }
  
  document.addEventListener("DOMContentLoaded", function () {
    const button = document.querySelector(".mybtn");
    if (!button) return;
  
    button.addEventListener("click", function () {
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
  
      if (inputs[4].value !== inputs[5].value) {
        invalids[6].style.display = "block";
        return;
      } else {
        invalids[6].style.display = "none";
      }
  
      const url =
        `?url=Home/create_account/` +
        encodeURIComponent(inputs[0].value) + "/" +
        encodeURIComponent(inputs[1].value) + "/" +
        encodeURIComponent(inputs[2].value) + "/" +
        encodeURIComponent(inputs[3].value) + "/" +
        encodeURIComponent(inputs[4].value) + "/";
  
      const xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4) {
          console.log("Status:", this.status);
          console.log("Response:", this.responseText);
  
          const notice = document.getElementById("notice");
          if (this.status !== 200) {
            notice.innerHTML = add_notice("alert-danger", "Lỗi kết nối đến server!");
            return;
          }
  
          if (this.responseText === "null1") {
            notice.innerHTML = add_notice("alert-danger", "Bạn là thành viên bị cấm");
          } else if (this.responseText === "null2") {
            notice.innerHTML = add_notice("alert-danger", "Tài khoản của bạn đã tồn tại");
          } else if (this.responseText === "null3") {
            notice.innerHTML = add_notice("alert-danger", "Tạo tài khoản thất bại");
          } else if (this.responseText === "ok") {
            notice.innerHTML = add_notice("alert-success", "Tạo tài khoản thành công");
            setTimeout(() => {
              window.location.href = "?url=/Home/Login/";
            }, 2000);
          } else {
            notice.innerHTML = add_notice("alert-danger", "Phản hồi không xác định từ server!");
          }
        }
      };
  
      xmlhttp.open("GET", url, true);
      xmlhttp.send();
    });
  });
  