<?php
$conn = mysqli_connect('localhost', 'root', '', 'thirstea');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the mark_complete button is clicked
if (isset($_POST['mark_complete'])) {
    $orderId = $_POST['mark_complete'];  // Get the order ID from the form

    // Prepare the SQL query to update the order status to "Completed"
    $updateQuery = "UPDATE orders SET order_status = 'Completed' WHERE order_id = ?";

    // Prepare the query
    $stmt = $conn->prepare($updateQuery);  // Use $conn here, not $sqlLink

    // Bind the order_id to the query
    $stmt->bind_param('s', $orderId);  // Ensure order_id is bound as a string ('s')

    // Execute the query
    if ($stmt->execute()) {
        // Set a success message in session to trigger the pop-up
        session_start();
        $_SESSION['order_completed'] = true;

        // Redirect back to the adminmain.php page
        header('Location: adminmain.php');
        exit();
    } else {
        echo "Error updating order status.";
    }

    // Close the prepared statement
    $stmt->close();
}
?>
