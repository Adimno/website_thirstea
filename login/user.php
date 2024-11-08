<?php
include "connection.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style.css">
	<title>Login and Register</title>
</head>
<body>
	
	<div class="container">
		<form action="validation.php" class="login active" name=login method="post" enctype="multipart/form-data">
			<h2 class="title">Login with your account</h2>
			<div class="form-group">
				<label for="email">Email</label>
				<div class="input-group">
					<input type="email" name="email" id="email" placeholder="Email address" name="email">
					<i class='bx bx-envelope'></i>
				</div>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<div class="input-group">
					<input type="password" name="password" pattern=".{6,}" id="password" placeholder="Your password">
					<i class='bx bx-lock-alt' ></i>
				</div>
				<span class="help-text">At least 8 characters</span>
			</div>
			<button type="submit" class="btn-submit">Login</button>
			<a href="#">Forgot password?</a>
			<p>I don't have an account. <a href="#" onclick="switchForm('register', event)">Register</a></p>
		</form>

		<form action="registration.php" class="register" method="post">
			<h2 class="title">Register your account</h2>
			<div class="form-group">
				<label for="name">Name</label>
				<div class="input-group">
					<input type="text" name="name" required>
					<span class="help-text">Enter your name</span>
				</div>
			</div>
			<div class="form-group">
				<label for="name">Address</label>
				<div class="input-group">
					<input type="text" name="address" required>
					<span class="help-text">Enter your address</span>
				</div>
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<div class="input-group">
					<input type="email" name="email" required>
					<i class='bx bx-envelope'></i>
				</div>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<div class="input-group">
					<input type="password" name="password" pattern=".{8,}"required>
					<i class='bx bx-lock-alt' ></i>
				</div>
				<span class="help-text">At least 8 characters</span>
			</div>
			<div class="form-group">
				<label for="confirm-pass">Confirm password</label>
				<div class="input-group">
					<input type="password" id="confirm-pass">
					<i class='bx bx-lock-alt' ></i>
				</div>
				<span class="help-text">Confirm password must be same with password</span>
			</div>
			<button type="submit" name="register" class="btn-submit">Register</button>
			<p>I already have an account. <a href="#" onclick="switchForm('login', event)">Login</a></p>
		</form>
	</div>
	
	<script src="script.js"></script>
</body>
</html>