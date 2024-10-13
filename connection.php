<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "newtest"; 

$conn = new mysqli($host, $user, $password, $dbname);
// echo "hi";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
