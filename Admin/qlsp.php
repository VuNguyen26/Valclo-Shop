<?php
session_start();
include 'connect.php';

// Xử lý xóa sản phẩm (GET request)
$messages = []; // Mảng lưu trữ thông báo
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    if ($conn->query("DELETE FROM PRODUCT WHERE ID=$id")) {
        $messages[] = ['text' => 'Xóa sản phẩm thành công!', 'type' => 'success'];
    } else {
        $messages[] = ['text' => 'Lỗi khi xóa sản phẩm: ' . $conn->error, 'type' => 'danger'];
    }
}

// Khai báo biến để lưu lỗi
$errorMessages = [];

// Xử lý submit form sửa sản phẩm (dựa vào method POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
    // Lấy dữ liệu từ form
    $id          = intval($_POST['id']);
    $name        = trim($_POST['name']);
    $price       = intval($_POST['price']);
    $decs        = trim($_POST['decs']);
    $category    = intval($_POST['category']);
    $top_product = intval($_POST['top_product']);
    $img_url     = '';

    // Ràng buộc: Giá phải là số nguyên dương
    if ($price <= 0) {
        $errorMessages[] = "Giá phải là số nguyên dương.";
    }
    // Ràng buộc: Danh mục phải tồn tại trong bảng CATEGORY
    $validCategory = $conn->query("SELECT id FROM CATEGORY WHERE id = $category AND state = 1");
    if ($validCategory->num_rows == 0) {
        $errorMessages[] = "Danh mục không hợp lệ.";
    }

