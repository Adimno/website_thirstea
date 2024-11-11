<?php
session_start();

$email = $_SESSION['email'];
$specialArray = $_SESSION['Specials'] ?? [];

$sqlLink = mysqli_connect('localhost', 'root', '', 'thirstea');

// Helper function for calculating order amount based on size
function calculateOrderAmount($quantity, $basePrice, $size) {
    switch ($size) {
        case 'MEDIUM':
            return $quantity * $basePrice + 20;
        case 'LARGE':
            return $quantity * $basePrice + 50;
        default:
            return $quantity * $basePrice;
    }
}

// Process special cart items
if (isset($_POST['SpecialCart'])) {
    foreach ($specialArray as $productInfo) {
        $productName = $productInfo['productName'];
        $price = $productInfo['price'];
        $quantity = $_POST[$productName . 'QTY'];
        $size = $_POST['size'];

        $orderAmount = calculateOrderAmount($quantity, $price, $size);
        $_SESSION['orderamount'][] = $orderAmount;
        $_SESSION['orderqty'][] = $quantity;
        $_SESSION['orderitems'][] = "{$productName} {$size}";

        echo '<script>alert("Item added to the cart.");</script>';
    }
    $_SESSION['Specials'] = [];
}

// Define products for individual item adds
$products = [
    'atcSalted' => ['name' => 'Salted Caramel Tea', 'quantity' => $_POST['quantSalted'] ?? 0],
    'atcmatcha' => ['name' => 'Matcha Latte Milk Tea', 'quantity' => $_POST['quantMatcha'] ?? 0],
    'atcvanilla' => ['name' => 'Vanilla Sweet Milk Tea', 'quantity' => $_POST['quantVanilla'] ?? 0],
    'atclemon' => ['name' => 'Lemon Iced Tea', 'quantity' => $_POST['quantLemon'] ?? 0],
    'atcorange' => ['name' => 'Orange Iced Tea', 'quantity' => $_POST['quantOrange'] ?? 0],
    'atcpineapple' => ['name' => 'Pineapple Iced Tea', 'quantity' => $_POST['quantPineapple'] ?? 0],
    'atciced' => ['name' => 'Iced Chickolet Frappe', 'quantity' => $_POST['quantIced'] ?? 0],
    'atcjava' => ['name' => 'JavaChipsie Frappe', 'quantity' => $_POST['quantJava'] ?? 0],
    'atctriple' => ['name' => 'Triple Mocha Frappe', 'quantity' => $_POST['quantTriple'] ?? 0],
];

// Process individual item add-to-cart actions
foreach ($products as $postKey => $product) {
    if (isset($_POST[$postKey])) {
        $quantity = $product['quantity'];
        $size = $_POST['size'];
        $price = $_SESSION[$product['name']] ?? 0;

        if ($price) {
            $orderAmount = calculateOrderAmount($quantity, $price, $size);
            $_SESSION['orderamount'][] = $orderAmount;
            $_SESSION['orderqty'][] = $quantity;
            $_SESSION['orderitems'][] = "{$product['name']} {$size}"; // Add product and size
            echo '<script>alert("Item added to the cart.");</script>';
        }
    }
}

// Checkout process
if (isset($_POST['checkout'])) {
    $totalAmount = array_sum($_SESSION['orderamount'] ?? []);
    
    // Get the selected payment method
    $selectedPaymentMethod = $_POST['payment_method'] ?? 'COD';  // Default to 'COD' if nothing is selected

    // Insert each order item separately
    foreach ($_SESSION['orderitems'] as $index => $item) {
        $productName = $item; // Product name with size
        $quantity = $_SESSION['orderqty'][$index]; // Quantity
        $orderAmount = $_SESSION['orderamount'][$index]; // Total amount for the product

        // Insert the order item into the database
        $query = "INSERT INTO orders (user_email, order_items, order_quantity, order_amount, payment_method) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $sqlLink->prepare($query);

        // Ensure parameters are passed correctly with the correct types
        $stmt->bind_param("ssds", $email, $productName, $quantity, $orderAmount, $selectedPaymentMethod);

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

    // Show success message and redirect to the user page
    echo '<script>alert("Order placed successfully!");</script>';
    header('Location: ../usermain.php'); // Redirect to user page after checkout
    exit(); // Ensure the script stops execution after redirection
}


// Clear cart
if (isset($_POST['clrcart'])) {
    $_SESSION['orderqty'] = [];
    $_SESSION['orderamount'] = [];
    $_SESSION['orderitems'] = [];
    header("Location: cart.php");
}
?>
