<?php

session_start();

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'thirstea');

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get POST data from the request (for example, from a Flutter app)
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the user exists in the database
$s = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($con, $s);
$row = mysqli_fetch_array($result);
$num = mysqli_num_rows($result);

if ($num == 1) {
    // If the user is found in the database
    $_SESSION['email'] = $email; // Store email in session

    // Check user role (admin, cp_user, or regular user)
    if ($row['admin'] == 1) {
        // If the user is an admin
        $_SESSION['role'] = 'admin'; // Store the user role in session for website navigation
        echo json_encode(array('status' => 'success', 'message' => 'Login successful', 'role' => 'admin'));
        // Redirect to admin page
        header('Location: adminmain/adminmain.php');
        exit(); // Make sure to stop the script after the redirect
    }  else {
        // If the user is a regular user
        $_SESSION['role'] = 'user'; // Store the user role in session for website navigation
        echo json_encode(array('status' => 'success', 'message' => 'Login successful', 'role' => 'user'));
        // Redirect to user page
        exit(); // Make sure to stop the script after the redirect
    }
} else {
    // If credentials are invalid, respond with an error message
    echo json_encode(array('status' => 'error', 'message' => 'Invalid email or password'));
}

// Close the database connection
mysqli_close($con);
?>
