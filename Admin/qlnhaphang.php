<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('location:admin_login.php');
    exit;
}

// Đặt múi giờ để đảm bảo lấy ngày hiện tại đúng
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Mảng lưu trữ thông báo
$messages = [];

// Xử lý thêm nhà cung cấp mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_supplier'])) {
    $name = trim($_POST['supplier_name']);
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $note = trim($_POST['supplier_note'] ?? '');

    // Kiểm tra dữ liệu đầu vào
    if (empty($name)) {
        $messages[] = ['text' => 'Tên nhà cung cấp không được để trống!', 'type' => 'danger'];
    } else {
        $sql = "INSERT INTO supplier (NAME, PHONE, EMAIL, ADDRESS, NOTE) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $phone, $email, $address, $note);
        
        if ($stmt->execute()) {
            $messages[] = ['text' => 'Thêm nhà cung cấp thành công!', 'type' => 'success'];
        } else {
            $messages[] = ['text' => 'Lỗi khi thêm nhà cung cấp: ' . $conn->error, 'type' => 'danger'];
        }
        $stmt->close();
    }
}

// Xử lý thêm sản phẩm mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['product_name']);
    $price = $_POST['price'] ?? 0;
    $number = 0; // Tồn kho mặc định là 0
    $description = trim($_POST['description'] ?? '');
    $category = $_POST['category'] ?? 1; // Mặc định là danh mục 1 (Áo) nếu không chọn
    $img_url = '';

    // Kiểm tra dữ liệu đầu vào
    if (empty($name)) {
        $messages[] = ['text' => 'Tên sản phẩm không được để trống!', 'type' => 'danger'];
    } elseif ($price < 0) {
        $messages[] = ['text' => 'Giá không được nhỏ hơn 0!', 'type' => 'danger'];
    } elseif (empty($category)) {
        $messages[] = ['text' => 'Vui lòng chọn danh mục sản phẩm!', 'type' => 'danger'];
    } else {
        // Xử lý upload hình ảnh
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $upload_dir = 'uploads/';
            $file_name = time() . '_' . basename($_FILES['image']['name']);
            $upload_path = $upload_dir . $file_name;

            // Kiểm tra loại file (chỉ cho phép hình ảnh)
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_type = mime_content_type($_FILES['image']['tmp_name']);
            if (!in_array($file_type, $allowed_types)) {
                $messages[] = ['text' => 'Chỉ được upload file hình ảnh (JPEG, PNG, GIF)!', 'type' => 'danger'];
            } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) { // Giới hạn 5MB
                $messages[] = ['text' => 'Hình ảnh không được lớn hơn 5MB!', 'type' => 'danger'];
            } else {
                // Upload file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $img_url = $upload_path;
                } else {
                    $messages[] = ['text' => 'Lỗi khi upload hình ảnh!', 'type' => 'danger'];
                }
            }
        }

        // Nếu không có lỗi upload, tiến hành thêm sản phẩm
        if (empty($messages)) {
            $sql = "INSERT INTO product (NAME, PRICE, NUMBER, DECS, CATEGORY, IMG_URL) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siisis", $name, $price, $number, $description, $category, $img_url);
            
            if ($stmt->execute()) {
                $messages[] = ['text' => 'Thêm sản phẩm thành công! Bạn có thể quản lý sản phẩm tại Quản lý sản phẩm.', 'type' => 'success'];
            } else {
                $messages[] = ['text' => 'Lỗi khi thêm sản phẩm: ' . $conn->error, 'type' => 'danger'];
                // Xóa hình ảnh nếu thêm sản phẩm thất bại
                if ($img_url && file_exists($img_url)) {
                    unlink($img_url);
                }
            }
            $stmt->close();
        }
    }
}

