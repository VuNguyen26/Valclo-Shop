<?php
session_start();
include 'connect.php';

/* --- XỬ LÝ CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG --- */
$messages = []; // Mảng lưu trữ thông báo
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
            if ($conn->query("UPDATE `ORDER` SET STATUS='$new_status' WHERE ID=$order_id")) {
                $messages[] = ['text' => 'Cập nhật trạng thái đơn hàng thành công!', 'type' => 'success'];
            } else {
                $messages[] = ['text' => 'Lỗi khi cập nhật trạng thái: ' . $conn->error, 'type' => 'danger'];
            }
        } else {
            $messages[] = ['text' => 'Không thể chuyển trạng thái từ "' . $current_status . '" sang "' . $new_status . '"!', 'type' => 'danger'];
        }
    } else {
        $messages[] = ['text' => 'Không tìm thấy đơn hàng!', 'type' => 'danger'];
    }
}

/* --- XỬ LÝ LỌC ĐƠN HÀNG --- */
$filters = [];
$whereClauses = [];
$errorMessage = '';

// Lọc theo khoảng thời gian (vẫn submit form)
$from_date = isset($_POST['from_date']) && !empty($_POST['from_date']) ? $conn->real_escape_string($_POST['from_date']) : '';
$to_date = isset($_POST['to_date']) && !empty($_POST['to_date']) ? $conn->real_escape_string($_POST['to_date']) : '';

if ($from_date || $to_date) { // Nếu có ít nhất một ngày được chọn
    if (!empty($from_date) && !empty($to_date)) {
        // Cả hai ngày đều được chọn, áp dụng bộ lọc thời gian
        $whereClauses[] = "DATE(TIME) BETWEEN '$from_date' AND '$to_date'";
        $filters['from_date'] = $from_date;
        $filters['to_date'] = $to_date;
    } else {
        // Chỉ một trong hai ngày được chọn, hiển thị thông báo lỗi
        $errorMessage = "Vui lòng chọn cả ngày bắt đầu và ngày kết thúc để lọc theo thời gian.";
    }
}

// Xây dựng truy vấn SQL ban đầu (sẽ được xử lý qua AJAX cho trạng thái)
$query = "SELECT * FROM `ORDER`";
if (!empty($whereClauses)) {
    $query .= " WHERE " . implode(" AND ", $whereClauses);
}
$query .= " ORDER BY ID ASC";

