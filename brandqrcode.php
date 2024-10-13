<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode and QR Code Generator to Retrieve Employee Details</title>

    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2, h3 {
            color: #333;
        }

        #qr-reader {
            width: 500px;
            margin-bottom: 20px;
        }

        .scanned-result, .employee-info {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 100%;
            max-width: 600px;
        }

        .scanned-result p, .employee-info p {
            font-size: 18px;
            color: #555;
        }

        form {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        form input[type="number"], form input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            margin: 10px 0;
            width: calc(100% - 24px); /* Adjusted for padding */
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #218838;
        }

        .qr-code, .barcode {
            text-align: center;
            margin-top: 20px;
        }

        img {
            max-width: 200px;
        }
    </style>
</head>
<body>

    <h2>Scan Barcode or QR Code to Retrieve Employee Details</h2>
    <div id="qr-reader"></div>

    <form method="get" action="">
        <input type="number" name="id" placeholder="Enter Employee ID" required>
        <input type="submit" value="Enter">
    </form>

    <script>
        function onScanSuccess(qrMessage) {
            document.getElementById("scanned-id").textContent = qrMessage;
            document.getElementById("qr-code-result").value = qrMessage;
            document.getElementById("qr-form").submit();
        }

        function onScanError(errorMessage) {
            console.error(errorMessage);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>

<?php
require 'vendor/autoload.php'; 

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Picqer\Barcode\BarcodeGeneratorHTML;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    require 'connection.php'; 

    $sql = "SELECT id, emp_name, mobile_no, email, created_at FROM emp_info WHERE id = ?"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo "<h3>Employee Information</h3>";
        echo "<p>ID: " . htmlspecialchars($row['id']) . "</p>";
        // echo "<p>Name: " . htmlspecialchars($row['emp_name']) . "</p>";
        // echo "<p>Mobile No: " . htmlspecialchars($row['mobaile_no']) . "</p>"; 
        // echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
        // echo "<p>Created At: " . htmlspecialchars($row['created_at']) . "</p>";

        // Generate QR Code
        $employeeDetails = "ID: " . $row['id'] . "\n" . 
                           "Name: " . $row['emp_name'] . "\n" . 
                           "Mobile No: " . $row['mobile_no'] . "\n" . 
                           "Email: " . $row['email'] . "\n" . 
                           "Created At: " . $row['created_at'];

        echo "<h3>Employee QR Code:</h3>";
        $qrCode = new QrCode($employeeDetails);
        $qrCode->setSize(200);
        $writer = new PngWriter();
        $qrImage = $writer->write($qrCode)->getDataUri();
        echo '<img src="' . $qrImage . '" alt="Employee QR Code">';

        // Generate Barcode
        echo "<h3>Employee Barcode:</h3>";  
        $generator = new BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($row['mobile_no'], $generator::TYPE_CODE_128); 
        echo $barcode; // Display the barcode

        // Display Mobile Number below the barcode
        echo "<p>Mobile No: " . htmlspecialchars($row['mobile_no']) . "</p>";
        
    } else {
        echo "<p>No employee found with ID: " . htmlspecialchars($id) . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
