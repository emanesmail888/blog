<?php
// Database connection
$host = 'localhost';
$dbname = 'blog';
$username = 'root';
$password = '';
$con = mysqli_connect("localhost","root","","blog");


// Pagination variables
$post_per_page = 3;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $post_per_page;

// Query to retrieve paginated results
$query = "SELECT * FROM posts ORDER BY id DESC LIMIT $start_from, $post_per_page";
// $stmt = $connection->prepare($query);
// $stmt->execute();
// $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$posts=mysqli_query($con,$query);
while($results=mysqli_fetch_array($posts))
{
    echo  $results['title'];
   ?> <br>
<?php

}


// Query to count total number of rows
$countQuery = "SELECT COUNT(*) as total_rows FROM posts";
$countStmt = mysqli_query($con,$countQuery);
// $countStmt->execute();
while($row=mysqli_fetch_array($countStmt))
{
    $total_rows = $row['total_rows'];


}
// $row = $countStmt->fetch(PDO::FETCH_ASSOC);
//$total_rows = $row['total_rows'];


// Calculate total number of pages
$total_pages = ceil($total_rows / $post_per_page);

// Display paginated results


// Generate pagination links
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='dd.php?page=$i'>$i</a> ";
}

?>



















<?php
// Database connection
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Pagination variables
$post_per_page = 3;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $post_per_page;

// Query to retrieve paginated results
$query = "SELECT * FROM posts ORDER BY id DESC LIMIT :start_from, :post_per_page";
$stmt = $connection->prepare($query);
$stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
$stmt->bindParam(':post_per_page', $post_per_page, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query to count total number of rows
$countQuery = "SELECT COUNT(*) as total_rows FROM posts";
$countStmt = $connection->prepare($countQuery);
$countStmt->execute();
$row = $countStmt->fetch(PDO::FETCH_ASSOC);
$total_rows = $row['total_rows'];

// Calculate total number of pages
$total_pages = ceil($total_rows / $post_per_page);

// Display paginated results
foreach ($results as $result) {
    // Display the post information
    echo "<h2>{$result['title']}</h2>";
    echo "<p>{$result['content']}</p>";
    echo "<hr>";
}

// Generate pagination links
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='index.php?page=$i'>$i</a> ";
}





