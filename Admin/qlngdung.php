<?php
session_start();
include 'connect.php';

// Xử lý khóa tài khoản (GET request)
$messages = []; // Mảng lưu trữ thông báo
if (isset($_GET['action']) && $_GET['action'] == 'ban') {
    $id = intval($_GET['id']);
    if ($conn->query("UPDATE account SET STATUS='Bị ban' WHERE ID=$id")) {
        $messages[] = ['text' => 'Khóa tài khoản thành công!', 'type' => 'success'];
    } else {
        $messages[] = ['text' => 'Lỗi khi khóa tài khoản: ' . $conn->error, 'type' => 'danger'];
    }
}

// Xử lý mở khóa tài khoản (GET request)
if (isset($_GET['action']) && $_GET['action'] == 'unban') {
    $id = intval($_GET['id']);
    if ($conn->query("UPDATE account SET STATUS='Hoạt động' WHERE ID=$id")) {
        $messages[] = ['text' => 'Mở khóa tài khoản thành công!', 'type' => 'success'];
    } else {
        $messages[] = ['text' => 'Lỗi khi mở khóa tài khoản: ' . $conn->error, 'type' => 'danger'];
    }
}

// Khai báo biến để lưu lỗi
$errorMessages = [];

// Tạo thư mục uploads nếu chưa tồn tại
$upload_dir = 'uploads';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Xử lý submit form thêm/sửa (dựa vào method POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu chung từ form
    $id        = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $fname     = trim($_POST['fname']);
    $phone     = trim($_POST['phone']);
    $address   = trim($_POST['address']);
    $username  = trim($_POST['username']);
    $pwd       = trim($_POST['pwd']);
    $email     = trim($_POST['email']);
    $img_url   = '';

    // Ràng buộc: Các trường không được để trống
    if (empty($fname) || empty($phone) || empty($address) || empty($username) || empty($pwd) || empty($email)) {
        $errorMessages[] = "Tất cả các trường bắt buộc phải được điền.";
    }
    // Ràng buộc: Email phải hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages[] = "Email không hợp lệ.";
    }
    // Ràng buộc: Username không trùng (khi thêm mới)
    if (empty($id)) {
        $checkUsername = $conn->query("SELECT ID FROM account WHERE USERNAME='$username'");
        if ($checkUsername->num_rows > 0) {
            $errorMessages[] = "Tên đăng nhập đã tồn tại.";
        }
    }

    // Xử lý upload hình ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_name = time() . '_' . basename($_FILES['image']['name']);
        $upload_path = $upload_dir . '/' . $file_name;

        // Kiểm tra loại file (chỉ cho phép hình ảnh)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['image']['tmp_name']);
        if (!in_array($file_type, $allowed_types)) {
            $errorMessages[] = 'Chỉ được upload file hình ảnh (JPEG, PNG, GIF)!';
        } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) { // Giới hạn 5MB
            $errorMessages[] = 'Hình ảnh không được lớn hơn 5MB!';
        } else {
            // Upload file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $img_url = $upload_path;
            } else {
                $errorMessages[] = 'Lỗi khi upload hình ảnh!';
            }
        }
    }

    // Nếu không có lỗi, tiến hành xử lý thêm hoặc sửa
    if (empty($errorMessages)) {
        // Escape dữ liệu trước khi đưa vào query
        $fname    = $conn->real_escape_string($fname);
        $phone    = $conn->real_escape_string($phone);
        $address  = $conn->real_escape_string($address);
        $username = $conn->real_escape_string($username);
        $pwd      = $conn->real_escape_string($pwd);
        $email    = $conn->real_escape_string($email);
        $rank     = 0; // Giá trị mặc định cho RANK

        if (isset($_POST['add_user'])) {
            $query = "INSERT INTO account (FNAME, PHONE, ADDRESS, USERNAME, PWD, IMG_URL, RANK, EMAIL, STATUS) 
                      VALUES ('$fname', '$phone', '$address', '$username', '$pwd', '$img_url', $rank, '$email', 'Hoạt động')";
            if ($conn->query($query)) {
                $messages[] = ['text' => 'Thêm người dùng thành công!', 'type' => 'success'];
            } else {
                $messages[] = ['text' => 'Lỗi khi thêm người dùng: ' . $conn->error, 'type' => 'danger'];
                if ($img_url && file_exists($img_url)) {
                    unlink($img_url);
                }
            }
        } elseif (isset($_POST['edit_user']) && $id > 0) {
            $img_query = $img_url ? "IMG_URL='$img_url'," : '';
            $query = "UPDATE account SET 
                          FNAME='$fname', 
                          PHONE='$phone', 
                          ADDRESS='$address', 
                          USERNAME='$username', 
                          PWD='$pwd', 
                          $img_query
                          RANK=$rank, 
                          EMAIL='$email' 
                      WHERE ID=$id";
            if ($conn->query($query)) {
                $messages[] = ['text' => 'Cập nhật người dùng thành công!', 'type' => 'success'];
            } else {
                $messages[] = ['text' => 'Lỗi khi cập nhật người dùng: ' . $conn->error, 'type' => 'danger'];
                if ($img_url && file_exists($img_url)) {
                    unlink($img_url);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f4f9;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
            min-height: calc(100vh - 100px);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 15px 15px 0 0;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger, .btn-warning, .btn-secondary, .btn-success {
            border-radius: 8px;
            padding: 6px 12px;
        }
        .table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table thead {
            background-color: #f8f9fa;
        }
        .table tbody tr:hover {
            background-color: #f1f4f9;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 2000;
        }
        .toast {
            min-width: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .modal-content {
            border-radius: 15px;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            .table-responsive {
                font-size: 14px;
            }
            .toast-container {
                top: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <button class="toggle-btn btn btn-dark d-md-none" onclick="toggleSidebar()">☰</button>
    <?php include 'admin_header.php'; ?>

    <main class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4 text-primary"><i class="fas fa-users me-2"></i>Quản lý Người dùng</h2>

            <!-- Form thêm/sửa người dùng -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-plus-circle me-2"></i>Thêm/Sửa Người dùng</div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus me-1"></i>Thêm người dùng mới
                    </button>
                    <?php if (!empty($errorMessages)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errorMessages as $error): ?>
                                <p><?php echo htmlspecialchars($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Danh sách người dùng -->
            <div class="card">
                <div class="card-header"><i class="fas fa-table me-2"></i>Danh sách người dùng</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ và tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Tên đăng nhập</th>
                                    <th>Email</th>
                                    <th>Ảnh</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $result = $conn->query("SELECT * FROM account ORDER BY ID ASC");
                                while ($row = $result->fetch_assoc()): 
                                    // Chuẩn hóa đường dẫn hình ảnh
                                    $imagePathUrl = '';
                                    if (!empty($row['IMG_URL'])) {
                                        if (strpos($row['IMG_URL'], './Views/images/') === 0) {
                                            // Đường dẫn cũ bắt đầu bằng ./Views/images/
                                            $relativePath = str_replace('./', '', $row['IMG_URL']);
                                            $imagePathUrl = '/Valclo-Shop/' . $relativePath;
                                        } else {
                                            // Đường dẫn upload bắt đầu bằng uploads/
                                            $imagePathUrl = '/Valclo-Shop/Admin/' . $row['IMG_URL'];
                                        }
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $row['ID']; ?></td>
                                    <td><?php echo htmlspecialchars($row['FNAME']); ?></td>
                                    <td><?php echo htmlspecialchars($row['PHONE']); ?></td>
                                    <td><?php echo htmlspecialchars($row['ADDRESS']); ?></td>
                                    <td><?php echo htmlspecialchars($row['USERNAME']); ?></td>
                                    <td><?php echo htmlspecialchars($row['EMAIL']); ?></td>
                                    <td>
                                        <?php if($imagePathUrl != ""): ?>
                                            <img src="<?php echo htmlspecialchars($imagePathUrl); ?>" alt="<?php echo htmlspecialchars($row['FNAME']); ?>" width="50" height="50">
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['STATUS']); ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit-user" data-id="<?php echo $row['ID']; ?>"><i class="fas fa-edit me-1"></i>Sửa</button>
                                        <?php if ($row['STATUS'] == 'Hoạt động'): ?>
                                            <a href="qlngdung.php?action=ban&id=<?php echo $row['ID']; ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này?');"><i class="fas fa-lock me-1"></i>Khóa</a>
                                        <?php else: ?>
                                            <a href="qlngdung.php?action=unban&id=<?php echo $row['ID']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Bạn có chắc chắn muốn mở khóa tài khoản này?');"><i class="fas fa-unlock me-1"></i>Mở khóa</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal thêm người dùng -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel"><i class="fas fa-user-plus me-2"></i>Thêm người dùng mới</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="addUserForm" enctype="multipart/form-data">
                                <input type="hidden" name="add_user" value="1">
                                <div class="mb-3">
                                    <label for="add_fname" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="fname" id="add_fname" class="form-control" placeholder="Nhập họ và tên" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" id="add_phone" class="form-control" placeholder="Nhập số điện thoại" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <input type="text" name="address" id="add_address" class="form-control" placeholder="Nhập địa chỉ" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_username" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="add_username" class="form-control" placeholder="Nhập tên đăng nhập" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_pwd" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="pwd" id="add_pwd" class="form-control" placeholder="Nhập mật khẩu" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="add_email" class="form-control" placeholder="Nhập email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_image" class="form-label">Hình ảnh</label>
                                    <input type="file" name="image" id="add_image" class="form-control" accept="image/*">
                                    <img id="add_imagePreview" class="image-preview" src="" alt="Preview">
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Thêm người dùng</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal sửa người dùng -->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel"><i class="fas fa-edit me-2"></i>Sửa người dùng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="editUserForm" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="edit_id">
                                <input type="hidden" name="edit_user" value="1">
                                <div class="mb-3">
                                    <label for="edit_fname" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="fname" id="edit_fname" class="form-control" placeholder="Nhập họ và tên" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" id="edit_phone" class="form-control" placeholder="Nhập số điện thoại" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <input type="text" name="address" id="edit_address" class="form-control" placeholder="Nhập địa chỉ" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_username" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="edit_username" class="form-control" placeholder="Nhập tên đăng nhập" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_pwd" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="pwd" id="edit_pwd" class="form-control" placeholder="Nhập mật khẩu" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="edit_email" class="form-control" placeholder="Nhập email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_image" class="form-label">Hình ảnh</label>
                                    <input type="file" name="image" id="edit_image" class="form-control" accept="image/*">
                                    <img id="edit_imagePreview" class="image-preview" src="" alt="Preview">
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Cập nhật người dùng</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toast container -->
            <div class="toast-container">
                <div id="toast" class="toast align-items-center text-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                    <div class="d-flex">
                        <div class="toast-body"><i class="fas me-2"></i><span></span></div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'admin_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }

        function showToast(message, type) {
            let toast = document.getElementById('toast');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            let toastBody = toast.querySelector('.toast-body');
            toastBody.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>${message}`;
            let bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        }

        // Hàm gắn sự kiện cho các nút Sửa
        function attachEditEvents() {
            const editButtons = document.querySelectorAll('.edit-user');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    fetch(`get_user.php?id=${id}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Lỗi mạng: ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                showToast(data.error, 'danger');
                                return;
                            }
                            // Điền dữ liệu vào form
                            document.getElementById('edit_id').value = data.ID;
                            document.getElementById('edit_fname').value = data.FNAME;
                            document.getElementById('edit_phone').value = data.PHONE;
                            document.getElementById('edit_address').value = data.ADDRESS;
                            document.getElementById('edit_username').value = data.USERNAME;
                            document.getElementById('edit_pwd').value = data.PWD;
                            document.getElementById('edit_email').value = data.EMAIL;
                            const imagePreview = document.getElementById('edit_imagePreview');
                            if (data.IMG_URL) {
                                let imagePathUrl = '';
                                if (data.IMG_URL.startsWith('./Views/images/')) {
                                    const relativePath = data.IMG_URL.replace('./', '');
                                    imagePathUrl = '/Valclo-Shop/' + relativePath;
                                } else {
                                    imagePathUrl = '/Valclo-Shop/Admin/' + data.IMG_URL;
                                }
                                imagePreview.src = imagePathUrl;
                                imagePreview.style.display = 'block';
                            } else {
                                imagePreview.style.display = 'none';
                            }
                            // Hiển thị modal
                            const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                            editModal.show();
                        })
                        .catch(error => {
                            showToast('Lỗi khi lấy dữ liệu người dùng: ' + error.message, 'danger');
                        });
                });
            });
        }

        // Client-side form validation và xử lý preview ảnh
        document.addEventListener('DOMContentLoaded', function() {
            const addForm = document.getElementById('addUserForm');
            const editForm = document.getElementById('editUserForm');

            if (addForm) {
                addForm.addEventListener('submit', function(e) {
                    let fname = document.getElementById('add_fname').value.trim();
                    let phone = document.getElementById('add_phone').value.trim();
                    let address = document.getElementById('add_address').value.trim();
                    let username = document.getElementById('add_username').value.trim();
                    let pwd = document.getElementById('add_pwd').value.trim();
                    let email = document.getElementById('add_email').value.trim();

                    if (!fname || !phone || !address || !username || !pwd || !email) {
                        e.preventDefault();
                        showToast('Tất cả các trường bắt buộc phải được điền!', 'danger');
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        e.preventDefault();
                        showToast('Email không hợp lệ!', 'danger');
                    }
                });
            }

            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    let fname = document.getElementById('edit_fname').value.trim();
                    let phone = document.getElementById('edit_phone').value.trim();
                    let address = document.getElementById('edit_address').value.trim();
                    let username = document.getElementById('edit_username').value.trim();
                    let pwd = document.getElementById('edit_pwd').value.trim();
                    let email = document.getElementById('edit_email').value.trim();

                    if (!fname || !phone || !address || !username || !pwd || !email) {
                        e.preventDefault();
                        showToast('Tất cả các trường bắt buộc phải được điền!', 'danger');
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        e.preventDefault();
                        showToast('Email không hợp lệ!', 'danger');
                    }
                });
            }

            // Preview hình ảnh trước khi upload
            const addImageInput = document.getElementById('add_image');
            const addImagePreview = document.getElementById('add_imagePreview');
            if (addImageInput) {
                addImageInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        addImagePreview.src = URL.createObjectURL(e.target.files[0]);
                        addImagePreview.style.display = 'block';
                    } else {
                        addImagePreview.style.display = 'none';
                    }
                });
            }

            const editImageInput = document.getElementById('edit_image');
            const editImagePreview = document.getElementById('edit_imagePreview');
            if (editImageInput) {
                editImageInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        editImagePreview.src = URL.createObjectURL(e.target.files[0]);
                        editImagePreview.style.display = 'block';
                    } else {
                        editImagePreview.style.display = 'none';
                    }
                });
            }

            // Gắn sự kiện cho các nút Sửa
            attachEditEvents();

            // Hiển thị thông báo từ PHP
            <?php
            foreach ($messages as $msg) {
                echo "showToast('{$msg['text']}', '{$msg['type']}');";
            }
            ?>
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>