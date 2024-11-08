<?php
session_start();
$conn = mysqli_connect('localhost', 'root','' , 'thirstea');

$email = $_SESSION['email'];


$sqlname = "SELECT name FROM users WHERE email = '$email'";
$result1 = $conn->query($sqlname);
$nameU = $result1->fetch_assoc();

$sqladd = "SELECT address FROM users WHERE email = '$email'";
$result2 = $conn->query($sqladd);
$addressU = $result2->fetch_assoc();

$sqltop = "SELECT Wallet FROM users WHERE email = '$email'";
$result3 = $conn->query($sqltop);
$topup = $result3->fetch_assoc();

?>

<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	
	<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
	<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js' rel='stylesheet'>
	<link href='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js' rel='stylesheet'>
	<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
	<title>Profile</title>
</head>


<body>

<section style="background-color: #eee;">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./usermain.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="row">
      
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
			  
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
			  <?php
			  echo '
                <p class="text-muted mb-0">'. $nameU['name'] .'</p>
				'
				 ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
			  <?php
			  echo '
                <p class="text-muted mb-0">'. $_SESSION['email'] .'</p>
				'
				?>
              </div>
            </div>
            <hr>
            
            
            
            
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Address</p>
              </div>
              <div class="col-sm-9">
			  <?php
			  echo '
                <p class="text-muted mb-0">'. $addressU['address'] .'</p>'
				?>
              </div>
            </div>
			
			<hr>
			 <div class="d-flex justify-content-center mb-2">
             <a href="./edit_profile.php" class="btn btn-primary">Edit</a>

              
            </div>
          </div>
        </div>
		<?php
		$conn = mysqli_connect('localhost', 'root','' , 'thirstea');
   
   
            $query = "SELECT credit_card FROM users WHERE email = '$email'";
			
			$result = $conn->query($query);
			
			 if ($result && $row = $result->fetch_assoc()) {
                $creditCard = $row['credit_card'];

                
                if (!empty($creditCard)) {
                   echo'<div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
			  
                <p class="mb-0">WALLET AMOUNT:</p>
              </div>
              <div class="col-sm-9">
			 
			  
                <p class="text-muted mb-0">'. $topup['Wallet'] .'</p>
				
				
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">TOPUP AMOUNT:</p>
              </div>
              <div class="col-sm-9">
			  
			  <form action="update_profile.php" method="post">
                <p class="text-muted mb-0"><input type="number" name="topqty" min="0" oninput="validity.valid||(value=\'\');"></p>
				
				
              </div>
            </div>
            <hr>
            
            
            
            
            
			
			<hr>
			 <div class="d-flex justify-content-center mb-2">
			 
             <button class="btn btn-primary" type="submit" name="TopButton">TOP UP</button>
			 </form>

              
            </div>
          </div>
        </div>';
		
                }
            }
			
		
		?>
		
		
		
        
      </div>
    </div>
  </div>
</section>


</body>
</html>