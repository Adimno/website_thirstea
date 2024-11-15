<?php
session_start();

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'thirstea');

// Check connection
if (!$con) {
    die(json_encode(["success" => false, "message" => "Database connection failed: " . mysqli_connect_error()]));
}

if (isset($_GET['email']) && !empty($_GET['email'])) {
    $email = $_GET['email'];

    // Prepare the SQL statement
    $stmt = $con->prepare("
        SELECT imageUrl, product_name, size, order_amount, order_quantity, order_status, order_date 
        FROM orders 
        WHERE user_email = ?
    ");

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($imageUrl, $product_name, $size, $order_amount, $order_quantity, $order_status, $order_date);

        $orders = [];
        while ($stmt->fetch()) {
            $orders[] = [
                "imageUrl" => $imageUrl,
                "product_name" => $product_name,
                "size" => $size,
                "order_amount" => $order_amount,
                "order_quantity" => $order_quantity,
                "order_status" => $order_status,
                "order_date" => $order_date, // Optionally format this date
            ];
        }
        $stmt->close();

        if (!empty($orders)) {
            echo json_encode([
                "success" => true,
                "orders" => $orders
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "No orders found for this email"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Failed to prepare SQL statement"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Email not provided"]);
}

$con->close();
?>
