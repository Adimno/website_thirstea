<?php
$conn = mysqli_connect('localhost', 'root', '', 'thirstea');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_POST['email'];
$name = $_POST['name'];
$address = $_POST['address'];
$password = $_POST['password'];

if (!empty($password)) {
    $query = "UPDATE users SET name = '$name', address = '$address', password = '$password' WHERE email = '$email'";
} else {
    $query = "UPDATE users SET name = '$name', address = '$address' WHERE email = '$email'";
}

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
}

mysqli_close($conn);
?>
