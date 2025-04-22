<?php
session_start();
include 'connect.php';

// Xử lý xóa sản phẩm (GET request)
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM PRODUCT WHERE ID=$id");
    header("Location: qlsp.php");
    exit;
}

// Khai báo biến để lưu lỗi và dữ liệu cũ (để giữ giá trị form)
$errorMessages = [];
$oldData = [];
$modalType = ''; // 'add' hoặc 'edit'

// Lấy danh sách danh mục từ bảng CATEGORY
$categories = $conn->query("SELECT id, name_category FROM CATEGORY WHERE state = 1");

// Xử lý submit form thêm/sửa (dựa vào method POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu chung từ form
    $name        = trim($_POST['name']);
    $price       = intval($_POST['price']);
    $img_url     = trim($_POST['img_url']);
    $number      = intval($_POST['number']);
    $decs        = trim($_POST['decs']);
    $category    = intval($_POST['category']);
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
    // Ràng buộc: Danh mục phải tồn tại trong bảng CATEGORY
    $validCategory = $conn->query("SELECT id FROM CATEGORY WHERE id = $category AND state = 1");
    if ($validCategory->num_rows == 0) {
        $errorMessages[] = "Danh mục không hợp lệ.";
    }

    // Nếu không có lỗi, tiến hành xử lý thêm hoặc sửa
    if (empty($errorMessages)) {
        // Escape dữ liệu trước khi đưa vào query
        $name     = $conn->real_escape_string($name);
        $img_url  = $conn->real_escape_string($img_url);
        $decs     = $conn->real_escape_string($decs);

        if (isset($_GET['action']) && $_GET['action'] == 'add') {
            $query = "INSERT INTO PRODUCT (NAME, PRICE, IMG_URL, NUMBER, DECS, CATEGORY, TOP_PRODUCT) 
                      VALUES ('$name', $price, '$img_url', $number, '$decs', $category, $top_product)";
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
                          CATEGORY=$category, 
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
        #page {
            transition: filter 0.3s ease;
        }
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
                    <?php while ($category = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $category['id']; ?>" 
                            <?php if (isset($oldData['category']) && $oldData['category'] == $category['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($category['name_category']); ?>
                        </option>
                    <?php endwhile; ?>
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
                    <?php
                    $categories = $conn->query("SELECT id, name_category FROM CATEGORY WHERE state = 1");
                    while ($category = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $category['id']; ?>" 
                            <?php if ((isset($oldData['category']) && $oldData['category'] == $category['id']) || 
                                      (!isset($oldData['category']) && $editProduct['CATEGORY'] == $category['id'])) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($category['name_category']); ?>
                        </option>
                    <?php endwhile; ?>
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
            $result = $conn->query("
                SELECT p.ID, p.NAME, p.PRICE, p.IMG_URL, p.NUMBER, p.DECS, c.name_category AS CATEGORY, p.TOP_PRODUCT 
                FROM PRODUCT p
                LEFT JOIN CATEGORY c ON p.CATEGORY = c.id
                ORDER BY p.ID ASC
            ");
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