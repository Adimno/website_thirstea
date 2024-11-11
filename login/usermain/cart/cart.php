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


if (isset($_POST['checkout'])) {
    // Get the selected payment method
    $selectedPaymentMethod = $_POST['payment_method'] ?? 'COD';  // Default to 'COD' if nothing is selected

    // Get the current date for order date
    $orderDate = date('Y-m-d H:i:s');

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
        $query = "INSERT INTO orders (order_id, user_email, imageUrl, product_name, size, order_quantity, payment_method, order_amount, order_status, order_date)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the query
        $stmt = $sqlLink->prepare($query);

        // Bind the parameters
        // Corrected parameter types: s = string, i = integer, d = double
        $stmt->bind_param("ssssssssss", 
            $orderId, 
            $email, 
            $imageUrl, 
            $productName, 
            $size, 
            $quantity, 
            $selectedPaymentMethod, 
            $orderAmount, 
            $orderStatus, 
            $orderDate
        );

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
    echo '<script>alert("Order placed successfully!");</script>';
    header('Location: ../usermain.php'); // Redirect to user page after checkout
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
</head>
<body>
    <div class="card">
        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col"><h4><b>Shopping Cart</b></h4></div>
                    </div>
                </div>

                <div class="row main align-items-center">
                <table class="table table-bordered">
    <tbody>
        <?php
        if (count($cartItems) > 0) {
            foreach ($cartItems as $item) {
                // Get image size using getimagesize
                $imageUrl = $item['imageUrl'];
                list($width, $height) = getimagesize($imageUrl); // Get the original width and height

                echo '<tr>';
                echo '<td><img src="' . $imageUrl . '" alt="Product Image" width="2000" height ="100"></td>';
                echo '<td>
                        <p>' . htmlspecialchars($item['description']) . '</p>
                      </td>';
                echo '<td>' . htmlspecialchars($item['size']) . '</td>';
                echo '<td>Quantity: ' . htmlspecialchars($item['order_quantity']) . '</td>';
                echo '<td>Price: &#8369;' . number_format($item['order_amount'], 2) . '</td>';
                echo '</tr>';
            }
        } else {
            echo "<tr><td colspan='5'>No items in the cart.</td></tr>";
        }
        ?>
    </tbody>
</table>

</div>

                <div class="back-to-shop"><a href="../usermain.php">&leftarrow;</a><span class="text-muted">Back to shop</span></div>
            </div>

            <div class="col-md-4 summary">
    <div><h5><b>Summary</b></h5></div>
    <hr>
    <div class="row">
        <div class="col" style="padding-left:0;">ITEMS: <?php echo count($cartItems); ?></div>
    </div>
        <!-- Payment method dropdown -->
        <div class="row" style="padding: 1vh 0;">
        <div class="col">
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control">
                <option value="COD" selected>Cash on Delivery (Free)</option>
                <!-- <option value="CreditCard">Credit Card</option>
                <option value="Paypal">PayPal</option> -->
                <!-- Add other payment methods here -->
            </select>
        </div>
    </div>
    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
        <div class="col">TOTAL PRICE</div>
        <div id="total-amount" class="col text-right">&#8369;<?php echo number_format($totalAmount, 2); ?></div>
    </div>



    <!-- Submit the checkout form -->
    <form action="" method="post">
        <button class="btn" name="clrcart">CLEAR</button>
        <button class="btn" name="checkout" id="checkoutButton">CHECKOUT</button>
    </form>
</div>

        </div>
    </div>
</body>
</html>
