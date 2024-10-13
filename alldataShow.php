<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    a {
        margin: 0 5px;
        text-decoration: none;
        color: blue;
    }

    .pagination {
        margin: 20px 0;
    }

    .pagination a {
        padding: 8px 16px;
        border: 1px solid #ddd;
        margin: 0 2px;
        color: #000;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
    }

    .pagination a:hover {
        background-color: #ddd;
    }
</style>
<form method="post" action="download.php">
    <button type="submit" name="download_xlsx">Download All Data in XLSX</button>
</form>

<?php
// Include the database connection
require 'connection.php';

// Define how many results you want per page
$results_per_page = 10; // Show 5 records per page

// Find out the number of results stored in the database
$sql = "SELECT COUNT(id) AS total FROM emp_info";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_results = $row['total'];

// Determine the number of total pages available
$total_pages = ceil($total_results / $results_per_page);

// Determine which page number the visitor is currently on
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

// Prevent invalid page numbers
if ($page > $total_pages) {
    $page = $total_pages;
} elseif ($page < 1) {
    $page = 1;
}

// Determine the SQL LIMIT starting number for the results on the displaying page
$starting_limit = ($page - 1) * $results_per_page;

// Retrieve selected results from the database and display them on the page
$sql = "SELECT id, emp_name, mobaile_no, email, created_at FROM emp_info LIMIT " . $starting_limit . ',' . $results_per_page;
$result = $conn->query($sql);

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Name</th><th>Mobile No</th><th>Email</th><th>Created At</th></tr>";

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['emp_name']}</td>
                <td>{$row['mobaile_no']}</td>
                <td>{$row['email']}</td>
                <td>{$row['created_at']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No data found</td></tr>";
}

echo "</table>";

// Pagination logic
echo '<div class="pagination">';

// Previous button
if ($page > 1) {
    echo '<a href="alldataShow.php?page=' . ($page - 1) . '">&laquo; Previous</a>';
}

// Page number links
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo '<a class="active" href="alldataShow.php?page=' . $i . '">' . $i . '</a>';
    } else {
        echo '<a href="alldataShow.php?page=' . $i . '">' . $i . '</a>';
    }
}

// Next button
if ($page < $total_pages) {
    echo '<a href="alldataShow.php?page=' . ($page + 1) . '">Next &raquo;</a>';
}

echo '</div>';

// Close the database connection
$conn->close();
?>
