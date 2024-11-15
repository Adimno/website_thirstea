<?php
session_start();
header('Content-Type: application/json');

// Clean the output buffer in case any unwanted characters are sent before the JSON
ob_clean();

// Database connection
$sqlLink = mysqli_connect('localhost', 'root', '', 'thirstea');
if (!$sqlLink) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if action is to update cart or clear cart
    if (isset($_POST['action']) && $_POST['action'] == 'clear') {
        // Clear the entire cart for the user
        $user_id = $_SESSION['user_id'];  // Assuming user_id is stored in the session
        
        if (empty($user_id)) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            exit();
        }

        // Query to clear cart for the user
        $query = "DELETE FROM user_cart WHERE user_id = ?";
        $stmt = $sqlLink->prepare($query);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Cart cleared successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to clear cart']);
        }
        $stmt->close();
    } else {
        // Existing code for updating cart
        $cart_item_id = $_POST['cart_id'];
        $order_quantity = $_POST['order_quantity'];
        $order_amount = $_POST['order_amount']; // Get the order amount from the POST data

        // Validate inputs
        if (empty($cart_item_id) || empty($order_quantity) || empty($order_amount)) {
            echo json_encode(['success' => false, 'message' => 'Missing parameters']);
            exit();
        }

        // Update the quantity and order amount in the database
        $query = "UPDATE user_cart SET order_amount = ?, order_quantity = ? WHERE cart_id = ?";
        $stmt = $sqlLink->prepare($query);
        $stmt->bind_param("dii", $order_amount, $order_quantity, $cart_item_id); // Bind the order amount as a double and quantity as an integer

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Quantity and order amount updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update quantity or order amount']);
        }
        $stmt->close();
    }
    $sqlLink->close();  // Close the connection
}
?>
