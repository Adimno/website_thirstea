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
    // Check if action is to delete an item from the cart
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        // Delete the specific cart item for the user
        $cart_item_id = $_POST['cart_id'];  // Get the cart item ID from the request

        if (empty($cart_item_id)) {
            echo json_encode(['success' => false, 'message' => 'Missing cart item ID']);
            exit();
        }

        // Query to delete the cart item
        $query = "DELETE FROM user_cart WHERE cart_id = ?";
        $stmt = $sqlLink->prepare($query);
        $stmt->bind_param("i", $cart_item_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Cart item deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete cart item']);
        }
        $stmt->close();
    } else {
        // Existing code for updating cart or clearing cart
        $cart_item_id = $_POST['cart_id'];
        $order_quantity = $_POST['order_quantity'];

        // Validate inputs
        if (empty($cart_item_id) || empty($order_quantity)) {
            echo json_encode(['success' => false, 'message' => 'Missing parameters']);
            exit();
        }

        // Update the quantity in the database
        $query = "UPDATE user_cart SET order_quantity = ? WHERE cart_id = ?";
        $stmt = $sqlLink->prepare($query);
        $stmt->bind_param("ii", $order_quantity, $cart_item_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Quantity updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update quantity']);
        }
        $stmt->close();
    }
    $sqlLink->close();  // Close the connection
}
?>
