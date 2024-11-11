<?php
session_start();

$email = $_SESSION['email'];
$specialArray = $_SESSION['Specials'] ?? [];

$sqlLink = mysqli_connect('localhost', 'root', '', 'thirstea');

// If email is not found in session, it means the user is not logged in
if (!$email) {
    echo '<script>alert("Please log in to add items to the cart."); window.location.href="login.php";</script>';
    exit();
}

// If email is not found in session, it means the user is not logged in
if (!$email) {
    echo '<script>alert("Please log in to add items to the cart."); window.location.href="login.php";</script>';
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    // Get the product details from the form
    $productId = (int)$_POST['product_id'];
    $imageUrl = $_POST['imageUrl'];  // Retrieve Image URL
    $size = $_POST['size'];
    $quantity = (int)$_POST['order_quantity'];
    $description = $_POST['description'];  // Retrieve Description

    // Fetch product information from the database
    $sql = "SELECT product_name, price FROM product WHERE product_id = ?";
    $stmt = $sqlLink->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $productName = $product['product_name'];
        $price = $product['price'];

        // Calculate order amount based on size (extra charges for size)
        $orderAmount = calculateOrderAmount($quantity, $price, $size);

        // Insert the product into the user_cart table, linked by email
        $insertSql = "INSERT INTO user_cart (product_name, user_email, product_id, imageUrl, description, size, order_quantity, order_amount) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $sqlLink->prepare($insertSql);
        $insertStmt->bind_param("ssisssid", $productName, $email, $productId, $imageUrl, $description, $size, $quantity, $orderAmount);

        if ($insertStmt->execute()) {
            echo '<script>alert("Item added to the cart."); window.location.href="cart/cart.php";</script>';
        } else {
            echo '<script>alert("Error adding item to cart.");</script>';
        }
    } else {
        echo '<script>alert("Product not found.");</script>';
    }
}


function calculateOrderAmount($quantity, $price, $size) {
    $extraCharge = 0;
    switch ($size) {
        case 'MEDIUM':
            $extraCharge = 10; // Extra charge for medium size
            break;
        case 'LARGE':
            $extraCharge = 20; // Extra charge for large size
            break;
    }
    return ($price + $extraCharge) * $quantity;
}




if (isset($_POST['checkout1'])) {
    $totalAmount = array_sum($_SESSION['orderamount'] ?? []);
    
    // Get the selected payment method
    $selectedPaymentMethod = $_POST['payment_method'] ?? 'COD';  // Default to 'COD' if nothing is selected
    
    // Get the current date for order date
    $orderDate = date('Y-m-d H:i:s');
    
    // Insert each order item separately
    foreach ($_SESSION['orderitems'] as $index => $item) {
        $productName = $item; // Product name with size
        $quantity = $_SESSION['orderqty'][$index]; // Quantity
        $orderAmount = $_SESSION['orderamount'][$index]; // Total amount for the product
        $size = $_SESSION['ordersize'][$index]; // Size
        $imageUrl = $_SESSION['orderimage'][$index]; // Product image URL
        
        // Assume 'pending_order' is the default status when an order is placed
        $orderStatus = 'Pending';

        // Generate a unique order ID
        $orderId = uniqid('order_', true);

        // Insert the order item into the database
        $query = "INSERT INTO orders (order_id, user_email, imageUrl, product_name, size, order_quantity, pending_order, payment_method, order_amount, order_status, order_date) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $sqlLink->prepare($query);

        // Ensure parameters are passed correctly with the correct types
        $stmt->bind_param("ssssdsdssss", $orderId, $email, $imageUrl, $productName, $size, $quantity, $orderAmount, $selectedPaymentMethod, $orderStatus, $orderDate);

        // Check if the query executed successfully
        if (!$stmt->execute()) {
            echo '<script>alert("Error placing order. Please try again.");</script>';
            $stmt->close();
            return; // Return if there's an error inserting an order item
        }
    }

    // Clear session data after successful order placement
    $_SESSION['orderqty'] = [];
    $_SESSION['orderamount'] = [];
    $_SESSION['orderitems'] = [];
    $_SESSION['ordersize'] = [];
    $_SESSION['orderimage'] = [];

    // Show success message and redirect to the user page
    echo '<script>alert("Order placed successfully!");</script>';
    header('Location: ../usermain.php'); // Redirect to user page after checkout
    exit(); // Ensure the script stops execution after redirection
}


// Clear cart
if (isset($_POST['clrcart'])) {
    // Clear session data for the cart
    $_SESSION['orderqty'] = [];
    $_SESSION['orderamount'] = [];
    $_SESSION['orderitems'] = [];

    // Get the user's email from the session
    $userEmail = $_SESSION['email'];

    // Prepare the SQL query to delete the cart items from the database
    $deleteQuery = "DELETE FROM user_cart WHERE user_email = ?";

    // Prepare and bind parameters to avoid SQL injection
    if ($stmt = $sqlLink->prepare($deleteQuery)) {
        $stmt->bind_param("s", $userEmail);

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            echo '<script>alert("Cart cleared successfully.");</script>';
        } else {
            echo '<script>alert("Error clearing the cart in the database.");</script>';
        }
        $stmt->close();
    } else {
        echo '<script>alert("Error preparing the delete query.");</script>';
    }

    // Redirect to the cart page after clearing the cart
    header("Location: cart.php");
    exit();
}
?>
