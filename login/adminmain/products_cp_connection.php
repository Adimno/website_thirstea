<?php
// Database connection details
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "thirstea";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected category from the query string
$category = isset($_GET['category']) ? $_GET['category'] : 'All'; // Default to 'All'

// Prepare the SQL query based on the selected category
if ($category == 'All') {
    $sql = "SELECT * FROM product"; // No filter for 'All'
} else {
    $sql = "SELECT * FROM product WHERE category = '$category'"; // Filter by category
}

// Execute the query
$result = $conn->query($sql);

// Prepare the products array to send as a response
$products = array();

while ($row = $result->fetch_assoc()) {
    $products[] = $row; // Add each product to the array
}

// Convert products array to JSON and output it
echo json_encode($products);

// Close the connection
$conn->close();
?>
