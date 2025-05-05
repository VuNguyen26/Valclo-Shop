<?php
// Khởi tạo session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Số tài khoản người dùng hiện có
$userCountResult = $conn->query("
    SELECT COUNT(ID) AS user_count
    FROM `account`
");
$userCount = $userCountResult->fetch_assoc()['user_count'] ?? 0;

// Số lượt góp ý
$messageCountResult = $conn->query("
    SELECT COUNT(ID) AS message_count
    FROM `message`
");
$messageCount = $messageCountResult->fetch_assoc()['message_count'] ?? 0;

// Lấy danh sách các năm có dữ liệu trong bảng order
$yearsQuery = "
    SELECT DISTINCT YEAR(TIME) AS year
    FROM `order`
    ORDER BY year DESC
";
$yearsResult = $conn->query($yearsQuery);
$years = $yearsResult->fetch_all(MYSQLI_ASSOC);

// Dữ liệu ban đầu cho biểu đồ
$tab = 'revenue'; // Mặc định là tab "Doanh thu"
$revenueAndOrders = [];

$query = "
    SELECT DATE_FORMAT(TIME, '%Y-%m') AS period, 
           SUM(TOTAL_PRICE) AS total_revenue, 
           COUNT(ID) AS order_count
    FROM `order`
    GROUP BY DATE_FORMAT(TIME, '%Y-%m')
    ORDER BY DATE_FORMAT(TIME, '%Y-%m')
";
$result = $conn->query($query);
if ($result) {
    $revenueAndOrders = $result->fetch_all(MYSQLI_ASSOC);
}

// Tính giá trị tối đa cho trục y của tab "Doanh thu"
$maxRevenue = !empty($revenueAndOrders) ? max(array_column($revenueAndOrders, 'total_revenue')) : 0;
$maxRevenueTicks = ceil($maxRevenue / 3000000) * 3000000; // Làm tròn lên đến bội số gần nhất của 3 triệu

// Tính giá trị tối đa cho trục y của tab "Đơn hàng"
$maxOrders = !empty($revenueAndOrders) ? max(array_column($revenueAndOrders, 'order_count')) : 0;
$maxOrdersTicks = ceil($maxOrders / 2) * 2; // Làm tròn lên đến bội số gần nhất của 2

// Xử lý thống kê top 5 khách hàng
// Lưu trạng thái lọc vào session
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $_SESSION['top5_start_date'] = $_POST['start_date'];
    $_SESSION['top5_end_date'] = $_POST['end_date'];
    $_SESSION['top5_sort_order'] = $_POST['sort_order'] ?? 'DESC';
}

// Lấy giá trị từ session (nếu có)
$start_date = $_SESSION['top5_start_date'] ?? '';
$end_date = $_SESSION['top5_end_date'] ?? '';
$sort_order = $_SESSION['top5_sort_order'] ?? 'DESC';
$topCustomers = [];

// Hiển thị top 5 khách hàng
$useTimeFilter = !empty($start_date) && !empty($end_date); // Kiểm tra xem có sử dụng bộ lọc thời gian không

if ($useTimeFilter) {
    // Truy vấn với khoảng thời gian người dùng nhập
    $query = "
        WITH TopCustomers AS (
            SELECT a.ID, a.FNAME, a.EMAIL, SUM(o.TOTAL_PRICE) AS total_spent
            FROM account a
            JOIN `order` o ON a.ID = o.UID
            WHERE o.TIME BETWEEN ? AND ?
            GROUP BY a.ID
            ORDER BY total_spent DESC
            LIMIT 5
        )
        SELECT * FROM TopCustomers
        ORDER BY total_spent $sort_order
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $start_date, $end_date);
} else {
    // Truy vấn mặc định: Top 5 khách hàng trong toàn bộ thời gian
    $query = "
        WITH TopCustomers AS (
            SELECT a.ID, a.FNAME, a.EMAIL, SUM(o.TOTAL_PRICE) AS total_spent
            FROM account a
            JOIN `order` o ON a.ID = o.UID
            GROUP BY a.ID
            ORDER BY total_spent DESC
            LIMIT 5
        )
        SELECT * FROM TopCustomers
        ORDER BY total_spent $sort_order
    ";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$topCustomersResult = $stmt->get_result();
$tempCustomers = $topCustomersResult->fetch_all(MYSQLI_ASSOC);

// Loại bỏ trùng lặp dựa trên ID khách hàng
$uniqueCustomers = [];
$seenIds = [];
foreach ($tempCustomers as $customer) {
    if (!in_array($customer['ID'], $seenIds)) {
        $uniqueCustomers[] = $customer;
        $seenIds[] = $customer['ID'];
    }
}

// Lấy danh sách đơn hàng cho từng khách hàng
foreach ($uniqueCustomers as $customer) {
    $customerId = $customer['ID'];
    if ($useTimeFilter) {
        $ordersQuery = "
            SELECT o.ID, o.TIME, o.TOTAL_PRICE, o.STATUS
            FROM `order` o
            WHERE o.UID = ? AND o.TIME BETWEEN ? AND ?
            ORDER BY o.TIME DESC
        ";
        $stmt = $conn->prepare($ordersQuery);
        $stmt->bind_param('iss', $customerId, $start_date, $end_date);
    } else {
        $ordersQuery = "
            SELECT o.ID, o.TIME, o.TOTAL_PRICE, o.STATUS
            FROM `order` o
            WHERE o.UID = ?
            ORDER BY o.TIME DESC
        ";
        $stmt = $conn->prepare($ordersQuery);
        $stmt->bind_param('i', $customerId);
    }
    $stmt->execute();
    $ordersResult = $stmt->get_result();
    $orders = $ordersResult->fetch_all(MYSQLI_ASSOC);

    // Thêm danh sách đơn hàng vào thông tin khách hàng
    $customerData = $customer;
    $customerData['orders'] = $orders;
    $topCustomers[] = $customerData;
}
?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Thống kê</h5>
    </div>
    <div class="card-body">
        <!-- Form chọn năm và tab chuyển đổi -->
        <form id="filterForm" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="selected_year" class="form-label">Chọn năm</label>
                    <select class="form-select" id="selected_year">
                        <option value="">Tất cả</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?php echo $year['year']; ?>">
                                <?php echo $year['year']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" id="filterBtn" class="btn btn-primary w-100">Lọc</button>
                </div>
                <div class="col-md-7">
                    <ul class="nav nav-tabs" id="statsTabs">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" data-tab="revenue">Doanh thu</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" data-tab="orders">Đơn hàng</button>
                        </li>
                    </ul>
                </div>
            </div>
        </form>

        <div id="chartContainer">
            <?php if (!empty($revenueAndOrders)): ?>
                <canvas id="statsChart" style="max-height: 300px;"></canvas>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    Không có dữ liệu trong khoảng thời gian này.
                </div>
            <?php endif; ?>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <p class="mb-0"><strong>Số tài khoản người dùng:</strong> <?php echo $userCount; ?></p>
            </div>
            <div class="col-md-6">
                <p class="mb-0"><strong>Số lượt góp ý:</strong> <?php echo $messageCount; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Phần thống kê top 5 khách hàng -->
<div class="mt-5">
    <h4 class="mb-4">Thống kê top 5 khách hàng mua nhiều nhất</h4>
    <form method="POST" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Từ ngày</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">Đến ngày</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
            </div>
            <div class="col-md-2">
                <label for="sort_order" class="form-label">Sắp xếp</label>
                <select class="form-select" id="sort_order" name="sort_order">
                    <option value="DESC" <?php echo $sort_order === 'DESC' ? 'selected' : ''; ?>>Giảm dần</option>
                    <option value="ASC" <?php echo $sort_order === 'ASC' ? 'selected' : ''; ?>>Tăng dần</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Thống kê</button>
            </div>
        </div>
    </form>

    <?php if (count($topCustomers) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Tổng tiền mua</th>
                        <th>Đơn hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topCustomers as $index => $customer): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($customer['FNAME']); ?></td>
                            <td><?php echo htmlspecialchars($customer['EMAIL']); ?></td>
                            <td><?php echo number_format($customer['total_spent'], 0, ',', '.'); ?> VND</td>
                            <td>
                                <ul class="list-unstyled">
                                    <?php foreach ($customer['orders'] as $order): ?>
                                        <li>
                                            <a href="order_detail_view.php?order_id=<?php echo $order['ID']; ?>" class="text-decoration-none">
                                                Đơn #<?php echo $order['ID']; ?> (<?php echo $order['TIME']; ?>, 
                                                <?php echo number_format($order['TOTAL_PRICE'], 0, ',', '.'); ?> VND, 
                                                <?php echo $order['STATUS']; ?>)
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            Không có dữ liệu khách hàng.
        </div>
    <?php endif; ?>
