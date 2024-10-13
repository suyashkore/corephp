<?php
// Include the PhpSpreadsheet library
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Include the database connection
require 'connection.php';

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the column headers
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Name');
$sheet->setCellValue('C1', 'Mobile No');
$sheet->setCellValue('D1', 'Email');
$sheet->setCellValue('E1', 'Created At');

// Retrieve data from the database
$sql = "SELECT id, emp_name, mobaile_no, email, created_at FROM emp_info";
$result = $conn->query($sql);

// Check if data exists
if ($result->num_rows > 0) {
    $rowIndex = 2; // Start adding data from row 2
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowIndex, $row['id']);
        $sheet->setCellValue('B' . $rowIndex, $row['emp_name']);
        $sheet->setCellValue('C' . $rowIndex, $row['mobaile_no']);
        $sheet->setCellValue('D' . $rowIndex, $row['email']);
        $sheet->setCellValue('E' . $rowIndex, $row['created_at']);
        $rowIndex++;
    }
}

// Set the headers to download the file as an Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="emp_info_data.xlsx"');
header('Cache-Control: max-age=0');

// Create the XLSX file and write it to the output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Close the database connection
$conn->close();

exit();
?>
