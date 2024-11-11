<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="editprofilestyle.css">
	<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
	<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js' rel='stylesheet'>
	<link href='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js' rel='stylesheet'>
	<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
	<title>Edit Profile</title>
</head>


<body>

<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
	<nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="./usermain.php">Back</a>
        
    </nav>
    
    <hr class="mt-0 mb-4">
    <div class="row">
       
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form action="update_profile.php" method="post">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="EditName">Name</label>
                            <input class="form-control" name="EditName" type="text" placeholder="Enter your username"  required>
                        </div>
                        <!-- Form Row-->
                      
                        <!-- Form Row        -->
                        <div class=" mb-3">
                            <!-- Form Group (organization name)-->
                           
                                <label class="small mb-1" for="EditAddress">Address</label>
                            <input class="form-control" name="EditAddress" type="text" placeholder="Enter your address"  required>
                           
                            <!-- Form Group (location)-->
                           
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="EditEmail">Email</label>
                            <input class="form-control" name="EditEmail" type="email" placeholder="Enter your email address"  required>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (phone number)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="EditPassword">Password</label>
                                <input class="form-control" name="EditPassword" type="password" placeholder="Enter your password"  required>
                            </div>
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="EditConPassword">Confirm Password</label>
                                <input class="form-control" pattern=".{8,}"  name="EditConPassword" type="password" placeholder="Confirm your password"  required>
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit" name="SaveChanges">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        // Format and limit credit card number as the user types
        $('#creditCard').on('input', function (e) {
            var inputValue = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters
            var formattedValue = formatCreditCard(inputValue);
            var maxLength = 16; // Set the maximum length for a credit card number

            // Limit the length of the input
            if (formattedValue.length > maxLength) {
                formattedValue = formattedValue.slice(0, maxLength);
            }

            $(this).val(formattedValue);
        });

        // Helper function to format credit card number
        function formatCreditCard(value) {
            var formattedValue = '';
            for (var i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            return formattedValue;
        }
    });
</script>




</body>
</html>