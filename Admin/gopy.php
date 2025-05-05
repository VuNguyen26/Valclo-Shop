<?php
session_start();
include 'connect.php';

/* --- LẤY DANH SÁCH GÓP Ý --- */
$messages = [];
$result = $conn->query("SELECT * FROM MESSAGE ORDER BY ID ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
} else {
    $errorMessage = "Lỗi khi lấy dữ liệu góp ý: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Góp ý của khách hàng</title>
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
        }
    </style>
</head>
<body>
    <button class="toggle-btn btn btn-dark d-md-none" onclick="toggleSidebar()">☰</button>
    <?php include 'admin_header.php'; ?>

    <main class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4 text-primary"><i class="fas fa-comments me-2"></i>Góp ý của khách hàng</h2>

            <!-- Danh sách góp ý -->
            <div class="card">
                <div class="card-header"><i class="fas fa-table me-2"></i>Danh sách Góp ý</div>
                <div class="card-body">
                    <?php if (isset($errorMessage)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($errorMessage); ?>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Mã Feedback</th>
                                    <th>Tên khách hàng</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Chủ đề</th>
                                    <th style="width: 300px;">Lời nhắn</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($messages)): ?>
                                    <tr><td colspan="6" class="text-center">Không có góp ý nào để hiển thị.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($messages as $message): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($message['ID']); ?></td>
                                        <td><?php echo htmlspecialchars($message['FNAME']); ?></td>
                                        <td><?php echo htmlspecialchars($message['EMAIL']); ?></td>
                                        <td><?php echo htmlspecialchars($message['PHONE']); ?></td>
                                        <td><?php echo htmlspecialchars($message['SUBJECT']); ?></td>
                                        <td style="width: 300px;"><?php echo htmlspecialchars($message['CONTENT']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
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
    </script>
</body>
</html>
<?php
$conn->close();
?>