/* --- LẤY DANH SÁCH ĐƠN HÀNG BAN ĐẦU --- */
$orders = [];
$resultOrders = $conn->query($query);
if ($resultOrders) {
    while ($row = $resultOrders->fetch_assoc()) {
        $orders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn hàng</title>
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
        .btn-secondary, .btn-success {
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
            padding-right: 30px;
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
            <h2 class="mb-4 text-primary"><i class="fas fa-shopping-cart me-2"></i>Quản lý Đơn hàng</h2>

            <!-- Form lọc đơn hàng -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-filter me-2"></i>Lọc Đơn hàng</div>
                <div class="card-body">
                    <?php if (!empty($errorMessage)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($errorMessage); ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" id="filterForm" class="filter-form mb-4">
                        <div class="row g-3">
                            <!-- Lọc theo trạng thái (sử dụng AJAX) -->
                            <div class="col-md-3">
                                <label for="status" class="form-label">Tình trạng đơn hàng:</label>
                                <select class="form-select" id="status" name="status" onchange="filterOrders()">
                                    <option value="">Tất cả</option>
                                    <option value="Chờ xác nhận" <?php echo isset($filters['status']) && $filters['status'] == 'Chờ xác nhận' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                    <option value="Đã xác nhận" <?php echo isset($filters['status']) && $filters['status'] == 'Đã xác nhận' ? 'selected' : ''; ?>>Đã xác nhận</option>
                                    <option value="Đang giao" <?php echo isset($filters['status']) && $filters['status'] == 'Đang giao' ? 'selected' : ''; ?>>Đang giao</option>
                                    <option value="Đã giao" <?php echo isset($filters['status']) && $filters['status'] == 'Đã giao' ? 'selected' : ''; ?>>Đã giao</option>
                                    <option value="Cửa hàng hủy" <?php echo isset($filters['status']) && $filters['status'] == 'Cửa hàng hủy' ? 'selected' : ''; ?>>Cửa hàng hủy</option>
                                    <option value="Khách hàng hủy" <?php echo isset($filters['status']) && $filters['status'] == 'Khách hàng hủy' ? 'selected' : ''; ?>>Khách hàng hủy</option>
                                </select>
                            </div>

                            <!-- Lọc theo khoảng thời gian -->
                            <div class="col-md-3">
                                <label for="from_date" class="form-label">Từ ngày:</label>
                                <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo isset($filters['from_date']) ? htmlspecialchars($filters['from_date']) : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="to_date" class="form-label">Đến ngày:</label>
                                <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo isset($filters['to_date']) ? htmlspecialchars($filters['to_date']) : ''; ?>">
                            </div>

                            <!-- Nút lọc và reset -->
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2"><i class="fas fa-filter me-1"></i>Lọc</button>
                                <a href="qldonhang.php" class="btn btn-secondary"><i class="fas fa-undo me-1"></i>Xóa bộ lọc</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danh sách đơn hàng -->
            <div class="card">
                <div class="card-header"><i class="fas fa-table me-2"></i>Danh sách Đơn hàng</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mã khách hàng</th>
                                    <th>Thời gian</th>
                                    <th>Tổng tiền</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="order-table">
                                <?php if (empty($orders)): ?>
                                    <tr><td colspan="7" class="text-center">Không tìm thấy đơn hàng nào.</td></tr>
                                <?php else: ?>
                                    <?php foreach($orders as $order): ?>
                                    <tr class="order-row">
                                        <td><?php echo $order['ID']; ?></td>
                                        <td><?php echo $order['UID']; ?></td>
                                        <td><?php echo $order['TIME']; ?></td>
                                        <td><?php echo number_format($order['TOTAL_PRICE'], 0, ',', '.') . ' VND'; ?></td>
                                        <td><?php echo $order['METHOD']; ?></td>
                                        <td><?php echo $order['STATUS']; ?></td>
                                        <td class="action-buttons">
                                            <select class="form-select d-inline-block w-auto" onchange="changeStatus(<?php echo $order['ID']; ?>, this)"
                                                <?php if(in_array($order['STATUS'], ['Đã giao', 'Khách hàng hủy', 'Cửa hàng hủy'])) echo 'disabled'; ?>>
                                                <option value="">Chọn trạng thái</option>
                                                <?php
                                                    $currentStatus = $order['STATUS'];
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
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $order['ID']; ?>">
                                                <i class="fas fa-eye me-1"></i>Xem chi tiết
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="error-message" class="error-message"></div>
                </div>
            </div>

            <!-- Modal cho từng đơn hàng -->
            <?php foreach($orders as $order):
                $orderId = $order['ID'];
                $queryDetails = "SELECT od.*, p.NAME AS PRODUCT_NAME, p.IMG_URL
                                 FROM ORDER_DETAIL od 
                                 LEFT JOIN PRODUCT p ON od.PID = p.ID 
                                 WHERE od.ORDER_ID = $orderId";
                $resultDetails = $conn->query($queryDetails);
            ?>
            <div class="modal fade" id="modal_<?php echo $orderId; ?>" tabindex="-1" aria-labelledby="modalLabel_<?php echo $orderId; ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel_<?php echo $orderId; ?>"><i class="fas fa-info-circle me-2"></i>Chi tiết Đơn hàng #<?php echo $orderId; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Hình ảnh</th>
                                            <th>Size</th>
                                            <th>Số lượng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($resultDetails && $resultDetails->num_rows > 0): ?>
                                            <?php while($detail = $resultDetails->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $detail['PRODUCT_NAME'] ? htmlspecialchars($detail['PRODUCT_NAME']) : $detail['PID']; ?></td>
                                                <td>
                                                    <?php if($detail['IMG_URL']): ?>
                                                        <?php
                                                        // Kiểm tra nếu IMG_URL là URL trực tuyến (http:// hoặc https://)
                                                        if (preg_match('/^(http:\/\/|https:\/\/)/', $detail['IMG_URL'])) {
                                                            $imageSrc = htmlspecialchars($detail['IMG_URL']);
                                                        } else {
                                                            $imageSrc = '/Valclo-Shop/' . htmlspecialchars($detail['IMG_URL']);
                                                        }
                                                        ?>
                                                        <img src="<?php echo $imageSrc; ?>" alt="Hình ảnh sản phẩm" style="max-width: 40px; border-radius: 8px;">
                                                    <?php else: ?>
                                                        N/A
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($detail['SIZE']); ?></td>
                                                <td><?php echo htmlspecialchars($detail['QUANTITY']); ?></td>
                                            </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr><td colspan="4" class="text-center">Không có chi tiết cho đơn hàng này.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

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

        function changeStatus(orderId, selectObj) {
            var newStatus = selectObj.value;
            if(newStatus !== '') {
                window.location.href = "qldonhang.php?action=update&id=" + orderId + "&status=" + encodeURIComponent(newStatus);
            }
        }

        // Hàm lọc đơn hàng theo trạng thái qua AJAX
        function filterOrders() {
            const status = document.getElementById('status').value;
            fetch('filter_orders.php?status=' + encodeURIComponent(status))
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
                    const tbody = document.querySelector('#order-table');
                    tbody.innerHTML = ''; // Xóa nội dung cũ

                    if (data.orders.length > 0) {
                        data.orders.forEach(order => {
                            const row = document.createElement('tr');
                            row.className = 'order-row';
                            row.innerHTML = `
                                <td>${order.ID}</td>
                                <td>${order.UID}</td>
                                <td>${order.TIME}</td>
                                <td>${new Intl.NumberFormat('vi-VN').format(order.TOTAL_PRICE)} VND</td>
                                <td>${order.METHOD}</td>
                                <td>${order.STATUS}</td>
                                <td class="action-buttons">
                                    <select class="form-select d-inline-block w-auto" onchange="changeStatus(${order.ID}, this)"
                                        ${['Đã giao', 'Khách hàng hủy', 'Cửa hàng hủy'].includes(order.STATUS) ? 'disabled' : ''}>
                                        <option value="">Chọn trạng thái</option>
                                        ${order.STATUS === 'Chờ xác nhận' ? '<option value="Đã xác nhận">Đã xác nhận</option><option value="Cửa hàng hủy">Cửa hàng hủy</option>' : ''}
                                        ${order.STATUS === 'Đã xác nhận' ? '<option value="Đang giao">Đang giao</option>' : ''}
                                        ${order.STATUS === 'Đang giao' ? '<option value="Đã giao">Đã giao</option>' : ''}
                                    </select>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_${order.ID}">
                                        <i class="fas fa-eye me-1"></i>Xem chi tiết
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });

                        // Tạo lại modal cho từng đơn hàng
                        const modals = document.querySelectorAll('.modal');
                        modals.forEach(modal => modal.remove()); // Xóa các modal cũ

                        data.orders.forEach(order => {
                            fetch(`get_order_details.php?order_id=${order.ID}`)
                                .then(response => response.json())
                                .then(details => {
                                    const modalDiv = document.createElement('div');
                                    modalDiv.className = 'modal fade';
                                    modalDiv.id = `modal_${order.ID}`;
                                    modalDiv.setAttribute('tabindex', '-1');
                                    modalDiv.setAttribute('aria-labelledby', `modalLabel_${order.ID}`);
                                    modalDiv.setAttribute('aria-hidden', 'true');
                                    modalDiv.innerHTML = `
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel_${order.ID}"><i class="fas fa-info-circle me-2"></i>Chi tiết Đơn hàng #${order.ID}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sản phẩm</th>
                                                                    <th>Hình ảnh</th>
                                                                    <th>Size</th>
                                                                    <th>Số lượng</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                ${details.details.length > 0 ? details.details.map(detail => `
                                                                    <tr>
                                                                        <td>${detail.PRODUCT_NAME ? detail.PRODUCT_NAME : detail.PID}</td>
                                                                        <td>
                                                                            ${detail.IMG_URL ? `<img src="${detail.IMG_URL.startsWith('http://') || detail.IMG_URL.startsWith('https://') ? detail.IMG_URL : '/Valclo-Shop/' + detail.IMG_URL}" alt="Hình ảnh sản phẩm" style="max-width: 40px; border-radius: 8px;">` : 'N/A'}
                                                                        </td>
                                                                        <td>${detail.SIZE}</td>
                                                                        <td>${detail.QUANTITY}</td>
                                                                    </tr>
                                                                `).join('') : '<tr><td colspan="4" class="text-center">Không có chi tiết cho đơn hàng này.</td></tr>'}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    document.body.appendChild(modalDiv);
                                })
                                .catch(error => {
                                    showToast('Lỗi khi lấy chi tiết đơn hàng: ' + error.message, 'danger');
                                });
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="7" class="text-center">Không tìm thấy đơn hàng nào.</td></tr>';
                    }
                })
                .catch(error => {
                    document.getElementById('error-message').innerHTML = 'Lỗi khi lọc đơn hàng: ' + error.message;
                    showToast('Lỗi khi lọc đơn hàng!', 'danger');
                });
        }

        // Client-side validation cho form lọc thời gian
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            if (filterForm) {
                filterForm.addEventListener('submit', function(e) {
                    let fromDate = document.getElementById('from_date').value;
                    let toDate = document.getElementById('to_date').value;

                    if ((fromDate && !toDate) || (!fromDate && toDate)) {
                        e.preventDefault();
                        showToast('Vui lòng chọn cả ngày bắt đầu và ngày kết thúc để lọc theo thời gian!', 'danger');
                    }
                });
            }

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