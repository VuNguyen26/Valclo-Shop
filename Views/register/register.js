// Đảm bảo khai báo hàm trước khi sử dụng
function add_notice(alert, string) {
  const notice = document.createElement('div');
  notice.className = `alert ${alert} mt-2`;
  notice.setAttribute("role", "alert");
  notice.innerText = string; // tự động decode Unicode
  return notice.outerHTML;
}

document.addEventListener("DOMContentLoaded", function () {
  const button = document.querySelector(".mybtn");
  if (!button) return;

  button.addEventListener("click", function (event) {
    event.preventDefault(); // Ngăn form submit mặc định

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

    // Kiểm tra mật khẩu phải là 6 chữ số
    if (!/^\d{6}$/.test(inputs[4].value)) {
      invalids[6].style.display = "block";
      invalids[6].innerText = "Mật khẩu phải gồm 6 chữ số.";
      return;
    } else {
      invalids[6].style.display = "none";
    }

    // Kiểm tra email đúng định dạng .com
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailRegex.test(inputs[2].value)) {
      invalids[5].style.display = "block";
      invalids[5].innerText = "Email không hợp lệ!";
      return;
    } else {
      invalids[5].style.display = "none";
    }

    // Kiểm tra số CCCD phải gồm 12 chữ số
    if (!/^\d{12}$/.test(inputs[1].value)) {
      invalids[1].style.display = "block";
      invalids[1].innerText = "CCCD phải gồm 12 chữ số.";
      return;
    } else {
      invalids[1].style.display = "none";
    }

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
        const notice = document.getElementById("notice");
    
        // Kiểm tra kết nối với server
        if (this.status !== 200) {
          alert("Lỗi kết nối đến server!");  // Sử dụng alert hệ thống
          return;
        }
    
        // Xử lý phản hồi từ server
        const response = JSON.parse(this.responseText);  // Phản hồi trả về từ server
        console.log("Response message:", response.message); // Kiểm tra thông báo
    
        if (response.status === "error") {
          alert(response.message);  // Hiển thị thông báo lỗi
        } else if (response.status === "success") {
          alert(response.message);  // Hiển thị thông báo thành công
          setTimeout(() => {
            window.location.href = "?url=/Home/Login/";
          }, 2000);
        } else {
          alert("Phản hồi không xác định từ server!");  // Thông báo nếu có vấn đề
        }
      }
    };
    
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
  });
});
