<?php

require '../../vendor/autoload.php'; // Include Cloudinary SDK

use Cloudinary\Cloudinary;
use \Cloudinary\Uploader;
// Database connection
$con = mysqli_connect('localhost', 'root', '', 'thirstea');

// Check if connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize Cloudinary
$cloudinary = new Cloudinary([ 
    'cloud' => [
        'cloud_name' => 'dxhoqm4st', 
        'api_key' => '643428899293169', 
        'api_secret' => '5OLnAOFkZBA26O8A5MtAeRlW_Vc',
    ]
]);

// Check if the product ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product data from the database
    $query = mysqli_query($con, "SELECT * FROM product WHERE id = $id");
    $product = mysqli_fetch_array($query);
}

// Handle the form submission for updating the product
if (isset($_POST['edit_product'])) {
    $name = mysqli_real_escape_string($con, $_POST['product_name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $description = mysqli_real_escape_string($con, $_POST['product_description']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $availability = mysqli_real_escape_string($con, $_POST['availability']); // Fetch availability status
    $imageUrl = $product['imageUrl']; // Default imageUrl, in case no new image is uploaded.

    // Check if a new image is uploaded
    if (isset($_FILES['filebutton']) && $_FILES['filebutton']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['filebutton']['tmp_name'];

        // Upload image to Cloudinary
        try {
            $uploadResult = $cloudinary->uploadApi()->upload($fileTmpPath, [
                "folder" => "products/"  // Specify the folder in Cloudinary
            ]);

            $imageUrl = $uploadResult['secure_url']; // Get the URL of the uploaded image
        } catch (Exception $e) {
            echo "Error uploading image: " . $e->getMessage();
        }
    }

    // Update the product in the database
    $updateQuery = "UPDATE product SET product_name = '$name', category = '$category', product_description = '$description', price = $price, availability = $availability, imageUrl = '$imageUrl' WHERE id = $id";
    if (mysqli_query($con, $updateQuery)) {
        header('Location: adminmain.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container my-5">
    <!-- Center the card -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Card for the form -->
            <div class="card">
                <div class="card-header text-center">
                    <h3>Edit Product</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <fieldset>
                            <legend>Product Details</legend>

                            <!-- Product Name -->
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" name="product_name" value="<?= $product['product_name'] ?>" class="form-control" required>
                            </div>

                            <!-- Category -->
                            <div class="form-group">
                                   <label for="category">Category</label>
                                       <select id="category" name="category" class="form-control" required>
                                          <option value="">Select Category</option>
                                          <option value="Milktea" <?= $product['category'] == 'Milktea' ? 'selected' : '' ?>>Milktea</option>
                                          <option value="Fruitea" <?= $product['category'] == 'Fruitea' ? 'selected' : '' ?>>Fruitea</option>
                                          <option value="Frappe" <?= $product['category'] == 'Frappe' ? 'selected' : '' ?>>Frappe</option>
                                       </select>
                                  </div>
                            <!-- Product Description -->
                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea name="product_description" class="form-control" required><?= $product['product_description'] ?></textarea>
                            </div>

                            <!-- Price -->
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" value="<?= $product['price'] ?>" class="form-control" required>
                            </div>

                            <div class="form-group">
                               <label for="availability">Availability</label>
                              <select name="availability" class="form-control">
                                <option value="1" <?= $product['availability'] == 1 ? 'selected' : '' ?>>Available</option>
                             <option value="0" <?= $product['availability'] == 0 ? 'selected' : '' ?>>Unavailable</option>
                              </select>
                          </div>

                            <!-- Image Upload -->
                            <div class="form-group">
                                <label for="filebutton">Product Image</label>
                                <input type="file" name="filebutton" class="form-control-file">
                                <small class="form-text text-muted">Leave this empty to keep the current image.</small>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group text-center">
                                <button type="submit" name="edit_product" class="btn btn-primary">Update Product</button>
                            </div>
                        </fieldset>
                    </form>

                    <!-- Back Button -->
                    <div class="form-group text-center">
                        <a href="./adminmain.php">
                            <button class="btn btn-secondary">Back</button>
                        </a>
                    </div>
                </div>
            </div> <!-- End of Card -->
        </div>
    </div> <!-- End of Row -->
</div> <!-- End of Container -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
