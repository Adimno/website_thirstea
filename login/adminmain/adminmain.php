<html lang="en">
          <head>
            <meta charset="utf-8">
          
            <title>Thirstea|Admin</title>
            <meta name="description" content="Figma htmlGenerator">
            <meta name="author" content="htmlGenerator">
            <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
			
			<link href="css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
 
 
 
 
 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

            <link rel="stylesheet" href="adstyles.css">
            <?php  
			
			if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['email']);
	echo '<script>alert("Logout Successful");</script>';
  	header("location: ../../index.html");
  }
			
			
			?>
          
          
          </head>
          
          <body>
            <div class=e36_8>
			<div  class="e36_12">
			<div class=e36_19>
			<button class=e36_20 id="tusers"><span  class="e36_21">USERS</span></button>
			</div>
			<div class=e36_13>
			
			<div class=e36_14><a href="adminmain.php?logout='1'"><span  class="e36_15">Signout</span></a></div>
			</div>
			<div class=e36_16>
			<button class=e36_17 id="torders"><span  class="e36_18">PRODUCTS</span></button>
			</div>
			
			
			
			
			</div>
			
			
			
			</div>
			
				
	<div class="u1" id="usersd" style="background-image: url('gets.jpg'); background-repeat: no-repeat; background-size: cover; padding: 20px;">
    <div class="col-lg-12">
        <h2>Account List:</h2>
        <a href="./add_admin.php" class="btn btn-primary">Add Admin</a>
        <table class="table table-hover" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Address</th>
                    <th>Pending Order</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlLink = mysqli_connect('localhost', 'root', '', 'thirstea');
                $query = $sqlLink->query("SELECT * FROM users ORDER by id");
                while($row = $query->fetch_array()){
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["password"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>" . $row["pending_items"] . "</td>";
                    if (!empty($row["pending_items"])) {
                        echo "<td> <a href='adminmain.php?id2=" . $row['id'] . "' class='btn btn-primary'>Complete Order</a></td>";
                    } else {
                        echo "<td> <a href='adminmain.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td>";
                    }
                    echo "</tr>";
                }

                if (isset($_GET['id'])){
                    $id = $_GET['id'];
                    $sqld = "DELETE FROM users WHERE id='$id'";
                    mysqli_query($sqlLink, $sqld);
                }

                if (isset($_GET['id2'])){
                    $id = $_GET['id2'];
                    $sqld = "UPDATE users SET cart_items = pending_items, pending_items = '' WHERE id='$id'";
                    mysqli_query($sqlLink, $sqld);
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

      <div class=u1 id="ords" style="background-image: url('gets.jpg');background-repeat: no-repeat; background-size: cover">
    <div class="col-lg-12">
        <h2>Product List:</h2>
        <a href="./add_product.php" class="btn btn-primary">Add More Products</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Availability</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 0;
                
                $query1 = $sqlLink->query("SELECT * FROM product ORDER by id");
                while ($row1 = $query1->fetch_array()) {
                    echo "<tr>";
                    echo "<td>" . $row1['id'] . "</td>";
                    echo "<td><img src='" . $row1['imageUrl'] . "' width='50' height='50'></td>";
                    echo "<td>" . $row1['product_name'] . "</td>";
                    echo "<td>" . $row1['category'] . "</td>";
                    echo "<td>" . $row1['product_description'] . "</td>";
                    echo "<td> &#8369;" . $row1['price'] . "</td>";
                    
                    if ($row1['availability'] == 1) {
                      echo "<td>1 (Available)</td>";
                  } else {
                      echo "<td>0 (Unavailable)</td>";
                  }
                    
                    // Edit button (will navigate to a new page or open a modal for editing)
                    echo "<td><a href='edit_product.php?id=" . $row1['id'] . "' class='btn btn-warning'>Edit</a></td>";
                    
                    // Delete button
                    echo "<td><a href='?delete_id=" . $row1['id'] . "' class='btn btn-danger'>Delete</a></td>";
                    
                    echo "</tr><br>";
                    $counter++;
                }
                ?>

                <?php
                // Handling price update
                if (isset($_POST['new_priceEdit'])) {
                    $id = $_POST['product_id'];
                    $new_price = $_POST['new_price'];
                    $sqlUpdate = "UPDATE product SET price = $new_price WHERE id = '$id'";
                    mysqli_query($sqlLink, $sqlUpdate);
                }

                // Handling product availability
                if (isset($_GET['id1'])) {
                    $id = $_GET['id1'];
                    $sqlUpdate = "UPDATE product SET availability = 0 WHERE id = '$id'";
                    mysqli_query($sqlLink, $sqlUpdate);
                }

                if (isset($_GET['id2'])) {
                    $id = $_GET['id2'];
                    $sqlUpdate = "UPDATE product SET availability = 1 WHERE id = '$id'";
                    mysqli_query($sqlLink, $sqlUpdate);
                }

                // Deleting a product
                if (isset($_GET['delete_id'])) {
                    $id = $_GET['delete_id'];
                    $sqlDelete = "DELETE FROM product WHERE id='$id'";
                    mysqli_query($sqlLink, $sqlDelete);
                }

                
                ?>
            </tbody>
        </table>
    </div>
</div>

			</div>
			
		
      <script>
    const udiv = document.getElementById("usersd");
    const ubtn = document.getElementById("tusers");
    const udiv2 = document.getElementById("ords");
    const ubtn2 = document.getElementById("torders");

    // Set the product list to be displayed by default
    udiv.style.display = "none";
    udiv2.style.display = "block"; // Show the product list initially

    // Hide/show the users section and products section based on button clicks
    ubtn.onclick = function () {
        if (udiv.style.display === "none") {
            udiv.style.display = "block";
            udiv2.style.display = "none"; // Hide products
        } else {
            udiv.style.display = "none"; // Hide users
        }
    };

    ubtn2.onclick = function () {
        if (udiv2.style.display === "none") {
            udiv2.style.display = "block";
            udiv.style.display = "none"; // Hide users
        } else {
            udiv2.style.display = "none"; // Hide products
        }
    };
</script>

          </body>
          </html>