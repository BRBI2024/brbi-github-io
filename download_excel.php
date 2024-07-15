<?php
include("connection/connect.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();

if(empty($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

$query = "SELECT * FROM users_orders WHERE u_id='$user_id'";
if ($start_date && $end_date) {
    $query .= " AND date BETWEEN '$start_date' AND '$end_date'";
}

$result = mysqli_query($db, $query);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Item');
$sheet->setCellValue('B1', 'Quantity');
$sheet->setCellValue('C1', 'Price');
$sheet->setCellValue('D1', 'Total Price');
$sheet->setCellValue('E1', 'Status');
$sheet->setCellValue('F1', 'Date');

$rowCount = 2;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowCount, $row['title']);
    $sheet->setCellValue('B' . $rowCount, $row['quantity']);
    $sheet->setCellValue('C' . $rowCount, '₱' . $row['price']);
    $sheet->setCellValue('D' . $rowCount, '₱' . ($row['price'] * $row['quantity']));
    $sheet->setCellValue('E' . $rowCount, $row['status']);
    $sheet->setCellValue('F' . $rowCount, $row['date']);
    $rowCount++;
}

$writer = new Xlsx($spreadsheet);
$filename = "Orders_" . date('YmdHis') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit();
?>
