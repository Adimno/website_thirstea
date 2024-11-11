<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js' rel='stylesheet'>
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

                <div class="row">
                    <div class="row main align-items-center">
                        <table class="table table-bordered">
                            <tbody>
                                <?php
                                include "../add_to_cart.php";

                                // Check if 'orderitems' exists, is an array, and is not empty
                                if (isset($_SESSION['orderitems']) && is_array($_SESSION['orderitems']) && !empty($_SESSION['orderitems'])) {
                                    $orderItems = $_SESSION['orderitems'];
                                    $orderQty = isset($_SESSION['orderqty']) && is_array($_SESSION['orderqty']) ? $_SESSION['orderqty'] : [];
                                    $productimages = [];

                                    foreach ($orderItems as $orderItem) {
                                        $words = explode(' ', $orderItem);
                                        array_pop($words);
                                        $productimages[] = implode(' ', $words);
                                    }

                                    $count = count($orderItems);
                                    for ($i = 0; $i < $count; $i++) {
                                        $item = $orderItems[$i];
                                        $qty = isset($orderQty[$i]) ? $orderQty[$i] : 1;
                                        $itemname = $productimages[$i];
                                        $sessionId = $itemname;

                                        $currentQty = isset($_SESSION[$sessionId . 'QTY']) ? $_SESSION[$sessionId . 'QTY'] : $qty;
                                        echo '<form method="post" action="update_quantity.php">
                                        <div class="row main align-items-center">
                                            <div class="col-2"><img class="img-fluid" src="../'.$itemname.'.jpg"></div>
                                            <div class="col">
                                                <div class="row">'.$item.'</div>
                                            </div>
                                            <div class="col">
                                                <input type="hidden" name="session_id" value="'.$sessionId.'">
                                                <input type="number" name="quantity" value="'.$currentQty.'" min="1" oninput="validity.valid||(value=\'\');">
                                                <button type="submit" class="btn btn-primary edit-btn" name="edit_submit">Edit</button>
                                            </div>
                                        </div></form>';
                                    }
                                } else {
                                    // Display message if there are no items in the order
                                    echo "No items in the order.";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="back-to-shop"><a href="../usermain.php">&leftarrow;</a><span class="text-muted">Back to shop</span></div>
            </div>

            <div class="col-md-4 summary">
                <div><h5><b>Summary</b></h5></div>
                <hr>
                <div class="row">
                    <?php
                    // Check if 'orderitems' exists and is an array
                    $orderItems = isset($_SESSION['orderitems']) && is_array($_SESSION['orderitems']) ? $_SESSION['orderitems'] : [];
                    $count = count($orderItems);

                    if ($count === 0) {
                        echo '
                        <div class="col" style="padding-left:0;">NO ITEMS</div>';
                    } else {
                        echo '
                        <div class="col" style="padding-left:0;">ITEMS: ' . $count . '</div>';
                    }
                    ?>
                </div>

                <form method="post" action="">
                    <p>PAYMENT</p>

                    <select id="payment_method" name="payment_method" >
                        <option value="COD">CASH-ON-DELIVERY- &#8369;FREE</option>
                    </select>

             
                    <?php
                    
                    echo '<div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">';

                    // Check if 'orderamount' exists and is an array, otherwise set $totalamount to 0
                    $totalamount = isset($_SESSION['orderamount']) && is_array($_SESSION['orderamount']) ? array_sum($_SESSION['orderamount']) : 0;

                    if ($totalamount == 0) {
                        echo '<div class="col">NO ITEMS</div>';
                    } else {
                        echo '
                            <div class="col">TOTAL PRICE</div>
                            <div id="total-amount" class="col text-right">&#8369;' . $totalamount . '</div>
                        </div>';

                        echo '<form action="" method="post">
                            <button class="btn" name="clrcart">CLEAR</button>
                            <button class="btn" name="checkout" id="checkoutButton">CHECKOUT</button>
                        </form>';
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
