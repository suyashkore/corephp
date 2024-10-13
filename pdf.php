<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f4f4f4;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .alert {
            display: none;
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

    <form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
        <label for="name">File Name:</label>
        <input type="text" name="name" id="name" required>
        
        <label for="pdf">Upload PDF:</label>
        <input type="file" name="pdf" id="pdf" accept="application/pdf" required>
        
        <button type="submit" name="submit">Upload PDF</button>
    </form>

    <div class="alert success" id="successMessage">
        PDF uploaded and path saved to the database successfully.
    </div>
    <div class="alert error" id="errorMessage">
        Failed to upload the file. Please try again.
    </div>

    <?php
    if (isset($_POST['submit'])) {
        // Database connection
        require 'connection.php'; 

        // Retrieve form data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        
        // File upload handling
        $pdf_file = $_FILES['pdf']['name'];
        $pdf_temp = $_FILES['pdf']['tmp_name'];
        
        // Define the upload directory
        $upload_dir = 'uploads/';
        
        // Automatically create the uploads directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // 0777 gives read, write, and execute permissions
        }
        
        // Target file path
        $pdf_path = $upload_dir . basename($pdf_file);
        
        // Check if the file is a valid PDF
        $file_type = mime_content_type($pdf_temp);
        if ($file_type !== 'application/pdf') {
            echo "<script>
                document.getElementById('errorMessage').innerHTML = 'Only PDF files are allowed.';
                document.getElementById('errorMessage').style.display = 'block';
            </script>";
            exit();
        }
        
        // Move uploaded file to the uploads folder
        if (move_uploaded_file($pdf_temp, $pdf_path)) {
            // Insert into the database
            $sql = "INSERT INTO pdf (Name, PdfPath) VALUES ('$name', '$pdf_path')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<script>
                    document.getElementById('successMessage').style.display = 'block';
                </script>";
            } else {
                echo "<script>
                    document.getElementById('errorMessage').innerHTML = 'Database error: " . $conn->error . "';
                    document.getElementById('errorMessage').style.display = 'block';
                </script>";
            }
        } else {
            echo "<script>
                document.getElementById('errorMessage').innerHTML = 'Failed to upload the file.';
                document.getElementById('errorMessage').style.display = 'block';
            </script>";
        }
        
        // Close connection
        $conn->close();
    }
    ?>

</body>
</html>