// Xử lý thêm đợt nhập hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_import'])) {
    $supplier_id = $_POST['supplier_id'];
    $import_date = $_POST['import_date'];
    $note = $_POST['note'] ?? '';
    $admin_username = $_SESSION['username'];

    // Lấy ngày hiện tại
    $current_date = new DateTime(); // Ngày hiện tại (2025-05-06)
    $import_date_obj = new DateTime($import_date);

    // Kiểm tra dữ liệu đầu vào
    if (empty($supplier_id) || empty($import_date)) {
        $messages[] = ['text' => 'Vui lòng điền đầy đủ nhà cung cấp và ngày nhập!', 'type' => 'danger'];
    } elseif ($import_date_obj < $current_date) {
        $messages[] = ['text' => 'Ngày nhập phải lớn hơn hoặc bằng ngày hiện tại (' . $current_date->format('Y-m-d') . ')!', 'type' => 'danger'];
    } else {
        $sql = "INSERT INTO import (SUPPLIER_ID, ADMIN_USERNAME, IMPORT_DATE, NOTE) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $supplier_id, $admin_username, $import_date, $note);
        
        if ($stmt->execute()) {
            $messages[] = ['text' => 'Thêm đợt nhập hàng thành công!', 'type' => 'success'];
        } else {
            $messages[] = ['text' => 'Lỗi khi thêm đợt nhập hàng: ' . $conn->error, 'type' => 'danger'];
        }
        $stmt->close();
    }
}

// Xử lý thêm chi tiết nhập hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_import_detail'])) {
    $import_id = $_POST['import_id'];
    $pid = $_POST['pid'];
    $quantity = $_POST['quantity'];
    $import_price = $_POST['import_price'];

    // Lấy ngày nhập của đợt nhập hàng
    $current_date = new DateTime(); // Ngày hiện tại (2025-05-06)
    $sql = "SELECT IMPORT_DATE FROM import WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $import_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Kiểm tra dữ liệu đầu vào
    if (empty($import_id) || empty($pid) || $quantity <= 0 || $import_price < 0) {
        $messages[] = ['text' => 'Vui lòng nhập thông tin hợp lệ (số lượng > 0, giá nhập >= 0)!', 'type' => 'danger'];
    } elseif ($result->num_rows == 0) {
        $messages[] = ['text' => 'Đợt nhập hàng không tồn tại!', 'type' => 'danger'];
    } else {
        $row = $result->fetch_assoc();
        $import_date_str = $row['IMPORT_DATE'];
        
        // Kiểm tra nếu ngày nhập không rỗng và hợp lệ
        if ($import_date_str) {
            $import_date = new DateTime($import_date_str);
            if ($import_date < $current_date) {
                $messages[] = ['text' => 'Đợt nhập hàng đã quá hạn!', 'type' => 'danger'];
            } else {
                $sql = "INSERT INTO import_detail (IMPORT_ID, PID, QUANTITY, IMPORT_PRICE) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iiii", $import_id, $pid, $quantity, $import_price);
                
                if ($stmt->execute()) {
                    $messages[] = ['text' => 'Thêm chi tiết nhập hàng thành công!', 'type' => 'success'];
                } else {
                    $messages[] = ['text' => 'Lỗi khi thêm chi tiết nhập hàng: ' . $conn->error, 'type' => 'danger'];
                }
            }
        } else {
            $messages[] = ['text' => 'Không thể lấy ngày nhập của đợt nhập hàng!', 'type' => 'danger'];
        }
    }
    $stmt->close();
}

