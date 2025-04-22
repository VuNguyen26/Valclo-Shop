<?php
session_start();
include 'connect.php';

/* --- XỬ LÝ CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG --- */
if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = intval($_GET['id']);
    $new_status = $_GET['status'];

    // Lấy trạng thái hiện tại của đơn hàng
    $result = $conn->query("SELECT STATUS FROM `ORDER` WHERE ID = $order_id");
    if ($result && $row = $result->fetch_assoc()) {
        $current_status = $row['STATUS'];
        $allowed = false;
        // Ràng buộc chuyển trạng thái:
        if ($current_status === 'Chờ xác nhận' && ($new_status === 'Đã xác nhận' || $new_status === 'Cửa hàng hủy')) {
            $allowed = true;
        } elseif ($current_status === 'Đã xác nhận' && $new_status === 'Đang giao') {
            $allowed = true;
        } elseif ($current_status === 'Đang giao' && $new_status === 'Đã giao') {
            $allowed = true;
        }
        if ($allowed) {
            $new_status = $conn->real_escape_string($new_status);
            $conn->query("UPDATE `ORDER` SET STATUS='$new_status' WHERE ID=$order_id");
        }
    }
    header("Location: qldonhang.php");
    exit;
}

/* --- LẤY DANH SÁCH ĐƠN HÀNG --- */
// Lấy tất cả đơn hàng rồi lưu vào mảng để dùng lại cho bảng và modal
$orders = [];
$resultOrders = $conn->query("SELECT * FROM `ORDER` ORDER BY ID ASC");
if ($resultOrders) {
    while ($row = $resultOrders->fetch_assoc()) {
        $orders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đơn hàng</title>
    <style>
        #page {
            transition: filter 0.3s ease;
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
        /* Modal hiển thị chi tiết đơn hàng 
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px; 
        }
        .close {
            float: right;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            text-decoration: none;
        }
            */
    </style>
    <script>
        // Hàm mở modal: truyền vào id modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
            document.getElementById("page").style.filter = "blur(4px)";
        }
        // Hàm đóng modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
            document.getElementById("page").style.filter = "none";
        }
        // Đóng modal khi nhấp ngoài vùng modal
        window.onclick = function(event) {
            var modals = document.getElementsByClassName("modal");
            for(var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = "none";
                    document.getElementById("page").style.filter = "none";
                }
            }
        }
        // Hàm chuyển trạng thái đơn hàng khi thay đổi giá trị combobox
        function changeStatus(orderId, selectObj) {
            var newStatus = selectObj.value;
            if(newStatus !== '') {
                // Chuyển sang URL update (GET) để xử lý
                window.location.href = "qldonhang.php?action=update&id=" + orderId + "&status=" + encodeURIComponent(newStatus);
            }
        }
    </script>
</head>
<body>
    <?php include 'employee_header.php'; ?>

    <main>
        <div id="page">
            <h1 class="title">Quản lý Đơn hàng</h1>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Mã khách hàng</th>
                    <th>Thời gian</th>
                    <th>Tổng tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
                <?php foreach($orders as $order): ?>
                <tr class="order-row">
                    <td><?php echo $order['ID']; ?></td>
                    <td><?php echo $order['UID']; ?></td>
                    <td><?php echo $order['TIME']; ?></td>
                    <td><?php echo $order['TOTAL_PRICE']; ?></td>
                    <td><?php echo $order['METHOD']; ?></td>
                    <td><?php echo $order['STATUS']; ?></td>
                    <td>
                        <select onchange="changeStatus(<?php echo $order['ID']; ?>, this)"
                            <?php if(in_array($order['STATUS'], ['Đã giao', 'Khách hàng hủy', 'Cửa hàng hủy'])) echo 'disabled'; ?>>
                            <option value="">Chọn trạng thái</option>
                            <?php
                                $currentStatus = $order['STATUS'];
                                // Ràng buộc các lựa chọn theo trạng thái hiện tại
                                if($currentStatus == 'Chờ xác nhận'){
                                    echo '<option value="Đã xác nhận">Đã xác nhận</option>';
                                    echo '<option value="Cửa hàng hủy">Cửa hàng hủy</option>';
                                } elseif($currentStatus == 'Đã xác nhận'){
                                    echo '<option value="Đang giao">Đang giao</option>';
                                } elseif($currentStatus == 'Đang giao'){
                                    echo '<option value="Đã giao">Đã giao</option>';
                                }
                            ?>
                        </select>
                        <button onclick="openModal('modal_<?php echo $order['ID']; ?>')" class="btn2">Xem chi tiết đơn hàng</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Tạo modal cho từng đơn hàng -->
        <?php foreach($orders as $order):
            $orderId = $order['ID'];
            // Truy vấn lấy chi tiết đơn hàng: giả sử bảng PRODUCT có cột NAME để hiển thị tên sản phẩm
            $queryDetails = "SELECT od.*, p.NAME AS PRODUCT_NAME,p.IMG_URL
                             FROM ORDER_DETAIL od 
                             LEFT JOIN PRODUCT p ON od.PID = p.ID 
                             WHERE od.ORDER_ID = $orderId";
            $resultDetails = $conn->query($queryDetails);
        ?>
        <div id="modal_<?php echo $orderId; ?>" class="modal">
            <div class="modal-content">
                <a href="javascript:void(0)" class="close" onclick="closeModal('modal_<?php echo $orderId; ?>')">&times;</a>
                <h2 style="margin-bottom: 13px;">Chi tiết Đơn hàng #<?php echo $orderId; ?></h2>
                <table>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Size</th>
                        <th>Số lượng</th>
                    </tr>
                    <?php if ($resultDetails && $resultDetails->num_rows > 0): ?>
                        <?php while($detail = $resultDetails->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $detail['PRODUCT_NAME'] ? $detail['PRODUCT_NAME'] : $detail['PID']; ?></td>
                            <td>
                                <img src="<?php echo $detail['IMG_URL']; ?>" alt="Hình ảnh sản phẩm" style="max-width: 40px; border-radius: 8px;">
                            </td>
                            <td><?php echo $detail['SIZE']; ?></td>
                            <td><?php echo $detail['QUANTITY']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Không có chi tiết cho đơn hàng này.</td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
        <?php endforeach; ?>

        <link rel="stylesheet" href="./assets/css/admin_style.css">
    </main>

    <?php include 'admin_footer.php'; ?>
</body>
</html>
<?php
$conn->close();
?>
