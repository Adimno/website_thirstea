<?php
include "../add_to_cart.php";

// Assuming user email is stored in session upon login
$email = $_SESSION['email'];

// Update quantity if form is submitted
if (isset($_POST['update_quantity'])) {
    $newQuantity = $_POST['quantity'];
    $productId = $_POST['product_id']; // Assuming you have a unique product ID for each cart item

    // Get the price of the product
    $priceQuery = "SELECT price FROM product WHERE product_id = ?";
    $priceStmt = $sqlLink->prepare($priceQuery);
    $priceStmt->bind_param("i", $productId);
    $priceStmt->execute();
    $priceResult = $priceStmt->get_result();
    $product = $priceResult->fetch_assoc();

    if ($product) {
        $price = $product['price'];

        // Recalculate order amount based on the new quantity
        $orderAmount = $price * $newQuantity;

        // Update quantity and order amount in the database
        $updateQuery = "UPDATE user_cart SET order_quantity = ?, order_amount = ? WHERE user_email = ? AND product_id = ?";
        $stmt = $sqlLink->prepare($updateQuery);
        $stmt->bind_param("idis", $newQuantity, $orderAmount, $email, $productId);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch cart items for the user
$sql = "SELECT product_id, imageUrl, description, size, order_quantity, order_amount FROM user_cart WHERE user_email = ?";
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
                echo '<td><img src="' . $item['imageUrl'] . '" alt="Product Image" width="100" height="100"></td>';
                echo '<td><p>' . htmlspecialchars($item['description']) . '</p></td>';
                echo '<td>' . htmlspecialchars($item['size']) . '</td>';
                echo '<td>
                        <form method="POST" action="">
                            <input type="number" name="quantity" value="' . htmlspecialchars($item['order_quantity']) . '" min="1" required>
                            <input type="hidden" name="product_id" value="' . htmlspecialchars($item['product_id']) . '">
                            <button type="submit" name="update_quantity" class="btn btn-primary">Update</button>
                        </form>
                      </td>';
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
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col">TOTAL PRICE</div>
                    <div id="total-amount" class="col text-right">&#8369;<?php echo number_format($totalAmount, 2); ?></div>
                </div>

                <form action="" method="post">
                    <button class="btn" name="clrcart">CLEAR</button>
                    <a href="checkout.php" class="btn" id="checkoutButton">CHECKOUT</a>
                </form>
            </div>

        </div>
    </div>
</body>
</html>
