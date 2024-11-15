<?php
session_start();

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'thirstea');

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $stmt = $con->prepare("SELECT name, address FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($name, $address);
    $stmt->fetch();
    $stmt->close();
    
    if ($name && $address) {
        echo json_encode([
            "success" => true,
            "name" => $name,
            "address" => $address
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Email not provided"]);
}

$con->close();
?>