</div>

<!-- Thêm Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
// Dữ liệu ban đầu cho biểu đồ
let chartInstance = null;

const initialData = {
    labels: [<?php 
        $labels = array_map(function($item) { return '"' . $item['period'] . '"'; }, $revenueAndOrders);
        echo implode(',', $labels);
    ?>],
    data: [<?php 
        $values = array_column($revenueAndOrders, 'total_revenue');
        echo implode(',', $values);
    ?>],
    tab: 'revenue'
};

// Hàm khởi tạo biểu đồ
function initChart(labels, data, tab) {
    const statsCtx = document.getElementById('statsChart').getContext('2d');
    
    // Hủy biểu đồ cũ nếu có
    if (chartInstance) {
        chartInstance.destroy();
    }

    // Tính giá trị tối đa để đặt mốc trục y
    const maxValue = Math.max(...data);
    const maxTicks = tab === 'revenue' ? Math.ceil(maxValue / 3000000) * 3000000 : Math.ceil(maxValue / 2) * 2;

    chartInstance = new Chart(statsCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: tab === 'revenue' ? 'Doanh thu (VND)' : 'Số đơn hàng',
                data: data,
                backgroundColor: tab === 'revenue' ? 'rgba(54, 162, 235, 0.6)' : 'rgba(255, 99, 132, 0.6)',
                borderColor: tab === 'revenue' ? 'rgba(54, 162, 235, 1)' : 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: maxTicks, // Đặt giá trị tối đa để bao gồm các mốc
                    title: {
                        display: true,
                        text: tab === 'revenue' ? 'Doanh thu (VND)' : 'Số đơn hàng'
                    },
                    ticks: {
                        stepSize: tab === 'revenue' ? 3000000 : 2, // 3 triệu cho doanh thu, 2 cho đơn hàng
                        callback: function(value) {
                            return tab === 'revenue' ? value.toLocaleString('vi-VN') + ' VND' : value;
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Thời gian (Năm-Tháng)'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tab === 'revenue' ? context.parsed.y.toLocaleString('vi-VN') + ' VND' : context.parsed.y;
                            return label;
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
}

// Khởi tạo biểu đồ lần đầu
<?php if (!empty($revenueAndOrders)): ?>
    initChart(initialData.labels, initialData.data, initialData.tab);
<?php endif; ?>

// Biến lưu trạng thái tab và năm đã chọn
let currentTab = 'revenue';
let selectedYearRevenue = '';
let selectedYearOrders = '';

// Xử lý sự kiện chuyển tab
document.querySelectorAll('#statsTabs .nav-link').forEach(tab => {
    tab.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Cập nhật trạng thái tab
        document.querySelectorAll('#statsTabs .nav-link').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        currentTab = this.getAttribute('data-tab');

        // Cập nhật dropdown năm dựa trên tab
        const selectYear = document.getElementById('selected_year');
        selectYear.value = currentTab === 'revenue' ? selectedYearRevenue : selectedYearOrders;

        // Gửi yêu cầu AJAX để lấy dữ liệu
        fetchStats(currentTab, currentTab === 'revenue' ? selectedYearRevenue : selectedYearOrders);
    });
});

// Xử lý sự kiện nhấn nút Lọc
document.getElementById('filterBtn').addEventListener('click', function(e) {
    e.preventDefault();

    // Lấy giá trị năm từ dropdown
    const selectedYear = document.getElementById('selected_year').value;

    // Lưu giá trị năm cho tab hiện tại
    if (currentTab === 'revenue') {
        selectedYearRevenue = selectedYear;
    } else {
        selectedYearOrders = selectedYear;
    }

    // Gửi yêu cầu AJAX
    fetchStats(currentTab, selectedYear);
});

// Hàm gửi yêu cầu AJAX và cập nhật biểu đồ
function fetchStats(tab, year) {
    const formData = new FormData();
    formData.append('tab', tab);
    formData.append('selected_year', year);

    fetch('fetch_stats.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const chartContainer = document.getElementById('chartContainer');
        if (data.success) {
            const labels = data.data.map(item => item.period);
            const values = tab === 'revenue' ? data.data.map(item => item.total_revenue) : data.data.map(item => item.order_count);

            chartContainer.innerHTML = '<canvas id="statsChart" style="max-height: 300px;"></canvas>';
            initChart(labels, values, tab);
        } else {
            chartContainer.innerHTML = '<div class="alert alert-warning" role="alert">Không có dữ liệu trong khoảng thời gian này.</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('chartContainer').innerHTML = '<div class="alert alert-danger" role="alert">Đã xảy ra lỗi khi tải dữ liệu.</div>';
    });
}
</script>