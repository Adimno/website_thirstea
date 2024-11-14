<?php
session_start();

// Get email from POST data
$email = $_POST['email']; 

// Get other POST data
$productId = $_POST['product_id'];
$size = $_POST['size'];
$orderQuantity = $_POST['order_quantity'];
$price = $_POST['order_amount'];
$imageUrl = $_POST['imageUrl'];
$description = $_POST['description'];
$productName = $_POST['product_name'];

// Database connection
$sqlLink = mysqli_connect('localhost', 'root', '', 'thirstea');
if (!$sqlLink) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add to Cart
if (isset($_POST['add_to_cart'])) {

    // Check if product is already in the cart
    $checkQuery = "SELECT * FROM user_cart WHERE user_email = ? AND product_id = ?";
    $checkStmt = $sqlLink->prepare($checkQuery);
    $checkStmt->bind_param("si", $email, $productId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Product already in cart']);
    } else {
        // Get product details
        $sql = "SELECT product_name, price FROM product WHERE product_id = ?";
        $stmt = $sqlLink->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            $productName = $product['product_name'];
            $price = $product['price'];

            // Calculate order amount
            $orderAmount = calculateOrderAmount($orderQuantity, $price, $size);

            // Insert into user_cart
            $insertSql = "INSERT INTO user_cart (product_name, user_email, product_id, imageUrl, description, size, order_quantity, order_amount)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $sqlLink->prepare($insertSql);
            $insertStmt->bind_param("ssisssid", $productName, $email, $productId, $imageUrl, $description, $size, $orderQuantity, $orderAmount);

            if ($insertStmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Item added to the cart']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error adding item to cart']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
    }
}

function calculateOrderAmount($quantity, $price, $size) {
    $extraCharge = 0;
    switch ($size) {
        case 'SMALL':
            $extraCharge = 0;  // No extra charge for small size
            break;
        case 'MEDIUM':
            $extraCharge = 10; // Extra charge for medium size
            break;
        case 'LARGE':
            $extraCharge = 20; // Extra charge for large size
            break;
    }
    return ($price + $extraCharge) * $quantity;
}

if (isset($_POST['fetch_cart'])) {

    // Prepare the SQL query to fetch cart items for the user
    $fetchQuery = "SELECT * FROM user_cart WHERE user_email = ?";
    $fetchStmt = $sqlLink->prepare($fetchQuery);
    $fetchStmt->bind_param("s", $email);
    $fetchStmt->execute();
    $fetchResult = $fetchStmt->get_result();

    // Prepare an array to store cart items
    $cartItems = [];

    while ($row = $fetchResult->fetch_assoc()) {
        $cartItems[] = [
            'product_name' => $row['product_name'],
            'imageUrl' => $row['imageUrl'],
            'description' => $row['description'],
            'size' => $row['size'],
            'order_quantity' => $row['order_quantity'],
            'order_amount' => $row['order_amount'],
            'product_id' => $row['product_id'],
        ];
    }

    // Return the cart items as JSON
    if (count($cartItems) > 0) {
        echo json_encode(['success' => true, 'cart_items' => $cartItems]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cart is empty']);
    }
}

?>
