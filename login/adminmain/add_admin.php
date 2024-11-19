<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
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
        .form-control, .btn {
            background-color: #333;
            color: white;
            border: 1px solid #444;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .form-group label {
            color: #ccc;
        }
    </style>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $address = $_POST["address"];

    $conn = mysqli_connect('localhost', 'root', '', 'thirstea');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO users (name, email, password, role, address) VALUES ('$name', '$email', '$password', '$role', '$address')";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("User added successfully!");</script>';
        header('location:./adminmain.php');
    } else {
        echo '<script>alert("Error adding user: ' . mysqli_error($conn) . '");</script>';
    }

    mysqli_close($conn);
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Add User</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <fieldset>
                            <legend>User Details</legend>

                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" name="name" placeholder="Enter full name" class="form-control" required type="text">
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name="email" placeholder="Enter user email" class="form-control" required type="email">
                            </div>

                                     <!-- Address -->
                           <div class="form-group">
                              <label for="address">Address</label>
                              <input id="address" name="address" placeholder="Enter address" class="form-control" required type="text">
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" name="password" placeholder="Enter password" class="form-control" required type="password">
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input id="confirm_password" name="confirm_password" placeholder="Re-enter password" class="form-control" required type="password">
                            </div>

                            <!-- Role Dropdown -->
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>

                   

                            <!-- Submit Button -->
                            <div class="form-group text-center">
                                <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save User</button>
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
