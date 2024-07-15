<?php
include("../connection/connect.php");
session_start();

require '../vendor/autoload.php'; // Ensure this path is correct

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$searchUser = isset($_GET['search_username']) ? $_GET['search_username'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'username';
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

$sql = "SELECT users.username, users_orders.title, users_orders.quantity, users_orders.price, users_orders.status, users_orders.date 
        FROM users 
        INNER JOIN users_orders ON users.u_id = users_orders.u_id 
        WHERE users_orders.status = 'closed'";

if ($searchUser) {
    $sql .= " AND users.username LIKE '%$searchUser%'";
}

if ($startDate && $endDate) {
    $sql .= " AND users_orders.date BETWEEN '$startDate' AND '$endDate'";
} elseif ($startDate) {
    $sql .= " AND users_orders.date >= '$startDate'";
} elseif ($endDate) {
    $sql .= " AND users_orders.date <= '$endDate'";
}

$sql .= " ORDER BY $sortBy $sortOrder";

$query = mysqli_query($db, $sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Branch');
$sheet->setCellValue('B1', 'Supply');
$sheet->setCellValue('C1', 'Quantity');
$sheet->setCellValue('D1', 'Price');
$sheet->setCellValue('E1', 'Total Price');
// $sheet->setCellValue('F1', 'Status');
// $sheet->setCellValue('G1', 'Reg-Date');

$rowNumber = 2;
while ($row = mysqli_fetch_assoc($query)) {
    $totalPrice = $row['price'] * $row['quantity'];
    $sheet->setCellValue('A' . $rowNumber, $row['username']);
    $sheet->setCellValue('B' . $rowNumber, $row['title']);
    $sheet->setCellValue('C' . $rowNumber, $row['quantity']);
    $sheet->setCellValue('D' . $rowNumber, '₱' . $row['price']);
    $sheet->setCellValue('E' . $rowNumber, '₱' . $totalPrice);
    // $sheet->setCellValue('F' . $rowNumber, $row['status']);
    // $sheet->setCellValue('G' . $rowNumber, $row['date']);
    $rowNumber++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'approved_orders.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
