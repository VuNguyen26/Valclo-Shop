$(function () {
	$("input[type='password'][data-eye]").each(function (i) {
		var $this = $(this),
			id = 'eye-password-' + i;

		$this.wrap($("<div/>", {
			style: 'position:relative',
			id: id
		}));

		$this.css({ paddingRight: 60 });

		$this.after($("<div/>", {
			html: 'Hiện',
			class: 'btn btn-warning btn-sm',
			id: 'passeye-toggle-' + i,
		}).css({
			position: 'absolute',
			right: 10,
			top: ($this.outerHeight() / 2) - 13,
			padding: '2px 7px',
			fontSize: 14,
			cursor: 'pointer',
		}));

		$this.after($("<input/>", {
			type: 'hidden',
			id: 'passeye-' + i
		}));

		var invalid_feedback = $this.parent().parent().find('.invalid-feedback');
		if (invalid_feedback.length) {
			$this.after(invalid_feedback.clone());
		}

		$this.on("keyup paste", function () {
			$("#passeye-" + i).val($(this).val());
		});

		$("#passeye-toggle-" + i).on("click", function () {
			if ($this.hasClass("show")) {
				$this.attr('type', 'password');
				$this.removeClass("show");
				$(this).removeClass("btn-outline-primary");
			} else {
				$this.attr('type', 'text');
				$this.val($("#passeye-" + i).val());
				$this.addClass("show");
				$(this).addClass("btn-outline-primary");
			}
		});
	});

	$(".my-login-validation").submit(function (event) {
		var form = $(this);
		if (form[0].checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
		}
		form.addClass('was-validated');
	});
});

function add_notice(alert, string) {
	return '<div class="alert ' + alert + '" role="alert"><strong>' + string + '</strong></div>';
}

window.addEventListener("DOMContentLoaded", function () {
	const loginButton = document.querySelector("button[type='submit']");
	const usernameInput = document.querySelector("input[name='user']");
	const passwordInput = document.querySelector("input[name='password']");

	if (!loginButton || !usernameInput || !passwordInput) {
		console.warn("Không tìm thấy nút hoặc input đăng nhập.");
		return;
	}

	loginButton.addEventListener("click", function () {
		const username = usernameInput.value.trim();
		const password = passwordInput.value.trim();

		if (!username || !password) {
			console.warn("Thiếu tên đăng nhập hoặc mật khẩu.");
			return;
		}

		const xmlhttp = new XMLHttpRequest(); // ✅ PHẢI khai báo biến này

		xmlhttp.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				const res = this.responseText.trim();
				console.log("Server response:", res); // ✅ In ra để debug

				if (res.startsWith("error:")) {
					const message = res.replace("error:", "");
					document.getElementById("notice").innerHTML = add_notice("fail", message);
					document.getElementsByClassName("alert")[0].style.display = "block";
					setTimeout(() => {
						document.getElementsByClassName("alert")[0].style.opacity = 0;
					}, 1500);
				} else if (res !== "null") {
					document.getElementById("notice").innerHTML = add_notice("success", "Đăng nhập thành công");
					document.getElementsByClassName("alert")[0].style.display = "block";
					setTimeout(() => {
						document.getElementsByClassName("alert")[0].style.opacity = 0;
					}, 1500);
					window.location.href = res;
				} else {
					document.getElementById("notice").innerHTML = add_notice("fail", "Tên đăng nhập hoặc mật khẩu không đúng");
					document.getElementsByClassName("alert")[0].style.display = "block";
					setTimeout(() => {
						document.getElementsByClassName("alert")[0].style.opacity = 0;
					}, 1500);
				}
			}
		};

		xmlhttp.open("GET", `?url=Home/check_login/${username}/${password}/`, true);
		xmlhttp.send();
	});
});
