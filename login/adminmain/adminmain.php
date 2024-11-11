

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Thirstea | Admin</title>
    <meta name="description" content="Figma htmlGenerator">
    <meta name="author" content="htmlGenerator">
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="adstyles.css">
    <?php  
      session_start();

      if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['email']);
        echo '<script>alert("Logout Successful");</script>';
        header("location: ../../index.html");
      }

if (isset($_SESSION['order_completed']) && $_SESSION['order_completed'] === true) {
    echo '<script type="text/javascript">
            alert("Order has been marked as completed!");
          </script>';
    // Unset the session variable to prevent the pop-up from showing again on page reload
    unset($_SESSION['order_completed']);
}


    ?>
  </head>

  <body class="bg-dark text-white">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">Thirstea Admin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <button class="btn btn-outline-light" id="tusers">Users</button>
          </li>
          <li class="nav-item">
            <button class="btn btn-outline-light" id="tproducts">Products</button>
          </li>
          <li class="nav-item">
            <button class="btn btn-outline-light" id="tordersList">Orders</button>
          </li>
          <li class="nav-item">
            <a href="adminmain.php?logout='1'" class="btn btn-outline-light">Signout</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Content Sections -->
    <div class="container mt-5 pt-5">
      <!-- Users Section -->
      <div id="usersd" class="mb-5">
        <h2 class="mb-4">Account List:</h2>
        <a href="./add_admin.php" class="btn btn-primary mb-3">Add Admin</a>
        <table class="table table-bordered text-white">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Email</th>
              <th>Password</th>
              <th>Address</th>
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
                echo "<td><a href='adminmain.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td>";
                
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

      <!-- Products Section -->
      <div id="ords" class="mb-5" style="display: none;">
        <h2 class="mb-4">Product List:</h2>
        <a href="./add_product.php" class="btn btn-primary mb-3">Add More Products</a>
        <table class="table table-bordered table-dark text-white">
          <thead>
            <tr>
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
              $query1 = $sqlLink->query("SELECT * FROM product ORDER by product_id");
              while ($row1 = $query1->fetch_array()) {
                echo "<tr>";
                echo "<td><img src='" . $row1['imageUrl'] . "' width='50' height='50'></td>";
                echo "<td>" . $row1['product_name'] . "</td>";
                echo "<td>" . $row1['category'] . "</td>";
                echo "<td>" . $row1['product_description'] . "</td>";
                echo "<td> &#8369;" . $row1['price'] . "</td>";
                echo "<td>" . ($row1['availability'] == 1 ? "Available" : "Unavailable") . "</td>";
                echo "<td><a href='edit_product.php?id=" . $row1['product_id'] . "' class='btn btn-warning'>Edit</a></td>";
                echo "<td><a href='?delete_id=" . $row1['product_id'] . "' class='btn btn-danger'>Delete</a></td>";
                echo "</tr>";
                $counter++;
              }

              if (isset($_GET['delete_id'])) {
                $id = $_GET['delete_id'];
                $sqlDelete = "DELETE FROM product WHERE product_id='$id'";
                mysqli_query($sqlLink, $sqlDelete);
              }
            ?>
          </tbody>
        </table>
      </div>

     <!-- Orders Section -->
<div id="orders" class="mb-5" style="display: none;">
  <h2 class="mb-4">Order List:</h2>
  <table class="table table-bordered table-dark text-white">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>User Email</th>
        <th>Image</th>
        <th>Product Name</th>
        <th>Size</th>
        <th>Quantity</th>
        <th>Pending Order</th>
        <th>Payment Method</th>
        <th>Order Amount</th>
        <th>Order Date</th>
        <th>Status</th>
        <th>Action</th> <!-- Add a new column for the button -->
      </tr>
    </thead>
    <tbody>
      <?php
        $query2 = $sqlLink->query("SELECT * FROM orders ORDER BY order_date DESC");
        while ($row2 = $query2->fetch_array()) {
          echo "<tr>";
          echo "<td>" . $row2["order_id"] . "</td>";
          echo "<td>" . $row2["user_email"] . "</td>";
          echo "<td><img src='" . $row2['imageUrl'] . "' style='max-width: 100px; height: auto;'></td>";
          echo "<td>" . $row2['product_name'] . "</td>";
          echo "<td>" . $row2['size'] . "</td>";
          echo "<td>" . $row2['order_quantity'] . "</td>";
          echo "<td>" . $row2['pending_order'] . "</td>";
          echo "<td>" . $row2['payment_method'] . "</td>";
          echo "<td> &#8369;" . $row2['order_amount'] . "</td>";
          echo "<td>" . $row2['order_date'] . "</td>";
          echo "<td>" . $row2['order_status'] . "</td>";
      
          // Add the "Mark as Completed" button which sends data to update_order_status.php
          echo "<td><form method='POST' action='update_order_status.php'>
                    <button class='btn btn-success' name='mark_complete' value='" . $row2['order_id'] . "'>Mark as Completed</button>
                </form></td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</div>




    <script>
      // Default "Users" Tab is active
      $(document).ready(function() {
        $('#tusers').click(function() {
          $('#usersd').show();
          $('#ords').hide();
          $('#orders').hide();
        });

        $('#tproducts').click(function() {
          $('#ords').show();
          $('#usersd').hide();
          $('#orders').hide();
        });

        $('#tordersList').click(function() {
          $('#orders').show();
          $('#usersd').hide();
          $('#ords').hide();
        });

        // Set default display to Users
        $('#tproducts').click();
      });
    </script>
  </body>
</html>
