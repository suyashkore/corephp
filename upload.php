<?php
require 'connection.php'; 
use PhpOffice\PhpSpreadsheet\IOFactory;


if ($_FILES['file']['name']) {
    $filename = $_FILES['file']['name'];
    $fileTmp = $_FILES['file']['tmp_name'];
    $fileExt = pathinfo($filename, PATHINFO_EXTENSION);

    if ($fileExt == 'xlsx') {
        require 'vendor/autoload.php';

        try {
            // Load the uploaded XLSX file
            $spreadsheet = IOFactory::load($fileTmp);
            $worksheet = $spreadsheet->getActiveSheet();

            $isFirstRow = true; // Flag to skip the first row (header)

            // Loop through rows and get data
            foreach ($worksheet->getRowIterator() as $row) {
                // Skip the first row if it's a header
                if ($isFirstRow) {
                    $isFirstRow = false;
                    continue; // Skip this iteration to avoid inserting headers
                }

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Include empty cells

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue(); // Collect cell values
                }

                // Check if rowData has required values (emp_name, mobaile_no, email)
                if (!empty($rowData[0]) && !empty($rowData[1]) && !empty($rowData[2])) {
                    $emp_name = $rowData[0];
                    $mobaile_no = $rowData[1];
                    $email = $rowData[2];

                     // Insert data into the database
                        $sql = "INSERT INTO emp_info (emp_name, mobile_no, email) 
                                VALUES ('" . $conn->real_escape_string($emp_name) . "', 
                                        '" . $conn->real_escape_string($mobaile_no) . "', 
                                        '" . $conn->real_escape_string($email) . "')";
                        $conn->query($sql);
                  
                }
            }

            // Alert success and redirect
            echo "<script>alert('File uploaded and data imported successfully!'); window.location.href='index.php';</script>";

        } catch (Exception $e) {
            die("Error loading file: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('Please upload a valid XLSX file.'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('No file uploaded.'); window.location.href='index.php';</script>";
}
?>
