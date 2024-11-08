<?php
 session_start();
if (isset($_POST['edit_submit'])) {
    $sessionId = $_POST['session_id'];
    $newQty = $_POST['quantity'];
	$currentQty = isset($_SESSION[$sessionId . 'QTY']) ? $_SESSION[$sessionId . 'QTY'] : 0;
    $pricePerItem = isset($_SESSION[$sessionId]) ? $_SESSION[$sessionId] : 0;

if ($newQty !== $currentQty) {
     if ($newQty > $currentQty) {
        // If the new quantity is greater than the current one, calculate the new price
        $newPrice = $newQty * $pricePerItem;
    } else {
        // If the new quantity is less than or equal to the current one, calculate the new price with a negative value
        $newPrice = $newQty * (-$pricePerItem);

        // Set the session variable to a negative value
       
    }
}
	 $_SESSION[$sessionId . 'QTY'] = $newQty;
	 
   
	 array_push($_SESSION['orderamount'], $newPrice);
	 header('Location: cart.php');
    exit();
}
?>
