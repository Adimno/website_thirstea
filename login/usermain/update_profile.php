<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SaveChanges'])) {
    include "connection.php";
    $conn = mysqli_connect('localhost', 'root', '', 'thirstea');

    $name = $_POST['EditName'];
    $address = $_POST['EditAddress'];
    $email = $_POST['EditEmail'];
    $password = $_POST['EditPassword'];
    $confirmPassword = $_POST['EditConPassword'];
    $creditCard = $_POST['creditCard'];

    if ($password != $confirmPassword) {
        echo '<script>alert("Error: Passwords do not match.");</script>';
        echo '<script>window.location.href = "edit_profile.php";</script>';
        exit(); // Stop execution if passwords don't match
    } else {
        // Consider hashing the password before storing it
       

        $sql = "UPDATE users SET name='$name', address='$address', email='$email', password='$password', credit_card='$creditCard' WHERE email = '{$_SESSION['email']}'";
        $result = $conn->query($sql);
    }

    if ($result) {
        echo '<script>alert("Update Successful")</script>';
        session_destroy();
        unset($_SESSION['email']);
        header('location:../user.php');
    } else {
        echo '<script>alert("Error updating record:")</script>';
        header('location:./edit_profile.php');
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['TopButton'])){
	$conn = mysqli_connect('localhost', 'root', '', 'thirstea');
	
	$sqltopup = "SELECT Wallet FROM users WHERE email = '{$_SESSION['email']}'";
$resultop = $conn->query($sqltopup);
$topup = $resultop->fetch_assoc();

 $newTopup = $_POST['topqty'];

$topupamount = $topup['Wallet'] + $newTopup;

 $sqlwallet = "UPDATE users SET Wallet='$topupamount' WHERE email = '{$_SESSION['email']}'";
        $resultwallet = $conn->query($sqlwallet);
		
		
      
        header('location:./usermain.php');
  
	
	
}


?>
