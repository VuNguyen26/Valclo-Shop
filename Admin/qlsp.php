<?php
session_start();
include 'connect.php';
/*
// Kết nối tới CSDL MySQL
$sever    = 'localhost';
$user     = 'root';
$password = '';
$database = 'web_db';
$port     = 3307;

$conn = new mysqli($sever, $user, $password, $database, $port);
if ($conn) {
    mysqli_query($conn, "SET NAMES 'utf8'");
} else {
    echo "Connection failed: " . $conn->connect_error;
    exit;
}
*/

// Xử lý xóa sản phẩm (GET request)
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM PRODUCT WHERE ID=$id");
    header("Location: qlsp.php");
    exit;
}

// Các danh mục hợp lệ
$valid_categories = ['Shirt', 'Accessories', 'Trousers'];

// Khai báo biến để lưu lỗi và dữ liệu cũ (để giữ giá trị form)
$errorMessages = [];
$oldData = [];
$modalType = ''; // 'add' hoặc 'edit'

// Xử lý submit form thêm/sửa (dựa vào method POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu chung từ form
    $name        = trim($_POST['name']);
    $price       = intval($_POST['price']);
    $img_url     = trim($_POST['img_url']);
    $number      = intval($_POST['number']);
    $decs        = trim($_POST['decs']);
    $category    = trim($_POST['category']);
    $top_product = intval($_POST['top_product']);

    // Lưu lại dữ liệu cũ để tái hiện lên form nếu có lỗi
    $oldData = [
        'name'        => $name,
        'price'       => $price,
        'img_url'     => $img_url,
        'number'      => $number,
        'decs'        => $decs,
        'category'    => $category,
        'top_product' => $top_product
    ];

    // Ràng buộc: Giá phải là số nguyên dương
    if ($price <= 0) {
        $errorMessages[] = "Giá phải là số nguyên dương.";
    }
    // Ràng buộc: Số lượng phải là số nguyên dương
    if ($number <= 0) {
        $errorMessages[] = "Số lượng phải là số nguyên dương.";
    }
    // Ràng buộc: Nếu đường dẫn ảnh không rỗng, phải là URL hợp lệ
    if (!empty($img_url) && !filter_var($img_url, FILTER_VALIDATE_URL)) {
        $errorMessages[] = "Đường dẫn ảnh không hợp lệ.";
    }
    // Ràng buộc: Danh mục phải là một trong các giá trị đã cho
    if (!in_array($category, $valid_categories)) {
        $errorMessages[] = "Danh mục phải là một trong: Shirt, Accessories, Trousers.";
    }

    // Nếu không có lỗi, tiến hành xử lý thêm hoặc sửa
    if (empty($errorMessages)) {
        // Escape dữ liệu trước khi đưa vào query
        $name     = $conn->real_escape_string($name);
        $img_url  = $conn->real_escape_string($img_url);
        $decs     = $conn->real_escape_string($decs);
        $category = $conn->real_escape_string($category);

        if (isset($_GET['action']) && $_GET['action'] == 'add') {
            $query = "INSERT INTO PRODUCT (NAME, PRICE, IMG_URL, NUMBER, DECS, CATEGORY, TOP_PRODUCT) 
                      VALUES ('$name', $price, '$img_url', $number, '$decs', '$category', $top_product)";
            $conn->query($query);
            header("Location: qlsp.php");
            exit;
        }
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $id = intval($_GET['id']);
            $query = "UPDATE PRODUCT SET 
                          NAME='$name', 
                          PRICE=$price, 
                          IMG_URL='$img_url', 
                          NUMBER=$number, 
                          DECS='$decs', 
                          CATEGORY='$category', 
                          TOP_PRODUCT=$top_product 
                      WHERE ID=$id";
            $conn->query($query);
            header("Location: qlsp.php");
            exit;
        }
    } else {
        // Nếu có lỗi, xác định modal cần hiển thị
        if (isset($_GET['action']) && $_GET['action'] == 'add') {
            $modalType = 'add';
        }
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $modalType = 'edit';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quản lý Sản phẩm</title>
    <style>
        /*
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5); / Nền mờ /
            display: none;
            z-index: 1000;
        }
        / Khi dùng hash, modal hiển thị qua :target /
        .modal:target {
            display: block;
        }
        / Nếu có lỗi, ta dùng inline style hiển thị modal (không cần hash) /
        .modal-content {
            background: #fff;
            margin: 10% auto;
            padding: 20px;
            width: 30%;
            border-radius: 8px;
            position: relative;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            text-decoration: none;
            color: #333;
        } */
        /* Nội dung trang chính */
        #page {
            transition: filter 0.3s ease;
        }
        /* Làm mờ trang chính khi modal hiện */
        #addModal:target ~ #page,
        #editModal:target ~ #page,
        .modal.show ~ #page {
            filter: blur(4px);
        }
        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center; 
        }
        th, td { 
            padding: 8px 12px;
            border: 1px solid #ccc; 
        }
        th { 
            background-color: #f4f4f4; 
        }
    </style>
