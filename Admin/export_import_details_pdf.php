<?php
require_once 'C:/xampp1/htdocs/Valclo-Shop/vendor/autoload.php'; // Sử dụng đường dẫn tuyệt đối
include 'connect.php';

// Kiểm tra xem có import_id được truyền qua không
if (!isset($_GET['import_id']) || empty($_GET['import_id'])) {
    die('Không tìm thấy ID đợt nhập hàng!');
}

$import_id = intval($_GET['import_id']);

// Lấy thông tin đợt nhập hàng
$sql = "SELECT i.ID, i.IMPORT_DATE, i.NOTE, s.NAME AS supplier_name 
        FROM import i 
        LEFT JOIN supplier s ON i.SUPPLIER_ID = s.ID 
        WHERE i.ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $import_id);
$stmt->execute();
$import = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$import) {
    die('Đợt nhập hàng không tồn tại!');
}

// Lấy chi tiết nhập hàng
$sql = "SELECT p.NAME, id.QUANTITY, id.IMPORT_PRICE 
        FROM import_detail id 
        LEFT JOIN product p ON id.PID = p.ID 
        WHERE id.IMPORT_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $import_id);
$stmt->execute();
$details = $stmt->get_result();
$stmt->close();

// Tạo PDF
class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('dejavusans', 'B', 14);
        $this->Cell(0, 10, 'CHI TIẾT NHẬP HÀNG', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Ln(10);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('dejavusans', 'I', 8);
        $this->Cell(0, 10, 'Trang ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Thiết lập thông tin tài liệu
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('Chi tiết nhập hàng #' . $import_id);
$pdf->SetSubject('Chi tiết nhập hàng');
$pdf->SetKeywords('TCPDF, PDF, import, details');

// Thiết lập margin
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Thiết lập font
$pdf->SetFont('dejavusans', '', 10);

// Thêm trang
$pdf->AddPage();

// Thông tin đợt nhập hàng
$html = '<h2>Thông tin đợt nhập hàng</h2>
<table border="0" cellpadding="4">
    <tr>
        <td><strong>ID:</strong></td>
        <td>' . htmlspecialchars($import['ID']) . '</td>
    </tr>
    <tr>
        <td><strong>Ngày nhập:</strong></td>
        <td>' . htmlspecialchars($import['IMPORT_DATE']) . '</td>
    </tr>
    <tr>
        <td><strong>Nhà cung cấp:</strong></td>
        <td>' . htmlspecialchars($import['supplier_name'] ?: 'N/A') . '</td>
    </tr>
    <tr>
        <td><strong>Ghi chú:</strong></td>
        <td>' . htmlspecialchars($import['NOTE'] ?: 'N/A') . '</td>
    </tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');

// Bảng chi tiết nhập hàng
$html = '<h3>Chi tiết nhập hàng</h3>
<table border="1" cellpadding="4">
    <tr style="background-color:#f8f9fa;">
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá nhập (VND)</th>
        <th>Tổng (VND)</th>
    </tr>';

$total_cost = 0;
while ($row = $details->fetch_assoc()) {
    $total = $row['QUANTITY'] * $row['IMPORT_PRICE'];
    $total_cost += $total;
    $html .= '<tr>
        <td>' . htmlspecialchars($row['NAME']) . '</td>
        <td>' . htmlspecialchars($row['QUANTITY']) . '</td>
        <td>' . number_format($row['IMPORT_PRICE']) . '</td>
        <td>' . number_format($total) . '</td>
    </tr>';
}

$html .= '<tr>
    <td colspan="3" style="text-align:right;"><strong>Tổng chi phí:</strong></td>
    <td><strong>' . number_format($total_cost) . ' VND</strong></td>
</tr>';

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

// Xuất PDF
$filename = 'Import_Details_' . $import_id . '.pdf';
$pdf->Output($filename, 'D');
?>