// Xử lý upload hình ảnh
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $admin_upload_dir = 'uploads/';
    $user_upload_dir = '../Views/images/';

    if (!is_dir($admin_upload_dir)) {
        mkdir($admin_upload_dir, 0777, true);
    }

    if (!is_dir($user_upload_dir)) {
        mkdir($user_upload_dir, 0777, true);
    }

    // Tạo tên file duy nhất để tránh trùng
    $file_name = time() . '_' . basename($_FILES['image']['name']);
    $admin_upload_path = $admin_upload_dir . $file_name;
    $user_upload_path = $user_upload_dir . $file_name;

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = mime_content_type($_FILES['image']['tmp_name']);
    
    if (!in_array($file_type, $allowed_types)) {
        $errorMessages[] = 'Chỉ được upload file hình ảnh (JPEG, PNG, GIF)!';
    } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) {
        $errorMessages[] = 'Hình ảnh không được lớn hơn 5MB!';
    } else {
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $admin_upload_path)) {
            // Sao chép file sang thư mục user (Views/images/)
            if (copy($admin_upload_path, $user_upload_path)) {
                
                $img_url = 'Views/images/' . $file_name;
            } else {
                $errorMessages[] = 'Lỗi khi sao chép hình ảnh sang thư mục user!';
            }
        } else {
            $errorMessages[] = 'Lỗi khi upload hình ảnh vào thư mục admin!';
        }
    }
}

    // Nếu không có lỗi, tiến hành sửa sản phẩm
    if (empty($errorMessages)) {
        // Escape dữ liệu trước khi đưa vào query
        $name     = $conn->real_escape_string($name);
        $decs     = $conn->real_escape_string($decs);

        // Nếu có ảnh mới, cập nhật IMG_URL, nếu không giữ nguyên
        $img_query = $img_url ? "IMG_URL='$img_url'," : '';
        $query = "UPDATE PRODUCT SET 
                      NAME='$name', 
                      PRICE=$price, 
                      $img_query
                      DECS='$decs', 
                      CATEGORY=$category, 
                      TOP_PRODUCT=$top_product 
                  WHERE ID=$id";
        if ($conn->query($query)) {
            $messages[] = ['text' => 'Cập nhật sản phẩm thành công!', 'type' => 'success'];
        } else {
            $messages[] = ['text' => 'Lỗi khi cập nhật sản phẩm: ' . $conn->error, 'type' => 'danger'];
            // Xóa ảnh nếu cập nhật thất bại
            if ($img_url && file_exists($img_url)) {
                unlink($img_url);
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
    <title>Quản lý Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=default" rel="stylesheet">
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
        .btn-danger, .btn-warning {
            border-radius: 8px;
            padding: 6px 12px;
            margin-top: 5px;
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
            <h2 class="mb-4 text-primary"><i class="fas fa-box-open me-2"></i>Quản lý Sản phẩm</h2>

            <!-- Danh sách sản phẩm -->
            <div class="card">
                <div class="card-header"><i class="fas fa-table me-2"></i>Danh sách sản phẩm</div>
                <div class="card-body">
                    <?php if (!empty($errorMessages)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errorMessages as $error): ?>
                                <p><?php echo htmlspecialchars($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Ảnh</th>
                                    <th>Số lượng</th>
                                    <th style="width: 200px;">Mô tả</th>
                                    <th>Danh mục</th>
                                    <th>Top sản phẩm</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="product-table">
                                <!-- Dữ liệu sẽ được tải qua AJAX -->
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination-container" class="mt-4"></div>
                    <div id="error-message" class="error-message"></div>
                </div>
            </div>

            <!-- Modal sửa sản phẩm -->
            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel"><i class="fas fa-edit me-2"></i>Sửa sản phẩm</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="editProductForm" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="edit_id">
                                <input type="hidden" name="edit_product" value="1">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="edit_name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá (VND) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="edit_price" class="form-control" min="1" placeholder="Nhập giá" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                                    <input type="file" name="image" id="edit_image" class="form-control" accept="image/*">
                                    <img id="edit_imagePreview" class="image-preview" src="" alt="Preview">
                                </div>
                                <div class="mb-3">
                                    <label for="decs" class="form-label">Mô tả</label>
                                    <textarea name="decs" id="edit_decs" class="form-control" placeholder="Nhập mô tả sản phẩm" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="category" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select name="category" id="edit_category" class="form-select" required>
                                        <option value="">Chọn danh mục</option>
                                        <?php
                                        $categories = $conn->query("SELECT id, name_category FROM CATEGORY WHERE state = 1");
                                        while ($category = $categories->fetch_assoc()): ?>
                                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name_category']); ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="top_product" class="form-label">Top sản phẩm</label>
                                    <input type="number" name="top_product" id="edit_top_product" class="form-control" min="0" placeholder="Nhập thứ tự top">
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Cập nhật sản phẩm</button>
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

        // Hàm tải dữ liệu sản phẩm qua AJAX
        function loadProducts(page) {
            fetch('fetch_products.php?page=' + page)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Lỗi mạng: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    // Xóa thông báo lỗi nếu có
                    document.getElementById('error-message').innerHTML = '';

                    // Kiểm tra nếu có lỗi
                    if (data.error) {
                        document.getElementById('error-message').innerHTML = data.error;
                        return;
                    }

                    // Cập nhật nội dung bảng
                    const tbody = document.querySelector('#product-table');
                    tbody.innerHTML = ''; // Xóa nội dung cũ

                    if (data.products.length > 0) {
                        data.products.forEach(product => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${product.ID}</td>
                                <td>${product.NAME}</td>
                                <td>${new Intl.NumberFormat('vi-VN').format(product.PRICE)} VND</td>
                                <td>
                                    ${product.IMG_URL ? 
                                        (product.IMG_URL.startsWith('http') ? 
                                            `<img src="${product.IMG_URL}" alt="${product.NAME}" width="50" height="50" onerror="this.src='https://via.placeholder.com/50';">` 
                                            : 
                                            `<img src="${product.IMG_URL.replace('Views/images/', 'uploads/')}" alt="${product.NAME}" width="50" height="50" onerror="this.src='https://via.placeholder.com/50';">`
                                        ) 
                                        : 'N/A'}
                                </td>
                                <td>${product.NUMBER}</td>
                                <td style="width: 200px;">${product.DECS}</td>
                                <td>${product.CATEGORY_NAME || product.CATEGORY}</td>
                                <td>${product.TOP_PRODUCT}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-product" data-id="${product.ID}"><i class="fas fa-edit me-1"></i>Sửa</button>
                                    <a href="qlsp.php?action=delete&id=${product.ID}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"><i class="fas fa-trash me-1"></i>Xóa</a>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="9" class="text-center">Không có sản phẩm nào để hiển thị.</td></tr>';
                    }

                    // Cập nhật phân trang
                    const paginationContainer = document.querySelector('#pagination-container');
                    paginationContainer.innerHTML = ''; // Xóa nội dung cũ
                    const pagination = document.createElement('nav');
                    pagination.setAttribute('aria-label', 'Page navigation');
                    let paginationHTML = '<ul class="pagination">';
                    
                    // Nút Trang trước
                    paginationHTML += `
                        <li class="page-item ${data.currentPage <= 1 ? 'disabled' : ''}">
                            <a class="page-link" href="#" data-page="${data.currentPage - 1}" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                            </a>
                        </li>
                    `;

                    // Các số trang
                    for (let i = 1; i <= data.totalPages; i++) {
                        paginationHTML += `
                            <li class="page-item ${i === data.currentPage ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>
                        `;
                    }

                    // Nút Trang sau
                    paginationHTML += `
                        <li class="page-item ${data.currentPage >= data.totalPages ? 'disabled' : ''}">
                            <a class="page-link" href="#" data-page="${data.currentPage + 1}" aria-label="Next">
                                <span aria-hidden="true">»</span>
                            </a>
                        </li>
                    `;

                    paginationHTML += '</ul>';
                    pagination.innerHTML = paginationHTML;
                    paginationContainer.appendChild(pagination);

                    // Thêm sự kiện cho các liên kết phân trang mới
                    attachPaginationEvents();

                    // Thêm sự kiện cho nút Sửa
                    attachEditEvents();
                })
                .catch(error => {
                    document.getElementById('error-message').innerHTML = 'Lỗi khi tải dữ liệu: ' + error.message;
                    showToast('Lỗi khi tải dữ liệu sản phẩm!', 'danger');
                });
        }

        // Hàm gắn sự kiện cho các liên kết phân trang
        function attachPaginationEvents() {
            const links = document.querySelectorAll('.pagination .page-link');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');
                    if (page && !this.parentElement.classList.contains('disabled')) {
                        loadProducts(page);
                    }
                });
            });
        }

        // Hàm gắn sự kiện cho các nút Sửa
        function attachEditEvents() {
            const editButtons = document.querySelectorAll('.edit-product');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    fetch(`get_product.php?id=${id}`)
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
                            document.getElementById('edit_name').value = data.NAME;
                            document.getElementById('edit_price').value = data.PRICE;
                            document.getElementById('edit_decs').value = data.DECS || '';
                            document.getElementById('edit_category').value = data.CATEGORY;
                            document.getElementById('edit_top_product').value = data.TOP_PRODUCT || 0;
                            const imagePreview = document.getElementById('edit_imagePreview');
                            if (data.IMG_URL) {
                                imagePreview.src = data.IMG_URL;
                                imagePreview.style.display = 'block';
                            } else {
                                imagePreview.style.display = 'none';
                            }
                            // Hiển thị modal
                            const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                            editModal.show();
                        })
                        .catch(error => {
                            showToast('Lỗi khi lấy dữ liệu sản phẩm: ' + error.message, 'danger');
                        });
                });
            });
        }

        // Client-side form validation và xử lý preview ảnh
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('editProductForm');

            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    let name = document.getElementById('edit_name').value.trim();
                    let price = document.getElementById('edit_price').value;
                    let category = document.getElementById('edit_category').value;

                    if (!name) {
                        e.preventDefault();
                        showToast('Tên sản phẩm không được để trống!', 'danger');
                    } else if (price <= 0) {
                        e.preventDefault();
                        showToast('Giá phải là số nguyên dương!', 'danger');
                    } else if (!category) {
                        e.preventDefault();
                        showToast('Vui lòng chọn danh mục sản phẩm!', 'danger');
                    }
                });
            }

            // Preview hình ảnh trước khi upload
            const imageInput = document.getElementById('edit_image');
            const imagePreview = document.getElementById('edit_imagePreview');
            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        imagePreview.src = URL.createObjectURL(e.target.files[0]);
                        imagePreview.style.display = 'block';
                    } else {
                        imagePreview.style.display = 'none';
                    }
                });
            }

            // Tải dữ liệu trang đầu tiên
            loadProducts(1);

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