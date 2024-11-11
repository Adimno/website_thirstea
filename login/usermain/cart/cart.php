<?php

include "../add_to_cart.php"; // Adjust the path if necessary

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

// Checkout Logic
if (isset($_POST['checkout'])) {
    // Get total amount from session or calculate directly from cart items
    $totalAmount = array_sum(array_column($cartItems, 'order_amount'));

    // Get the selected payment method
    $selectedPaymentMethod = $_POST['payment_method'] ?? 'COD'; // Default to 'COD'

    // Insert each order item into the orders table
    foreach ($cartItems as $item) {
        $productName = $item['description']; // Product description as name
        $quantity = $item['order_quantity']; // Quantity from the cart
        $orderAmount = $item['order_amount']; // Order amount from the cart

        // Insert the order item into the database
        $query = "INSERT INTO orders (user_email, order_items, order_quantity, order_amount, payment_method) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $sqlLink->prepare($query);

        // Ensure parameters are passed correctly with the correct types
        $stmt->bind_param("ssdss", $email, $productName, $quantity, $orderAmount, $selectedPaymentMethod);

        // Check if the query executed successfully
        if (!$stmt->execute()) {
            echo '<script>alert("Error placing order. Please try again.");</script>';
            $stmt->close();
            return;
        }
    }

    // Clear the cart after successful order placement
    $clearCartQuery = "DELETE FROM user_cart WHERE user_email = ?";
    $clearStmt = $sqlLink->prepare($clearCartQuery);
    $clearStmt->bind_param("s", $email);
    $clearStmt->execute();
    $clearStmt->close();

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
                                    echo '<tr>';
                                    echo '<td><img class="img-fluid" src="' . $item['imageUrl'] . '" width="500" height="500"></td>';
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
                <p>PAYMENT</p>
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col">TOTAL PRICE</div>
                    <div id="total-amount" class="col text-right">&#8369;<?php echo number_format($totalAmount, 2); ?></div>
                </div>

                <form action="" method="post">
                    <button class="btn" name="clrcart">CLEAR</button>
                    <button class="btn" name="checkout" id="checkoutButton">CHECKOUT</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
