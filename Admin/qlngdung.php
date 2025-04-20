<?php
session_start();
include 'connect.php';

// Xử lý xóa tài khoản (GET request)
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM account WHERE ID=$id");
    header("Location: qlngdung.php");
    exit;
}

// Khai báo biến để lưu lỗi và dữ liệu cũ (để giữ giá trị form)
$errorMessages = [];
$oldData = [];
$modalType = ''; // 'add' hoặc 'edit'

// Xử lý submit form thêm/sửa (dựa vào method POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu chung từ form
    $fname     = trim($_POST['fname']);
    $phone     = trim($_POST['phone']);
    $address   = trim($_POST['address']);
    $username  = trim($_POST['username']);
    $pwd       = trim($_POST['pwd']);
    $img_url   = trim($_POST['img_url']);
    $rank      = intval($_POST['rank']);
    $email     = trim($_POST['email']);

    // Lưu lại dữ liệu cũ để tái hiện lên form nếu có lỗi
    $oldData = [
        'fname'    => $fname,
        'phone'    => $phone,
        'address'  => $address,
        'username' => $username,
        'pwd'      => $pwd,
        'img_url'  => $img_url,
        'rank'     => $rank,
        'email'    => $email
    ];

    // Ràng buộc: Các trường không được để trống
    if (empty($fname) || empty($phone) || empty($address) || empty($username) || empty($pwd) || empty($email)) {
        $errorMessages[] = "Tất cả các trường bắt buộc phải được điền.";
    }
    // Ràng buộc: Email phải hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages[] = "Email không hợp lệ.";
    }
    // Ràng buộc: Nếu đường dẫn ảnh không rỗng, phải là URL hợp lệ
    if (!empty($img_url) && !filter_var($img_url, FILTER_VALIDATE_URL)) {
        $errorMessages[] = "Đường dẫn ảnh không hợp lệ.";
    }

    // Nếu không có lỗi, tiến hành xử lý thêm hoặc sửa
    if (empty($errorMessages)) {
        // Escape dữ liệu trước khi đưa vào query
        $fname    = $conn->real_escape_string($fname);
        $phone    = $conn->real_escape_string($phone);
        $address  = $conn->real_escape_string($address);
        $username = $conn->real_escape_string($username);
        $pwd      = $conn->real_escape_string($pwd);
        $img_url  = $conn->real_escape_string($img_url);
        $email    = $conn->real_escape_string($email);

        if (isset($_GET['action']) && $_GET['action'] == 'add') {
            $query = "INSERT INTO account (FNAME, PHONE, ADDRESS, USERNAME, PWD, IMG_URL, RANK, EMAIL) 
                      VALUES ('$fname', '$phone', '$address', '$username', '$pwd', '$img_url', $rank, '$email')";
            if ($conn->query($query)) {
                echo "<script>alert('Thêm thông tin người dùng thành công');</script>";
                header("Location: qlngdung.php");
            }
            exit;
        }
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $id = intval($_GET['id']);
            $query = "UPDATE account SET 
                          FNAME='$fname', 
                          PHONE='$phone', 
                          ADDRESS='$address', 
                          USERNAME='$username', 
                          PWD='$pwd', 
                          IMG_URL='$img_url', 
                          RANK=$rank, 
                          EMAIL='$email' 
                      WHERE ID=$id";
            if ($conn->query($query)) {
                echo "<script>alert('Sửa thông tin người dùng thành công');</script>";
                header("Location: qlngdung.php");
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
    <title>Quản lý Người dùng</title>
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
    <!--
    <div id="addModal" class="modal" <?php if($modalType=='add' && !empty($errorMessages)) echo 'style="display:block;"'; ?>>
        <div class="modal-content">
            <a href="qlngdung.php" class="close">&times;</a>
            <h2>Thêm Người dùng</h2>
            <form method="post" action="qlngdung.php?action=add">
                <label>Họ và tên:</label><br>
                <input type="text" name="fname" required value="<?php echo isset($oldData['fname']) ? htmlspecialchars($oldData['fname']) : ''; ?>"><br><br>
                
                <label>Số điện thoại:</label><br>
                <input type="text" name="phone" required value="<?php echo isset($oldData['phone']) ? htmlspecialchars($oldData['phone']) : ''; ?>"><br><br>
                
                <label>Địa chỉ:</label><br>
                <input type="text" name="address" required value="<?php echo isset($oldData['address']) ? htmlspecialchars($oldData['address']) : ''; ?>"><br><br>
                
                <label>Tên đăng nhập:</label><br>
                <input type="text" name="username" required value="<?php echo isset($oldData['username']) ? htmlspecialchars($oldData['username']) : ''; ?>"><br><br>
                
                <label>Mật khẩu:</label><br>
                <input type="password" name="pwd" required value="<?php echo isset($oldData['pwd']) ? htmlspecialchars($oldData['pwd']) : ''; ?>"><br><br>
                
                <label>Đường dẫn ảnh:</label><br>
                <input type="text" name="img_url" value="<?php echo isset($oldData['img_url']) ? htmlspecialchars($oldData['img_url']) : ''; ?>"><br><br>
                
                <label>Rank:</label><br>
                <input type="number" name="rank" required value="<?php echo isset($oldData['rank']) ? htmlspecialchars($oldData['rank']) : ''; ?>"><br><br>
                
                <label>Email:</label><br>
                <input type="email" name="email" required value="<?php echo isset($oldData['email']) ? htmlspecialchars($oldData['email']) : ''; ?>"><br><br>
                
                <input type="submit" name="submit" value="Thêm người dùng">
            </form>
        </div>
    </div>
    -->

    <!-- Modal cho Sửa Người dùng -->
    <?php
    $editUser = null;
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        if(empty($errorMessages) || $modalType != 'edit'){
            $id = intval($_GET['id']);
            $resultEdit = $conn->query("SELECT * FROM account WHERE ID=$id");
            $editUser = $resultEdit->fetch_assoc();
        } else {
            $editUser = $oldData;
            $editUser['ID'] = intval($_GET['id']);
        }
    }
    ?>
    <div id="editModal" class="modal" <?php if($modalType=='edit' && !empty($errorMessages)) echo 'style="display:block;"'; ?>>
        <div class="modal-content">
            <a href="qlngdung.php" class="close">&times;</a>
            <h2 margin-bottom: 13px;>Sửa thông tin</h2>
            <?php if ($editUser): ?>
            <form method="post" action="qlngdung.php?action=edit&id=<?php echo isset($editUser['ID']) ? $editUser['ID'] : ''; ?>">
                <label>Họ và tên:</label><br>
                <input type="text" name="fname" required value="<?php echo isset($oldData['fname']) ? htmlspecialchars($oldData['fname']) : htmlspecialchars($editUser['FNAME']); ?>"><br><br>
                
                <label>Số điện thoại:</label><br>
                <input type="text" name="phone" required value="<?php echo isset($oldData['phone']) ? htmlspecialchars($oldData['phone']) : htmlspecialchars($editUser['PHONE']); ?>"><br><br>
                
                <label>Địa chỉ:</label><br>
                <input type="text" name="address" required value="<?php echo isset($oldData['address']) ? htmlspecialchars($oldData['address']) : htmlspecialchars($editUser['ADDRESS']); ?>"><br><br>
                
                <label>Tên đăng nhập:</label><br>
                <input type="text" name="username" required value="<?php echo isset($oldData['username']) ? htmlspecialchars($oldData['username']) : htmlspecialchars($editUser['USERNAME']); ?>"><br><br>
                
                <label>Mật khẩu:</label><br>
                <input type="password" name="pwd" required value="<?php echo isset($oldData['pwd']) ? htmlspecialchars($oldData['pwd']) : htmlspecialchars($editUser['PWD']); ?>"><br><br>
                
                <label>Đường dẫn ảnh:</label><br>
                <input type="text" name="img_url" value="<?php echo isset($oldData['img_url']) ? htmlspecialchars($oldData['img_url']) : htmlspecialchars($editUser['IMG_URL']); ?>"><br><br>
                
                <label>Rank:</label><br>
                <input type="number" name="rank" required value="<?php echo isset($oldData['rank']) ? htmlspecialchars($oldData['rank']) : htmlspecialchars($editUser['RANK']); ?>"><br><br>
                
                <label>Email:</label><br>
                <input type="email" name="email" required value="<?php echo isset($oldData['email']) ? htmlspecialchars($oldData['email']) : htmlspecialchars($editUser['EMAIL']); ?>"><br><br>
                
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
        <h1 class="title">Quản lý tài khoản người dùng</h1>
        <!-- Nút mở modal Thêm Người dùng -->
        <!-- <a href="qlngdung.php?action=add#addModal"><button class="btn_add">Thêm Người dùng Mới</button></a> -->
        <table>
            <tr>
                <th>ID</th>
                <th>Họ và tên</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Rank</th>
                <th>Ảnh</th>
                <th width="7.5%">Hành động</th>
            </tr>
            <?php 
            $result = $conn->query("SELECT * FROM account ORDER BY ID ASC");
            while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['FNAME']; ?></td>
                <td><?php echo $row['PHONE']; ?></td>
                <td><?php echo $row['ADDRESS']; ?></td>
                <td><?php echo $row['USERNAME']; ?></td>
                <td><?php echo $row['EMAIL']; ?></td>
                <td><?php echo $row['RANK']; ?></td>
                <td>
                    <?php if($row['IMG_URL'] != ""): ?>
                        <img src="<?php echo $row['IMG_URL']; ?>" alt="<?php echo $row['FNAME']; ?>" width="50" height="50">
                    <?php endif; ?>
                </td>
                <td>
                    <!-- Nút mở modal Sửa Người dùng -->
                    <a href="qlngdung.php?action=edit&id=<?php echo $row['ID']; ?>#editModal"><button class="btn_edit">Sửa</button></a>
                    <a href="qlngdung.php?action=delete&id=<?php echo $row['ID']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');"><button class="btn_delete">Xóa</button></a>
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