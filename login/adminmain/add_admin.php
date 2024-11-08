<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ThirsTea</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	
	
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
   $admin=1;

  
            
          
            $conn = mysqli_connect('localhost', 'root', '', 'thirstea');
            $sql = "INSERT INTO users (email, password, admin) VALUES ('$email', '$password', '$admin')";
            
            $result = $conn->query($sql);

            if ($result) {
                echo '<script>alert("Update Successful")</script>';
                header('location:./adminmain.php');
            } else {
                echo '<script>alert("Error updating record:")</script>';
                header('location:./add_admin.php');
            }
         
    }
	

?>


<form class="form-horizontal" method="post" action="" >
<fieldset>


<legend>ADD ADMIN</legend>




<div class="form-group">
  <label class="col-md-4 control-label" for="product_name">EMAIL</label>  
  <div class="col-md-4">
  <input id="product_name" name="email" placeholder="EMAIL" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="product_name">PASSWORD</label>  
  <div class="col-md-4">
  <input id="product_name" name="password" placeholder="PASSWORD" class="form-control input-md" required="" type="text">
    
  </div>
</div>




<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">SAVE</button>
  </div>
  
  </div>
  </fieldset>
</form>
  <div class="form-group">
  <label class="col-md-4 control-label" for="BACKbutton"></label>
  <div class="col-md-4">
   <a href="./adminmain.php" > <button id="BACKbutton" name="BACKbutton" class="btn btn-primary">BACK</button></a>
  </div>
  </div>



</body>
</html>