// Đảm bảo khai báo hàm trước khi sử dụng
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

    // Kiểm tra các trường input có bị bỏ trống không
    inputs.forEach((input, index) => {
      if (input.value.trim() === "") {
        invalids[index].style.display = "block";
        check = true;
      } else {
        invalids[index].style.display = "none";
      }
    });

    if (check) return;

    // Kiểm tra mật khẩu và xác thực mật khẩu có giống nhau không
    if (inputs[4].value !== inputs[5].value) {
      invalids[6].style.display = "block";
      return;
    } else {
      invalids[6].style.display = "none";
    }

    // Tạo URL cho yêu cầu AJAX
    const url =
      `?url=/Home/create_account/` +
      encodeURIComponent(inputs[0].value) + "/" +  // fname
      encodeURIComponent(inputs[1].value) + "/" +  // cmnd
      encodeURIComponent(inputs[2].value) + "/" +  // email
      encodeURIComponent(inputs[3].value) + "/" +  // username
      encodeURIComponent(inputs[4].value) + "/";   // password

    // Gửi yêu cầu AJAX
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState === 4) {
        console.log("Status:", this.status);
        console.log("Response:", this.responseText);

        const notice = document.getElementById("notice");
        
        // Kiểm tra kết nối với server
        if (this.status !== 200) {
          notice.innerHTML = add_notice("alert-danger", "Lỗi kết nối đến server!");
          return;
        }

        // Xử lý phản hồi từ server
        const response = JSON.parse(this.responseText);  // Phản hồi trả về từ server
        if (response.status === "error") {
          notice.innerHTML = add_notice("alert-danger", response.message);
        } else if (response.status === "success") {
          notice.innerHTML = add_notice("alert-success", response.message);
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
