<?php

session_start();

$con=mysqli_connect('localhost','root', '');
	 mysqli_select_db($con,'thirstea');

$email = $_POST['email'];
$address = $_POST['address'];
$password = $_POST['password'];
$name = $_POST['name'];

$s = " SELECT * FROM `users` where email = '$email'";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);
if ($num == 1){
	echo '<script>alert("Email already in use")</script>';
}
else{
	$reg = " INSERT INTO `users` (`id`, `name` , `email`, `password`, `admin`, `address`) VALUES (NULL,'$name', '$email', '$password', 0, '$address');";
	mysqli_query($con, $reg);
	echo '<script>alert("Registration Succesful")</script>';
	?>
	<script type="text/javascript">
	window.location="user.php";
	</script>
	<?php
}

?>