// Xử lý xóa đợt nhập hàng
if (isset($_GET['delete_import'])) {
    $import_id = $_GET['delete_import'];
    $sql = "DELETE FROM import WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $import_id);
    
    if ($stmt->execute()) {
        $messages[] = ['text' => 'Xóa đợt nhập hàng thành công!', 'type' => 'success'];
    } else {
        $messages[] = ['text' => 'Lỗi khi xóa đợt nhập hàng: ' . $conn->error, 'type' => 'danger'];
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhập hàng</title>
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
        .btn-danger, .btn-info, .btn-success, .btn-warning {
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
        .toast-success {
            background-color: #28a745 !important;
        }
        .toast-danger {
            background-color: #dc3545 !important;
        }
        .modal-content {
            border-radius: 15px;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
            border-radius: 15px 15px 0 0;
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
            <h2 class="mb-4 text-primary"><i class="fas fa-warehouse me-2"></i>Quản lý nhập hàng</h2>

            <!-- Form thêm đợt nhập hàng -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-plus-circle me-2"></i>Thêm đợt nhập hàng</div>
                <div class="card-body">
                    <form method="POST" id="addImportForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="supplier_id" class="form-label">Nhà cung cấp</label>
                                <div class="input-group">
                                    <select name="supplier_id" id="supplier_id" class="form-select" required>
                                        <option value="">Chọn nhà cung cấp</option>
                                        <?php
                                        $sql = "SELECT ID, NAME FROM supplier";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['ID']}'>{$row['NAME']}</option>";
                                            }
                                        } else {
                                            echo "<option value='' disabled>Chưa có nhà cung cấp</option>";
                                        }
                                        ?>
                                    </select>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                                        <i class="fas fa-plus me-1"></i>Thêm mới
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="import_date" class="form-label">Ngày nhập</label>
                                <input type="date" name="import_date" id="import_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú</label>
                            <textarea name="note" id="note" class="form-control" placeholder="Nhập ghi chú (nếu có)" rows="3"></textarea>
                        </div>
                        <button type="submit" name="add_import" class="btn btn-primary"><i class="fas fa-save me-2"></i>Thêm đợt nhập</button>
                    </form>
                </div>
            </div>

            <!-- Form thêm chi tiết nhập hàng -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-list-ul me-2"></i>Thêm chi tiết nhập hàng</div>
                <div class="card-body">
                    <form method="POST" id="addDetailForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="import_id" class="form-label">Đợt nhập hàng</label>
                                <select name="import_id" id="import_id" class="form-select" required>
                                    <option value="" data-date="">Chọn đợt nhập</option>
                                    <?php
                                    $sql = "SELECT ID, IMPORT_DATE FROM import";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['ID']}' data-date='{$row['IMPORT_DATE']}'>{$row['ID']} - {$row['IMPORT_DATE']}</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>Chưa có đợt nhập</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pid" class="form-label">Sản phẩm</label>
                                <div class="input-group">
                                    <select name="pid" id="pid" class="form-select" required>
                                        <option value="">Chọn sản phẩm</option>
                                        <?php
                                        $sql = "SELECT ID, NAME FROM product";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['ID']}'>{$row['NAME']} (ID: {$row['ID']})</option>";
                                            }
                                        } else {
                                            echo "<option value='' disabled>Chưa có sản phẩm</option>";
                                        }
                                        ?>
                                    </select>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                        <i class="fas fa-plus me-1"></i>Thêm mới
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Số lượng</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" min="1" placeholder="Nhập số lượng" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="import_price" class="form-label">Giá nhập (VND)</label>
                                <input type="number" name="import_price" id="import_price" class="form-control" min="0" placeholder="Nhập giá nhập" required>
                            </div>
                        </div>
                        <button type="submit" name="add_import_detail" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Thêm chi tiết</button>
                    </form>
                </div>
            </div>

            <!-- Danh sách nhập hàng -->
            <div class="card">
                <div class="card-header"><i class="fas fa-table me-2"></i>Danh sách nhập hàng</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ngày nhập</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Tổng chi phí</th>
                                    <th>Ghi chú</th>
                                    <th>Chi tiết</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT i.ID, i.IMPORT_DATE, i.TOTAL_COST, i.NOTE, s.NAME AS supplier_name 
                                        FROM import i 
                                        LEFT JOIN supplier s ON i.SUPPLIER_ID = s.ID";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['ID']}</td>";
                                        echo "<td>{$row['IMPORT_DATE']}</td>";
                                        echo "<td>" . ($row['supplier_name'] ?: 'N/A') . "</td>";
                                        echo "<td>" . number_format($row['TOTAL_COST']) . " VND</td>";
                                        echo "<td>" . ($row['NOTE'] ?: 'N/A') . "</td>";
                                        echo "<td><button class='btn btn-info btn-sm' onclick=\"showDetails({$row['ID']})\"><i class='fas fa-eye me-1'></i>Xem</button></td>";
                                        echo "<td>
                                                <a href='?delete_import={$row['ID']}' class=\"btn btn-danger btn-sm\" onclick='return confirm(\"Bạn có chắc muốn xóa?\")'><i class='fas fa-trash me-1'></i>Xóa</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>Chưa có đợt nhập hàng nào!</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal thêm nhà cung cấp mới -->
            <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addSupplierModalLabel"><i class="fas fa-user-plus me-2"></i>Thêm nhà cung cấp mới</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="addSupplierForm">
                                <div class="mb-3">
                                    <label for="supplier_name" class="form-label">Tên nhà cung cấp <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_name" id="supplier_name" class="form-control" placeholder="Nhập tên nhà cung cấp" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <textarea name="address" id="address" class="form-control" placeholder="Nhập địa chỉ" rows="2"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_note" class="form-label">Ghi chú</label>
                                    <textarea name="supplier_note" id="supplier_note" class="form-control" placeholder="Nhập ghi chú (nếu có)" rows="2"></textarea>
                                </div>
                                <button type="submit" name="add_supplier" class="btn btn-primary"><i class="fas fa-save me-2"></i>Thêm nhà cung cấp</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal thêm sản phẩm mới -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel"><i class="fas fa-box-open me-2"></i>Thêm sản phẩm mới để nhập hàng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="addProductForm" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="product_name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá bán (VND) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="price" class="form-control" min="0" placeholder="Nhập giá bán" required>
                                </div>
                                <div class="mb-3">
                                    <label for="category" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-select" required>
                                        <option value="">Chọn danh mục</option>
                                        <?php
                                        $sql = "SELECT id, name_category FROM category";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['id']}'>{$row['name_category']}</option>";
                                            }
                                        } else {
                                            echo "<option value='' disabled>Chưa có danh mục</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Hình ảnh sản phẩm <span class="text-danger">*</span></label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                                    <img id="imagePreview" class="image-preview" src="" alt="Preview">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Nhập mô tả sản phẩm (nếu có)" rows="3"></textarea>
                                </div>
                                <button type="submit" name="add_product" class="btn btn-primary"><i class="fas fa-save me-2"></i>Thêm sản phẩm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal hiển thị chi tiết nhập hàng -->
            <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel"><i class="fas fa-list me-2"></i>Chi tiết nhập hàng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Giá nhập</th>
                                            <th>Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" onclick="exportPDF()"><i class="fas fa-file-pdf me-1"></i>Xuất PDF</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
        let currentImportId = null;

        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }

        function showDetails(importId) {
            currentImportId = importId;
            fetch(`get_import_details.php?import_id=${importId}`)
                .then(response => response.json())
                .then(data => {
                    let tbody = document.getElementById('detailTableBody');
                    tbody.innerHTML = '';
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Chưa có chi tiết nhập hàng!</td></tr>';
                    } else {
                        data.forEach(item => {
                            let row = `<tr>
                                <td>${item.NAME}</td>
                                <td>${item.QUANTITY}</td>
                                <td>${new Intl.NumberFormat('vi-VN').format(item.IMPORT_PRICE)} VND</td>
                                <td>${new Intl.NumberFormat('vi-VN').format(item.QUANTITY * item.IMPORT_PRICE)} VND</td>
                            </tr>`;
                            tbody.innerHTML += row;
                        });
                    }
                    new bootstrap.Modal(document.getElementById('detailModal')).show();
                })
                .catch(error => {
                    console.error('Lỗi khi lấy chi tiết:', error);
                    showToast('Lỗi khi lấy chi tiết nhập hàng!', 'danger');
                });
        }

        function exportPDF() {
            if (currentImportId) {
                window.location.href = `export_import_details_pdf.php?import_id=${currentImportId}`;
            } else {
                showToast('Không tìm thấy ID đợt nhập hàng!', 'danger');
            }
        }

        function showToast(message, type) {
            let toast = document.getElementById('toast');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            let toastBody = toast.querySelector('.toast-body');
            toastBody.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>${message}`;
            let bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            console.log(`Toast displayed: ${message} (${type})`);
        }

        // Client-side form validation cho thêm đợt nhập hàng
        document.getElementById('addImportForm').addEventListener('submit', function(e) {
            let supplier = document.getElementById('supplier_id').value;
            let date = document.getElementById('import_date').value;
            let currentDate = '<?php echo date('Y-m-d'); ?>'; // Ngày hiện tại từ PHP
            if (!supplier || !date) {
                e.preventDefault();
                showToast('Vui lòng điền đầy đủ nhà cung cấp và ngày nhập!', 'danger');
            } else if (date < currentDate) {
                e.preventDefault();
                showToast('Ngày nhập phải lớn hơn hoặc bằng ngày hiện tại (' + currentDate + ')!', 'danger');
            }
        });

        // Kiểm tra ngày nhập ngay khi người dùng thay đổi
        document.getElementById('import_date').addEventListener('change', function(e) {
            let date = e.target.value;
            let currentDate = '<?php echo date('Y-m-d'); ?>';
            if (date < currentDate) {
                showToast('Ngày nhập phải lớn hơn hoặc bằng ngày hiện tại (' + currentDate + ')!', 'danger');
                e.target.value = currentDate; // Đặt lại ngày về ngày hiện tại
            }
        });

        // Client-side form validation cho thêm chi tiết nhập hàng
        document.getElementById('addDetailForm').addEventListener('submit', function(e) {
            let importId = document.getElementById('import_id');
            let selectedOption = importId.options[importId.selectedIndex];
            let importDate = selectedOption ? selectedOption.getAttribute('data-date') : null;
            let pid = document.getElementById('pid').value;
            let quantity = document.getElementById('quantity').value;
            let price = document.getElementById('import_price').value;
            let currentDate = '<?php echo date('Y-m-d'); ?>'; // Ngày hiện tại từ PHP

            if (!importId.value || !pid || quantity <= 0 || price < 0) {
                e.preventDefault();
                showToast('Vui lòng nhập thông tin hợp lệ (số lượng > 0, giá nhập >= 0)!', 'danger');
            } else if (importDate && importDate < currentDate) {
                e.preventDefault();
                showToast('Đợt nhập hàng đã quá hạn!', 'danger');
            }
        });

        // Kiểm tra ngày nhập của đợt nhập hàng ngay khi người dùng thay đổi
        document.getElementById('import_id').addEventListener('change', function(e) {
            let selectedOption = e.target.options[e.target.selectedIndex];
            let importDate = selectedOption ? selectedOption.getAttribute('data-date') : null;
            let currentDate = '<?php echo date('Y-m-d'); ?>';
            if (importDate && importDate < currentDate) {
                showToast('Đợt nhập hàng đã quá hạn!', 'danger');
                e.target.value = ''; // Đặt lại lựa chọn về mặc định
            }
        });

        document.getElementById('addSupplierForm').addEventListener('submit', function(e) {
            let name = document.getElementById('supplier_name').value.trim();
            if (!name) {
                e.preventDefault();
                showToast('Tên nhà cung cấp không được để trống!', 'danger');
            }
        });

        document.getElementById('addProductForm').addEventListener('submit', function(e) {
            let name = document.getElementById('product_name').value.trim();
            let price = document.getElementById('price').value;
            let category = document.getElementById('category').value;
            let image = document.getElementById('image').files.length;
            if (!name) {
                e.preventDefault();
                showToast('Tên sản phẩm không được để trống!', 'danger');
            } else if (price < 0) {
                e.preventDefault();
                showToast('Giá không được nhỏ hơn 0!', 'danger');
            } else if (!category) {
                e.preventDefault();
                showToast('Vui lòng chọn danh mục sản phẩm!', 'danger');
            } else if (image === 0) {
                e.preventDefault();
                showToast('Vui lòng chọn hình ảnh sản phẩm!', 'danger');
            }
        });

        // Preview hình ảnh trước khi upload
        document.getElementById('image').addEventListener('change', function(e) {
            let imagePreview = document.getElementById('imagePreview');
            if (e.target.files.length > 0) {
                imagePreview.src = URL.createObjectURL(e.target.files[0]);
                imagePreview.style.display = 'block';
            } else {
                imagePreview.style.display = 'none';
            }
        });

        // Hiển thị thông báo từ PHP
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            foreach ($messages as $msg) {
                echo "showToast('{$msg['text']}', '{$msg['type']}');";
            }
            ?>
        });
    </script>
</body>
</html>