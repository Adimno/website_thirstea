<?php
include "../add_to_cart.php";

// Assuming user email is stored in session upon login
$email = $_SESSION['email'];

// Fetch cart items for the user
$sql = "SELECT imageUrl, description, size, order_quantity, order_amount FROM user_cart WHERE user_email = ?";
$stmt = $sqlLink->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
$totalAmount = 0;

while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $totalAmount += $row['order_amount'];
}

$order_address = $_POST['order_address'] ?? ''; // Capture the address from the POST request

if (isset($_POST['checkout'])) {
    // Get the selected payment method
    $selectedPaymentMethod = $_POST['payment_method'] ?? 'COD';  // Default to 'COD' if nothing is selected

    // Get the current date for order date
    $orderDate = date('Y-m-d H:i:s');
    
     // Apply size-based price adjustment
     if ($size === 'Medium') {
        $orderAmount += 10; // Add 10 if size is Medium
    } elseif ($size === 'Large') {
        $orderAmount += 20; // Add 20 if size is Large
    }    
    // Assuming user email is stored in session upon login
    $email = $_SESSION['email'];

    // Process each cart item and insert into orders table
    foreach ($cartItems as $item) {
        $productName = $item['description']; // Product description (could be the name of the product)
        $quantity = $item['order_quantity']; // Quantity from cart
        $orderAmount = $item['order_amount']; // Total price for this product
        $size = $item['size']; // Size of the product
        $imageUrl = $item['imageUrl']; // Image URL for the product
        // Default order status as 'Pending'
        $orderStatus = 'Pending';

        // Generate a unique order ID
        $orderId = uniqid('order_', true);

        // Insert the order item into the database
        $query = "INSERT INTO orders (order_id, user_email, imageUrl, product_name, size, order_quantity, payment_method, order_amount, order_status, order_date, order_address)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the query
        $stmt = $sqlLink->prepare($query);

        // Bind the parameters
        $stmt->bind_param("sssssssssss", 
            $orderId, 
            $email, 
            $imageUrl, 
            $productName, 
            $size, 
            $quantity, 
            $selectedPaymentMethod, 
            $orderAmount, 
            $orderStatus, 
            $orderDate,
            $order_address);

        // Check if the query executed successfully
        if (!$stmt->execute()) {
            echo '<script>alert("Error placing order. Please try again.");</script>';
            $stmt->close();
            return; // Return if there's an error inserting an order item
        }
    }

    // Clear cart items after successful order placement
    $clearCartQuery = "DELETE FROM user_cart WHERE user_email = ?";
    $clearCartStmt = $sqlLink->prepare($clearCartQuery);
    $clearCartStmt->bind_param("s", $email);
    $clearCartStmt->execute();

    // Show success message and redirect to the user page
    echo '<script>
            alert("Order placed successfully!");
            window.location.href = "../usermain.php"; // Redirect to user page after checkout
          </script>';
    exit(); // Ensure the script stops execution after redirection
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Cart</title>
    <style>
        body {
            background-color: #f4f6f9;
        }
        .card {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .payment-icon {
            font-size: 1.5em;
            color: #007bff;
        }
        .btn-custom {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="row">
                <div class="col-md-8">
                    <h4><b>Items to Buy</b></h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($cartItems) > 0) {
                                foreach ($cartItems as $item) {
                                    echo '<tr>';
                                    echo '<td><img src="' . $item['imageUrl'] . '" alt="Product Image" width="100"></td>';
                                    echo '<td>' . htmlspecialchars($item['description']) . '</td>';
                                    echo '<td>' . htmlspecialchars($item['size']) . '</td>';
                                    echo '<td>' . htmlspecialchars($item['order_quantity']) . '</td>';
                                    echo '<td>&#8369; ' . number_format($item['order_amount'], 2) . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo "<tr><td colspan='5'>No items in the cart.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="../usermain.php" class="btn btn-secondary">Back to Shop</a>
                </div>

                <div class="col-md-4 summary">
    <h5><b>Summary</b></h5>
    <hr>
    <div>ITEMS: <?php echo count($cartItems); ?></div>
    <div class="mt-3">
     
    </div>
    <div class="row mt-3">
        <div class="col">TOTAL PRICE</div>
        <div class="col text-right">&#8369; <?php echo number_format($totalAmount, 2); ?></div>
    </div>

    <!-- The form is now correctly wrapping the input field for address -->
    <form action="checkout.php" method="POST">
        <!-- Move the input fields inside the form -->
        <div class="mt-3">
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control">
                <option value="COD" selected>Cash on Delivery (Free)</option>
                <!-- Add other payment methods if needed -->
            </select>
        </div>

        <div class="mt-3">
            <label for="order_address">Delivery Address</label>
            <input required type="text" name="order_address" id="order_address" class="form-control" placeholder="Enter your address">
        </div>

        <button class="btn-custom btn-block mt-4" name="checkout">Checkout</button>
    </form>
</div>

            </div>
        </div>
    </div>
</body>
</html>
