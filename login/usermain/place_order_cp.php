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

// Get and sanitize other inputs
$payment_method = filter_var($_POST['payment_method'], FILTER_SANITIZE_STRING);
$address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
$cart_items = json_decode($_POST['cart_items'], true); // Decode cart items array
$total_amount = filter_var($_POST['total_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$subtotal = filter_var($_POST['subtotal'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

// Database connection
$sqlLink = mysqli_connect('localhost', 'root', '', 'thirstea');
if (!$sqlLink) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Loop through cart items and process the order
    foreach ($cart_items as $item) {
        $productName = $item['product_name'];
        $quantity = $item['order_quantity'];
        $orderAmount = $item['order_amount'];
        $size = $item['size'];
        $imageUrl = $item['imageUrl'];
        $orderStatus = 'Pending';
        $orderId = uniqid('order_', true);  // Generate a unique order ID
        $orderDate = date('Y-m-d H:i:s');

        // Apply size-based price adjustment
        if ($size === 'Medium') {
            $orderAmount += 10; // Add 10 if size is Medium
        } elseif ($size === 'Large') {
            $orderAmount += 20; // Add 20 if size is Large
        }

        // Calculate the total amount for the item based on the quantity
        $itemTotalAmount = $orderAmount * $quantity;

        // Insert into orders table (add address field to database query)
        $query = "INSERT INTO orders (order_id, user_email, imageUrl, product_name, size, order_quantity, payment_method, order_amount, order_status, order_date, order_address)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare the statement and bind the parameters
        $stmt = $sqlLink->prepare($query);
        $stmt->bind_param("sssssssssss", $orderId, $email, $imageUrl, $productName, $size, $quantity, $payment_method, $itemTotalAmount, $orderStatus, $orderDate, $address);
        
        // Execute the query
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Failed to insert order item']);
            exit;
        }
    }

    // Clear the user's cart after the order is placed
    $clearCartQuery = "DELETE FROM user_cart WHERE user_email = ?";
    $clearCartStmt = $sqlLink->prepare($clearCartQuery);
    $clearCartStmt->bind_param("s", $email);

    if (!$clearCartStmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to clear the cart']);
        exit;
    }

    // Return success
    echo json_encode(['success' => true, 'message' => 'Order placed successfully and cart cleared']);
}
?>
