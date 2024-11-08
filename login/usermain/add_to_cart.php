<?php


$email=$_SESSION['email'];

$SpecialArray= $_SESSION['Specials'];

 




 
 $sqlLink = mysqli_connect('localhost', 'root','' , 'thirstea');
 
 
 
 if (isset($_POST['SpecialCart'])) {
    foreach ($_SESSION['Specials'] as $productInfo) {
        $productNameKey = 'productName';
        $priceKey = 'price';
		$_SESSION[$productInfo[$productNameKey]]=$productInfo[$priceKey];

      
$quantSpec = $_POST[$productInfo[$productNameKey] . 'QTY'];

        if ($_POST['size'] == 'REGULAR') {
            $oramSpec = $quantSpec * $productInfo[$priceKey];
            array_push($_SESSION['orderamount'], $oramSpec);
        } elseif ($_POST['size'] == 'MEDIUM') {
            $oramSpec = $quantSpec * $productInfo[$priceKey] + 20;
            array_push($_SESSION['orderamount'], $oramSpec);
        } elseif ($_POST['size'] == 'LARGE') {
            $oramSpec = $quantSpec * $productInfo[$priceKey] + 50;
            array_push($_SESSION['orderamount'], $oramSpec);
        }

        array_push($_SESSION['orderqty'], $quantSpec);

        array_push($_SESSION['orderitems'], "{$productInfo[$productNameKey]} {$_POST['size']}");

        echo '<script>alert("Item added to the cart.");</script>';
		$_SESSION['Specials'] = [];
    }
}



 
 
 
 
 
if (isset($_POST['atcSalted'])){
	$quantSalted=$_POST['quantSalted'];
	
	
	if ($_POST['size'] == 'REGULAR') {
        $oram=$quantSalted*$_SESSION['Salted Caramel Tea'];
		
	array_push($_SESSION['orderamount'], $oram);
    }
	
	elseif ($_POST['size'] == 'MEDIUM') {
		$oram=($quantSalted*$_SESSION['Salted Caramel Tea'])+20;
		
		
	array_push($_SESSION['orderamount'], $oram);
        
    }
	
	elseif ($_POST['size'] == 'LARGE') {
		$oram=($quantSalted*$_SESSION['Salted Caramel Tea'])+50;
		
	array_push($_SESSION['orderamount'], $oram);
        
    }
	
	
	array_push($_SESSION['orderqty'], $quantSalted);

	array_push($_SESSION['orderitems'], "Salted Caramel Tea {$_POST['size']}");
	  
	  echo '<script>alert("Item added to the cart.");</script>';
  }
  
  if (isset($_POST['atcmatcha'])){
	  $quantMatcha=$_POST['quantMatcha'];
	  
	  if ($_POST['size'] == 'REGULAR') {
		  $oram1=$quantMatcha*$_SESSION['Matcha Latte Milk Tea'];
        array_push($_SESSION['orderamount'], $oram1);
    }
	
	elseif ($_POST['size'] == 'MEDIUM') {
		$oram1=($quantMatcha*$_SESSION['Matcha Latte Milk Tea'])+20;
        array_push($_SESSION['orderamount'], $oram1);
    }
	
	elseif ($_POST['size'] == 'LARGE') {
		$oram1=($quantMatcha*$_SESSION['Matcha Latte Milk Tea'])+50;
        array_push($_SESSION['orderamount'], $oram1);
    }
	  
	  
	
	array_push($_SESSION['orderqty'], $quantMatcha);
	

	array_push($_SESSION['orderitems'], "Matcha Latte Milk Tea {$_POST['size']}");
	  
	  echo '<script>alert("Item added to the cart.");</script>';
  }
  
   if (isset($_POST['atcvanilla'])){
	   $quantVanilla=$_POST['quantVanilla'];
	   
	   if ($_POST['size'] == 'REGULAR') {
		   $oram2=$quantVanilla*$_SESSION['Vanilla Sweet Milk Tea'];
        array_push($_SESSION['orderamount'], $oram2);
    }
	
	elseif ($_POST['size'] == 'MEDIUM') {
		$oram2=($quantVanilla*$_SESSION['Vanilla Sweet Milk Tea'])+20;
        array_push($_SESSION['orderamount'], $oram2);
    }
	
	elseif ($_POST['size'] == 'LARGE') {
		$oram2=($quantVanilla*$_SESSION['Vanilla Sweet Milk Tea'])+50;
        array_push($_SESSION['orderamount'], $oram2);
    }
	   
	  
	
	array_push($_SESSION['orderqty'], $quantVanilla);
	

	array_push($_SESSION['orderitems'], "Vanilla Sweet Milk Tea {$_POST['size']}");
	  
	  echo '<script>alert("Item added to the cart.");</script>';
  }
  
  
  if (isset($_POST['atclemon'])){
	   $quantLemon=$_POST['quantLemon'];
	  
	  if ($_POST['size'] == 'REGULAR') {
		  $oram3=$quantLemon*$_SESSION['Lemon Iced Tea'];
		  array_push($_SESSION['orderamount'], $oram3);
        
    }
	
	elseif ($_POST['size'] == 'MEDIUM') {
		$oram3=($quantLemon*$_SESSION['Lemon Iced Tea'])+20;
		array_push($_SESSION['orderamount'], $oram3);
        
    }
	
	elseif ($_POST['size'] == 'LARGE') {
		$oram3=($quantLemon*$_SESSION['Lemon Iced Tea'])+50;
		array_push($_SESSION['orderamount'], $oram3);
        
    }
	  
	    
	
	array_push($_SESSION['orderqty'], $quantLemon);
	

	array_push($_SESSION['orderitems'], "Lemon Iced Tea {$_POST['size']}");
	  
	  echo '<script>alert("Item added to the cart.");</script>';
  }
  
  if (isset($_POST['atcorange'])){
	  $quantOrange=$_POST['quantOrange'];
	  
	  if ($_POST['size'] == 'REGULAR') {
		  $oram4=$quantOrange*$_SESSION['Orange Iced Tea'];
		  array_push($_SESSION['orderamount'], $oram4);
        
    }
	
	elseif ($_POST['size'] == 'MEDIUM') {
		$oram4=($quantOrange*$_SESSION['Orange Iced Tea'])+20;
		array_push($_SESSION['orderamount'], $oram4);
        
    }
	
	elseif ($_POST['size'] == 'LARGE') {
		$oram4=($quantOrange*$_SESSION['Orange Iced Tea'])+50;
		
		array_push($_SESSION['orderamount'], $oram4);
        
    }
	  
	   
	
	array_push($_SESSION['orderqty'], $quantOrange);
	

	array_push($_SESSION['orderitems'], "Orange Iced Tea {$_POST['size']}");
	  
	  echo '<script>alert("Item added to the cart.");</script>';
  }
  
  if (isset($_POST['atcpineapple'])){
	   $quantPineapple=$_POST['quantPineapple'];
	  
	  if ($_POST['size'] == 'REGULAR') {
        $oram5=$quantPineapple*$_SESSION['Pineapple Iced Tea'];
		array_push($_SESSION['orderamount'], $oram5);
    }
	
	elseif ($_POST['size'] == 'MEDIUM') {
		 $oram5=($quantPineapple*$_SESSION['Pineapple Iced Tea'])+20;
        array_push($_SESSION['orderamount'], $oram5);
    }
	
	elseif ($_POST['size'] == 'LARGE') {
		$oram5=($quantPineapple*$_SESSION['Pineapple Iced Tea'])+50;
        array_push($_SESSION['orderamount'], $oram5);
    }
	  
	
	array_push($_SESSION['orderqty'], $quantPineapple);
	

	array_push($_SESSION['orderitems'], "Pineapple Iced Tea {$_POST['size']}");
	  
	  echo '<script>alert("Item added to the cart.");</script>';
  }
  
   if (isset($_POST['atciced'])){
	    $quantIced=$_POST['quantIced'];
	   if ($_POST['size'] == 'REGULAR') {
        $oram6=$quantIced*$_SESSION['Iced Chickolet Frappe'];
		array_push($_SESSION['orderamount'], $oram6);
    }
	
	elseif ($_POST['size'] == 'MEDIUM') {
		 $oram6=($quantIced*$_SESSION['Iced Chickolet Frappe'])+20;
        array_push($_SESSION['orderamount'], $oram6);
    }
	
	elseif ($_POST['size'] == 'LARGE') {
		$oram6=($quantIced*$_SESSION['Iced Chickolet Frappe'])+50;
        array_push($_SESSION['orderamount'], $oram6);
    }
	   
	    
	
	array_push($_SESSION['orderqty'], $quantIced);

	array_push($_SESSION['orderitems'], "Iced Chickolet Frappe {$_POST['size']}");
	  
	  echo '<script>alert("Item added to the cart.");</script>';
  }
  
  

  
  if (isset($_POST['atcjava'])){
	  $quantJava=$_POST['quantJava'];
	  
	  if ($_POST['size'] == 'REGULAR') {
		   $oramjava=$quantJava* $_SESSION['JavaChipsie Frappe'];
		   array_push($_SESSION['orderamount'], $oramjava);
        
    }
	
	elseif ($_POST['size'] == 'MEDIUM') {
		$oramjava=($quantJava* $_SESSION['JavaChipsie Frappe'])+20;
         array_push($_SESSION['orderamount'], $oramjava);
    }
	
	elseif ($_POST['size'] == 'LARGE') {
		$oramjava=($quantJava* $_SESSION['JavaChipsie Frappe'])+50;
         array_push($_SESSION['orderamount'], $oramjava);
    }
array_push($_SESSION['orderqty'], $quantJava);
	array_push($_SESSION['orderitems'], "JavaChipsie Frappe {$_POST['size']}");
	  
	  echo '<script>alert("Item added to the cart.");</script>';
  }
  
 
  
  if (isset($_POST['atctriple'])){
	   $quantTriple=$_POST['quantTriple'];
	  if ($_POST['size'] == 'REGULAR') {
        $oram7=$quantTriple*$_SESSION['Triple Mocha Frappe'];
		array_push($_SESSION['orderamount'], $oram7);
    }
	
	elseif ($_POST['size'] == 'MEDIUM') {
		 $oram7=($quantTriple*$_SESSION['Triple Mocha Frappe'])+20;
        array_push($_SESSION['orderamount'], $oram7);
    }
	
	elseif ($_POST['size'] == 'LARGE') {
		 $oram7=($quantTriple*$_SESSION['Triple Mocha Frappe'])+50;
        array_push($_SESSION['orderamount'], $oram7);
    }
	  
	   
	
	array_push($_SESSION['orderqty'], $quantTriple);

	array_push($_SESSION['orderitems'], "Triple Mocha Frappe {$_POST['size']}");
	  
	  echo '<script>alert("Item added to the cart.");</script>';
  }
  
  if (isset($_POST['checkout'])){
	  $totalamount= 0+array_sum($_SESSION['orderamount']);
	  $combinedArray = array();
	  
	
	 
foreach ($_SESSION['orderitems'] as $index => $item) {
    $quantity = $_SESSION['orderqty'][$index];
    $combinedArray[] = $item . ' ' . $quantity;
}


$combinedArray[] = 'Total Price: ' . $totalamount;

	 $cartItemsString = implode(', ', $combinedArray);
	 
	  $selectedPaymentMethod = $_POST['payment_method'];
	  
	  if ($selectedPaymentMethod == 'E-WALLET') {
		  $sqltopup = "SELECT Wallet FROM users WHERE email = '{$_SESSION['email']}'";
$resultop = $sqlLink->query($sqltopup);
$topup = $resultop->fetch_assoc();
		  $paywallet = $topup['Wallet'] - $totalamount;
		  if ($paywallet >= 0){
	
		  $updateQuery1 = "UPDATE users SET Wallet = ? WHERE email = ?";
    $stmt2 = $sqlLink->prepare($updateQuery1);
    $stmt2->bind_param("ss", $paywallet, $email);
    $stmt2->execute();
    $stmt2->close();
	
	echo '<script>alert("Checkout Successful");</script>';
	 $_SESSION['orderqty'] = [];
    $_SESSION['orderamount'] = [];
    $_SESSION['orderitems'] = [];
	header('location: ../usermain.php');
			  
		  }
		  else {
    // Insufficient funds, display alert and cancel the transaction
    echo '<script>alert("Insufficient funds. Transaction canceled.");</script>';
    header('location: ../usermain.php'); // Redirect or handle accordingly
}
		  
		 
        
    }
	
	else{
		
		  $updateQuery = "UPDATE users SET pending_items = ? WHERE email = ?";
    $stmt1 = $sqlLink->prepare($updateQuery);
    $stmt1->bind_param("ss", $cartItemsString, $email);
    $stmt1->execute();
    $stmt1->close();
	
	
	echo '<script>alert("Checkout Successful");</script>';
	 $_SESSION['orderqty'] = [];
    $_SESSION['orderamount'] = [];
    $_SESSION['orderitems'] = [];
	header('location: ../usermain.php');
		
	}
	  
	
  }
  
  
  if (isset($_POST['clrcart'])){
	  $_SESSION['orderqty'] = [];
    $_SESSION['orderamount'] = [];
    $_SESSION['orderitems'] = [];

   
    header("Location: cart.php");
  }
?>

