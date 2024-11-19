<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('You must be logged in to view your orders.'); window.location.href = '../login.php';</script>";
    exit();  // Redirect to login if not logged in
}

$email = $_SESSION['email']; // Get email from session

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'thirstea');

// Check connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Prepare and execute the query to fetch orders based on the user's email
$query = "SELECT imageUrl, product_name, size, order_amount, order_quantity, order_status, order_date, order_address 
          FROM orders 
          WHERE user_email = ? 
          ORDER BY order_date DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($imageUrl, $product_name, $size, $order_amount, $order_quantity, $order_status, $order_date, $order_address);

// Store the fetched orders in an array
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
        "order_address" => $order_address
    ];
}

// Close the statement
$stmt->close();

// Close the database connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>My Orders</title>
</head>
<body>
    <div class="container mt-5">
        <h3>Your Orders</h3>
        <hr>

        <?php if (count($orders) > 0): ?>
            <div class="list-group">
                <?php foreach ($orders as $order): ?>
                    <div class="list-group-item">
                        <h5>Product: <?php echo htmlspecialchars($order['product_name']); ?></h5>
                        <p><strong>Size:</strong> <?php echo htmlspecialchars($order['size']); ?></p>
                        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($order['order_quantity']); ?></p>
                        <p><strong>Amount:</strong> &#8369; <?php echo number_format($order['order_amount'], 2); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['order_status']); ?></p>
                        <p><strong>Order Date:</strong> <?php echo date("F j, Y", strtotime($order['order_date'])); ?></p> <!-- Format the date if needed -->
                        <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['order_address']); ?></p>
                        <?php if ($order['imageUrl']): ?>
                            <p><img src="<?php echo htmlspecialchars($order['imageUrl']); ?>" alt="Product Image" style="width:100px;height:auto;"></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>You have no orders yet.</p>
        <?php endif; ?>

        <a href="usermain.php" class="btn btn-primary mt-3">Back to Shop</a>
    </div>
</body>
</html>
