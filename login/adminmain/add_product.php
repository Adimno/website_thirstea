<?php
require '../../vendor/autoload.php'; // Include Cloudinary SDK

use Cloudinary\Cloudinary;
use \Cloudinary\Uploader;

// Cloudinary API credentials
$cloudinary = new Cloudinary([
  'cloud' => [
      'cloud_name' => 'dxhoqm4st',
      'api_key' => '643428899293169',
      'api_secret' => '5OLnAOFkZBA26O8A5MtAeRlW_Vc',
  ]
]);

// Connect to the database first
$conn = mysqli_connect('localhost', 'root', '', 'thirstea');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $price = mysqli_real_escape_string($conn, $_POST["price"]);
    $product_description = mysqli_real_escape_string($conn, $_POST["product_description"]);
    $category = mysqli_real_escape_string($conn, $_POST["category"]);
    $availability = isset($_POST["availability"]) ? 1 : 0; // Checkbox for availability

    // Check if an image is uploaded
    if (isset($_FILES["filebutton"]) && $_FILES["filebutton"]["error"] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES["filebutton"]["tmp_name"];
        
        // Upload image to Cloudinary
        try {
            $uploadResult = $cloudinary->uploadApi()->upload($fileTmpPath, [
                "folder" => "products/"  // Optionally specify the folder where images will be stored in Cloudinary
            ]);

            // Get the URL of the uploaded image
            $imageUrl = $uploadResult['secure_url']; 

            // Insert product data into the database
            $sql = "INSERT INTO product (category, product_name, price, product_description, imageUrl, availability) 
                    VALUES ('$category', '$product_name', '$price', '$product_description', '$imageUrl', '$availability')";
            
            // Execute the query
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Product added successfully")</script>';
                header('location:./adminmain.php');
            } else {
                echo '<script>alert("Error updating record: ' . mysqli_error($conn) . '")</script>';
                header('location:./add_product.php');
            }

        } catch (Exception $e) {
            echo "Error uploading image: " . $e->getMessage();
        }
    } else {
        echo "No file uploaded or there was an error with the file upload.";
    }
}

// Close the database connection (done after all operations are complete)
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
          body {
            background-color: #2c2f38; /* Dark background */
            color: white; /* Light text */
        }
        .card {
            background-color: #1e1e1e;
            border: none;
        }
        .card-header {
            background-color: #333;
            color: white;
        }
        .form-control, .form-check-label, .btn {
            background-color: #333;
            color: white;
            border: 1px solid #444;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .form-group label {
            color: #ccc;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Add Product</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                        <fieldset>
                            <legend>Product Details</legend>

                            <!-- Product Name -->
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input id="product_name" name="product_name" placeholder="Product Name" class="form-control" required type="text">
                            </div>

                            <!-- Category -->
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select id="category" name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="Milktea">Milktea</option>
                                    <option value="Fruitea">Fruitea</option>
                                    <option value="Frappe">Frappe</option>
                                </select>
                            </div>

                            <!-- Product Description -->
                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea class="form-control" id="product_description" name="product_description" rows="3"></textarea>
                            </div>

                            <!-- Price -->
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input id="price" name="price" placeholder="Price" class="form-control" required type="number">
                            </div>

                            <!-- Image Upload -->
                            <div class="form-group">
                                <label for="filebutton">Product Image</label>
                                <input id="filebutton" name="filebutton" class="form-control-file" type="file">
                            </div>

                            <!-- Availability Checkbox -->
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="availability" name="availability" checked>
                                <label class="form-check-label" for="availability">Available</label>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group text-center">
                                <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save Product</button>
                            </div>
                        </fieldset>
                    </form>

                    <!-- Back Button -->
                    <div class="form-group text-center">
                        <a href="./adminmain.php">
                            <button id="BACKbutton" name="BACKbutton" class="btn btn-secondary">Back</button>
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
