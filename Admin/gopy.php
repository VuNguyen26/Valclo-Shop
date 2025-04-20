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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Góp ý của khách hàng</title>
        <style>
            table { border-collapse: collapse; width: 100%; }
            th, td { padding: 8px 12px; border: 1px solid #ccc; text-align: center; }
            th { background-color: #f4f4f4; }
        </style>
        <link rel="stylesheet" href="./assets/css/admin_style.css">
    </head>
    <body>
        <?php include 'admin_header.php'; ?>
        <main>
        <div>
            <h1 class="title">Góp ý của khách hàng</h1>
            <table>
                <tr>
                    <th>Mã Feedback</th>
                    <th>Tên khách hàng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Chủ đề</th>
                    <th>Lời nhắn</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM MESSAGE ORDER BY ID ASC");
                while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo $row['FNAME']; ?></td>
                    <td><?php echo $row['EMAIL']; ?></td>
                    <td><?php echo $row['PHONE']; ?></td>
                    <th><?php echo $row['SUBJECT']; ?></th>
                    <th><?php echo $row['CONTENT']; ?></th>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        </main>
        <?php include 'admin_footer.php'; ?>
    </body>
</html>
<?php
$conn->close();
?>