</head>
<body>

    <?php
    // Nếu có lỗi, hiển thị alert bằng JavaScript
    if (!empty($errorMessages)) {
        $alertMsg = implode(" ", $errorMessages);
        echo "<script>alert('" . addslashes($alertMsg) . "');</script>";
    }
    ?>
    <!-- Modal cho Thêm Sản Phẩm -->
    <div id="addModal" class="modal" <?php if($modalType=='add' && !empty($errorMessages)) echo 'style="display:block;"'; ?>>
        <div class="modal-content">
            <a href="qlsp.php" class="close">&times;</a>
            <h2 style="margin-bottom: 13px;">Thêm Sản Phẩm</h2>
            <form method="post" action="qlsp.php?action=add">
                <label>Tên sản phẩm:</label><br>
                <input type="text" name="name" required value="<?php echo isset($oldData['name']) ? htmlspecialchars($oldData['name']) : ''; ?>"><br><br>
                
                <label>Giá:</label><br>
                <input type="number" name="price" required value="<?php echo isset($oldData['price']) ? htmlspecialchars($oldData['price']) : ''; ?>"><br><br>
                
                <label>Đường dẫn ảnh:</label><br>
                <input type="text" name="img_url" value="<?php echo isset($oldData['img_url']) ? htmlspecialchars($oldData['img_url']) : ''; ?>"><br><br>
                
                <label>Số lượng:</label><br>
                <input type="number" name="number" required value="<?php echo isset($oldData['number']) ? htmlspecialchars($oldData['number']) : ''; ?>"><br><br>
                
                <label>Mô tả:</label><br>
                <textarea name="decs"><?php echo isset($oldData['decs']) ? htmlspecialchars($oldData['decs']) : ''; ?></textarea><br><br>
                
                <label>Danh mục:</label><br>
                <select name="category" required>
                    <option value="">--Chọn danh mục--</option>
                    <option value="Shirt" <?php if(isset($oldData['category']) && $oldData['category']=='Shirt') echo 'selected'; ?>>Shirt</option>
                    <option value="Accessories" <?php if(isset($oldData['category']) && $oldData['category']=='Accessories') echo 'selected'; ?>>Accessories</option>
                    <option value="Trousers" <?php if(isset($oldData['category']) && $oldData['category']=='Trousers') echo 'selected'; ?>>Trousers</option>
                </select>
                <br><br>
                
                <label>Top sản phẩm:</label><br>
                <input type="number" name="top_product" value="<?php echo isset($oldData['top_product']) ? htmlspecialchars($oldData['top_product']) : ''; ?>"><br><br>
                
                <input type="submit" name="submit" value="Thêm sản phẩm" class="btn2">
            </form>
        </div>
    </div>

    <!-- Modal cho Sửa Sản Phẩm -->
    <?php
    // Nếu là edit, lấy dữ liệu sản phẩm cần sửa nếu không có lỗi, hoặc dùng dữ liệu cũ nếu có lỗi
    $editProduct = null;
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        if(empty($errorMessages) || $modalType != 'edit'){
            $id = intval($_GET['id']);
            $resultEdit = $conn->query("SELECT * FROM PRODUCT WHERE ID=$id");
            $editProduct = $resultEdit->fetch_assoc();
        } else {
            // Nếu có lỗi trong quá trình sửa, $oldData đã được lưu
            $editProduct = $oldData;
            $editProduct['ID'] = intval($_GET['id']);
        }
    }
    ?>
    <div id="editModal" class="modal" <?php if($modalType=='edit' && !empty($errorMessages)) echo 'style="display:block;"'; ?>>
        <div class="modal-content">
            <a href="qlsp.php" class="close">&times;</a>
            <h2>Sửa Sản Phẩm</h2>
            <?php if ($editProduct): ?>
            <form method="post" action="qlsp.php?action=edit&id=<?php echo isset($editProduct['ID']) ? $editProduct['ID'] : ''; ?>">
                <label>Tên sản phẩm:</label><br>
                <input type="text" name="name" required value="<?php echo isset($oldData['name']) ? htmlspecialchars($oldData['name']) : htmlspecialchars($editProduct['NAME']); ?>"><br><br>
                
                <label>Giá:</label><br>
                <input type="number" name="price" required value="<?php echo isset($oldData['price']) ? htmlspecialchars($oldData['price']) : htmlspecialchars($editProduct['PRICE']); ?>"><br><br>
                
                <label>Đường dẫn ảnh:</label><br>
                <input type="text" name="img_url" value="<?php echo isset($oldData['img_url']) ? htmlspecialchars($oldData['img_url']) : htmlspecialchars($editProduct['IMG_URL']); ?>"><br><br>
                
                <label>Số lượng:</label><br>
                <input type="number" name="number" required value="<?php echo isset($oldData['number']) ? htmlspecialchars($oldData['number']) : htmlspecialchars($editProduct['NUMBER']); ?>"><br><br>
                
                <label>Mô tả:</label><br>
                <textarea name="decs"><?php echo isset($oldData['decs']) ? htmlspecialchars($oldData['decs']) : htmlspecialchars($editProduct['DECS']); ?></textarea><br><br>
                
                <label>Danh mục:</label><br>
                <select name="category" required>
                    <option value="">--Chọn danh mục--</option>
                    <option value="Shirt" <?php 
                        $selected = (isset($oldData['category']) && $oldData['category']=='Shirt') || (!isset($oldData['category']) && $editProduct['CATEGORY']=='Shirt') ? 'selected' : '';
                        echo $selected;
                    ?>>Shirt</option>
                    <option value="Accessories" <?php 
                        $selected = (isset($oldData['category']) && $oldData['category']=='Accessories') || (!isset($oldData['category']) && $editProduct['CATEGORY']=='Accessories') ? 'selected' : '';
                        echo $selected;
                    ?>>Accessories</option>
                    <option value="Trousers" <?php 
                        $selected = (isset($oldData['category']) && $oldData['category']=='Trousers') || (!isset($oldData['category']) && $editProduct['CATEGORY']=='Trousers') ? 'selected' : '';
                        echo $selected;
                    ?>>Trousers</option>
                </select>
                <br><br>
                
                <label>Top sản phẩm:</label><br>
                <input type="number" name="top_product" value="<?php echo isset($oldData['top_product']) ? htmlspecialchars($oldData['top_product']) : htmlspecialchars($editProduct['TOP_PRODUCT']); ?>"><br><br>
                
                <input type="submit" name="submit" value="Cập nhật sản phẩm" class="btn2">
            </form>
            <?php else: ?>
                <p>Sản phẩm không tồn tại.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'employee_header.php'; ?>

    <!-- Nội dung trang chính -->
    <div id="page">
        <h1 class="title">Quản Lý Sản Phẩm</h1>
        <!-- Nút mở modal Thêm Sản Phẩm -->
        <a href="qlsp.php?action=add#addModal"><button class="btn_add">Thêm Sản Phẩm Mới</button></a>
        <table>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Số lượng</th>
                <th>Mô tả</th>
                <th>Danh mục</th>
                <th>Top sản phẩm</th>
                <th width="7.5%">Hành động</th>
            </tr>
            <?php 
            $result = $conn->query("SELECT * FROM PRODUCT ORDER BY ID ASC");
            while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['NAME']; ?></td>
                <td><?php echo $row['PRICE']; ?></td>
                <td>
                    <?php if($row['IMG_URL'] != ""): ?>
                        <img src="<?php echo $row['IMG_URL']; ?>" alt="<?php echo $row['NAME']; ?>" width="50" height="50">
                    <?php endif; ?>
                </td>
                <td><?php echo $row['NUMBER']; ?></td>
                <td><?php echo $row['DECS']; ?></td>
                <td><?php echo $row['CATEGORY']; ?></td>
                <td><?php echo $row['TOP_PRODUCT']; ?></td>
                <td>
                    <!-- Nút mở modal Sửa Sản Phẩm -->
                    <a href="qlsp.php?action=edit&id=<?php echo $row['ID']; ?>#editModal"><button class="btn_edit">Sửa</button></a>
                    <a href="qlsp.php?action=delete&id=<?php echo $row['ID']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"><button class="btn_delete">Xóa</button></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <link rel="stylesheet" href="./assets/css/admin_style.css">
    <?php
    include 'admin_footer.php';
    ?>
</body>
</html>
<?php
$conn->close();
?>