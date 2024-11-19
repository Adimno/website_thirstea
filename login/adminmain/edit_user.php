<?php
$sqlLink = mysqli_connect('localhost', 'root', '', 'thirstea');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $sqlLink->query("SELECT * FROM users WHERE id = '$id'");
    $row = $query->fetch_assoc();
}

// Update the user information
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    $updateQuery = "UPDATE users SET name='$name', email='$email', password='$password', address='$address', role='$role' WHERE id='$id'";
    mysqli_query($sqlLink, $updateQuery);
    header("Location: adminmain.php"); // Redirect back to admin page
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
    <div class="container mt-5">
           <!-- Center the card -->
    <div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Edit User</h3>
            </div>
            <div class="card-body">
                <?php if ($row !== null): ?> <!-- Ensure user data exists -->
                <form method="POST" action="">
                    <!-- Name -->
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>" required>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="text" name="password" class="form-control" value="<?= $row['password'] ?>" required>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label>Address:</label>
                        <input type="text" name="address" class="form-control" value="<?= $row['address'] ?>" required>
                    </div>

                    <!-- Role -->
                    <div class="form-group">
                        <label>Role:</label>
                        <select name="role" class="form-control">
                            <option value="Admin" <?= $row['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="User" <?= $row['role'] == 'User' ? 'selected' : '' ?>>User</option>
                        </select>
                    </div>

                    <!-- Submit and Back Buttons -->
                    <div class="text-center">
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <a href="./adminmain.php" class="btn btn-secondary">Back</a>
                    </div>
                </form>
                <?php else: ?>
                <p class="text-danger text-center">User not found.</p>
                <?php endif; ?>
            </div>
            </div>
            </div> <!-- End of Row -->
        </div>
    </div>
</body>
</html>
