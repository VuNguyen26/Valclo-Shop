<?php
session_start();
include 'connect.php';

// Xử lý xóa tài khoản (GET request)
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM employee_account WHERE ID=$id");
    header("Location: qlnv.php");
    exit;
}

// Khai báo biến để lưu lỗi và dữ liệu cũ (để giữ giá trị form)
$errorMessages = [];
$oldData = [];
$modalType = ''; // 'add' hoặc 'edit'

// Xử lý submit form thêm/sửa (dựa vào method POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu chung từ form
    $name     = trim($_POST['name']);
    $username  = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Lưu lại dữ liệu cũ để tái hiện lên form nếu có lỗi
    $oldData = [
        'name'    => $name,
        'username' => $username,
        'password'      => $password
    ];

    // Ràng buộc: Các trường không được để trống
    if (empty($name)|| empty($username) || empty($password)) {
        $errorMessages[] = "Tất cả các trường bắt buộc phải được điền.";
    }

    // Nếu không có lỗi, tiến hành xử lý thêm hoặc sửa
    if (empty($errorMessages)) {
        // Escape dữ liệu trước khi đưa vào query
        $name    = $conn->real_escape_string($name);
        $username = $conn->real_escape_string($username);
        $password      = $conn->real_escape_string($password);

        if (isset($_GET['action']) && $_GET['action'] == 'add') {
            $query = "INSERT INTO employee_account (NAME, USERNAME, PASSWORD) 
                      VALUES ('$name', '$username', '$password')";
            if ($conn->query($query)) {
                echo "<script>alert('Thêm thông tin nhân viên thành công');</script>";
                header("Location: qlnv.php");
            }
            exit;
        }
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $id = intval($_GET['id']);
            $query = "UPDATE employee_account SET 
                          NAME='$name', 
                          USERNAME='$username', 
                          PASSWORD='$password'
                      WHERE ID=$id";
            if ($conn->query($query)) {
                echo "<script>alert('Sửa thông tin nhân viên thành công');</script>";
                header("Location: qlnv.php");
            }
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
    <title>Quản lý Nhân Viên</title>
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

    <!-- Modal cho Thêm Người dùng -->
    <div id="addModal" class="modal" <?php if($modalType=='add' && !empty($errorMessages)) echo 'style="display:block;"'; ?>>
        <div class="modal-content">
            <a href="qlnv.php" class="close">&times;</a>
            <h2>Thêm Tài khoản Nhân viên</h2>
            <form method="post" action="qlnv.php?action=add">
                <label>Họ và tên:</label><br>
                <input type="text" name="name" required value="<?php echo isset($oldData['name']) ? htmlspecialchars($oldData['name']) : ''; ?>"><br><br>
                
                <label>Tên đăng nhập:</label><br>
                <input type="text" name="username" required value="<?php echo isset($oldData['username']) ? htmlspecialchars($oldData['username']) : ''; ?>"><br><br>
                
                <label>Mật khẩu:</label><br>
                <input type="password" name="password" required value="<?php echo isset($oldData['password']) ? htmlspecialchars($oldData['password']) : ''; ?>"><br><br>
    
                <input type="submit" name="submit" value="Thêm người dùng" class="btn2">
            </form>
        </div>
    </div>

    <!-- Modal cho Sửa Người dùng -->
    <?php
    $editUser = null;
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        if(empty($errorMessages) || $modalType != 'edit'){
            $id = intval($_GET['id']);
            $resultEdit = $conn->query("SELECT * FROM employee_account WHERE ID=$id");
            $editUser = $resultEdit->fetch_assoc();
        } else {
            $editUser = $oldData;
            $editUser['ID'] = intval($_GET['id']);
        }
    }
    ?>
    <div id="editModal" class="modal" <?php if($modalType=='edit' && !empty($errorMessages)) echo 'style="display:block;"'; ?>>
        <div class="modal-content">
            <a href="qlnv.php" class="close">&times;</a>
            <h2>Sửa thông tin</h2>
            <?php if ($editUser): ?>
            <form method="post" action="qlnv.php?action=edit&id=<?php echo isset($editUser['ID']) ? $editUser['ID'] : ''; ?>">
                <label>Họ và tên:</label><br>
                <input type="text" name="name" required value="<?php echo isset($oldData['name']) ? htmlspecialchars($oldData['name']) : htmlspecialchars($editUser['NAME']); ?>"><br><br>
                
                <label>Tên đăng nhập:</label><br>
                <input type="text" name="username" required value="<?php echo isset($oldData['username']) ? htmlspecialchars($oldData['username']) : htmlspecialchars($editUser['USERNAME']); ?>"><br><br>
                
                <label>Mật khẩu:</label><br>
                <input type="password" name="password" required value="<?php echo isset($oldData['password']) ? htmlspecialchars($oldData['password']) : htmlspecialchars($editUser['PASSWORD']); ?>"><br><br>
                
                <input type="submit" name="submit" value="Cập nhật thông tin" class="btn2">
            </form>
            <?php else: ?>
                <p>Người dùng không tồn tại.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'admin_header.php'; ?>
    
    <main>
    <!-- Nội dung trang chính -->
    <div id="page">
        <h1 class="title">Quản lý Tài khoản Nhân Viên</h1>
        <!-- Nút mở modal Thêm Người dùng -->
        <a href="qlnv.php?action=add#addModal"><button class="btn_add">Thêm Nhân Viên Mới</button></a>
        <table>
            <tr>
                <th>ID</th>
                <th>Họ và tên</th>
                <th>Tên đăng nhập</th>
                <th>Mật Khẩu</th>
                <th width="7.5%">Hành động</th>
            </tr>
            <?php 
            $result = $conn->query("SELECT * FROM employee_account ORDER BY ID ASC");
            while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['NAME']; ?></td>
                <td><?php echo $row['USERNAME']; ?></td>
                <td><?php echo $row['PASSWORD']; ?></td>
                <td>
                    <!-- Nút mở modal Sửa Người dùng -->
                    <a href="qlnv.php?action=edit&id=<?php echo $row['ID']; ?>#editModal"><button class="btn_edit">Sửa</button></a>
                    <a href="qlnv.php?action=delete&id=<?php echo $row['ID']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');"><button class="btn_delete">Xóa</button></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <link rel="stylesheet" href="./assets/css/admin_style.css">

    </main>

    <?php
    include 'admin_footer.php';
    ?>
</body>
</html>
<?php
$conn->close();
?>