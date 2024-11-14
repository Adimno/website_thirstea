<?php

session_start();

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'thirstea');

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get POST data from Flutter
$name = $_POST['name'];
$address = $_POST['address'];
$email = $_POST['email'];
$password = $_POST['password'];

// Role can be set based on conditions, for now we assign default 'user' role
// You can modify this logic to assign roles like 'cp' or 'admin' based on your criteria.
$role = 'user'; // Default role is 'user'

// Check if email already exists
$s = "SELECT * FROM `users` WHERE email = '$email'";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);

if ($num == 1) {
    // Email already exists
    echo json_encode(["status" => "error", "message" => "Email already in use"]);
} else {
    // Insert new user into the database with the role (default is 'user', you can change this)
    $reg = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `address`) 
            VALUES (NULL, '$name', '$email', '$password', '$role', '$address')";
    
    if (mysqli_query($con, $reg)) {
        echo json_encode(["status" => "success", "message" => "Registration successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . mysqli_error($con)]);
    }
}

// Close the connection
mysqli_close($con);
?>
