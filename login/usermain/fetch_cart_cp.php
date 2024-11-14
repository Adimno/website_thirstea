<?php
session_start();
header('Content-Type: application/json');

// Clean the output buffer in case any unwanted characters are sent before the JSON
ob_clean();

// Get and sanitize email from the POST request
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email']);
    exit;
}

// Database connection
$sqlLink = mysqli_connect('localhost', 'root', '', 'thirstea');
if (!$sqlLink) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare SQL query to fetch all data from user_cart where user_email is the same
$sql = "SELECT * FROM user_cart WHERE user_email = ?";
$stmt = $sqlLink->prepare($sql);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement']);
    exit;
}

// Bind parameters and execute query
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store cart items
$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

// Return cart items or message if no items are found
if (count($cartItems) > 0) {
    echo json_encode(['success' => true, 'cartItems' => $cartItems]);
} else {
    echo json_encode(['success' => false, 'message' => 'No items found in cart for this user.']);
}

// Close statement and database connection
$stmt->close();
$sqlLink->close();
?>
