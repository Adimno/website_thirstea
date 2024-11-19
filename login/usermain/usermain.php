<?php
session_start();
include "connection.php";
$conn = mysqli_connect('localhost', 'root', '', 'thirstea');

$itemPrices = array();
$itemSpecials = array();
$itemSpecialsDes = array();

$query = "SELECT product_name, price, product_description FROM product";
$result = $conn->query($query);
$counter = 0;



// Check if user is logged in and fetch user details
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = "SELECT id, name, email FROM users WHERE email = '$email'"; // Ensure 'id' is also selected
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $id = $user['id'];  // Correctly fetch the 'id' from the result
        $fullName = $user['name'];  // User's full name
        $userEmail = $user['email'];  // User's email
    } else {
        // Handle the case if no user found
        echo "User not found.";
    }
} else {
    echo "User not logged in.";
}
include "add_to_cart.php";

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    echo '<script>alert("Logout Successful");</script>';
    header("location: ../../index.html");
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ThirsTea</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="popup.css">

	<link rel="stylesheet" type="text/css" href="usermainstyle.css">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	
	
</head>
<body>
	<!-- header section start -->
	<header id="site-header">
		<a href="#" class="logo"><img src="thirstealogo.png" width="100" height="100" alt="logo"></a>

		<nav class="navbar">
			<a href="#home">Home</a>
			<a href="#about">Services</a>
			<a href="#menu">Menu</a>
            <a href="#devs">Developers</a>
		</nav>

		<div class="icons">
			
			
        <a class="default" href="./orders.php"><i class="fas fa-box pe-2"></i></a>

			<a class="default" href="./profile.php"><i class="fas fa-circle-user"></i></a>
			
			<a class="default" href="cart/cart.php"><i class="fas fa-shopping-cart"></i></a>
			
			<a class="default" href="usermain.php?logout='1'"><i class="fas fa-door-open pe-2"></i></a>

		</div>
	</header>
	<!-- header section end -->

	<!-- slider section start -->
	<div class="home" id="home">
		<div class="swiper home-slider">
			<div class="swiper-wrapper wrapper">
				<div class="swiper-slide slide slide1">
					<div class="content">
						<h3>Yummy MilkTea.</h3>
						<h1>SHEEEEEEEEESHHHH!</h1>
						<p>
							You won't go wrong with these enjoyable and soothing teas!
						</p>
					</div>
				</div>

				<div class="swiper-slide slide slide2">
					
				</div>

				<div class="swiper-slide slide slide3">
					<div class="content">
						<h3>We Are Open</h3>
						<h1>Cold & Hot Drinks</h1>
						<p>
							you will love it
						</p>
					</div>
				</div>
			</div>

			<div class="swiper-pagination"></div>
		</div>
	</div>
	<!-- slider section ends -->

	<!-- welcome section start -->
	<section class="welcome" id="about">
		<h1 class="heading"><b>WELCOME TO THIRSTEA</b></h1>
		<center><h3 class="sub-heading"> ~ Services ~ </h3></center>

		<div class="box-container">
			<div class="box">
				<div class="content">
					<h3>PROFESSIONAL LEVEL</h3>
					<p>Welcome to Thirstea, where a passion for tea craftsmanship meets the art of flavor fusion. Our mission is to redefine your tea-drinking experience by offering a symphony of premium ingredients, artisanal techniques, and impeccable service.

                        At Thirstea, we take pride in curating a menu that caters to both traditionalists and adventurers seeking new, exciting flavors. Our extensive selection of loose-leaf teas, sourced from the finest tea gardens, ensures a diverse and authentic range of options. Whether you crave the robust depth of black tea, the delicate elegance of green tea, or the soothing allure of herbal infusions, our teas are the embodiment of quality.</p>

				</div>
			</div>

			<div class="box">
				<div class="content">
					<h3>PLACE ATMOSPHERE</h3>
					<p>Thirstea, a milk tea shop, is essential to attract and retain customers. The atmosphere should reflect the brand's identity, promote relaxation, and enhance the overall experience. Here's a description of the ideal place atmosphere for Thirstea:

                        Step into Thirstea, and you enter a haven of serenity and sensory delight. Our milk tea shop is designed to be an oasis of tranquility in the midst of the bustling world, where each visit is a pause for reflection and indulgence.</p>

				</div>
			</div>

			<div class="box">
				<div class="content">
					<h3>THE RESTO OPENING HOURS</h3>
					<p> Weekdays (Monday to Friday):
                        Morning Hours: 9:00 AM to 11:00 AM - Start your day with a refreshing tea.
                        Daytime Hours: 11:00 AM to 2:30 PM - Perfect for a lunchtime pick-me-up.
                        Afternoon Hours: 2:30 PM to 6:00 PM - Enjoy an afternoon tea break.
                        Evening Hours: 6:00 PM to 9:00 PM - Stay open for customers looking for a post-dinner treat.
                        
                        Weekends (Saturday and Sunday):
                        Morning Hours: 10:00 AM to 11:30 AM - Open a bit later on the weekends for those looking for a leisurely morning start.
                        Daytime Hours: 11:30 AM to 3:30 PM - Ideal for brunch and afternoon tea.
                        Late Afternoon Hours: 3:30 PM to 7:30 PM - Continue serving throughout the afternoon.
                        Evening Hours: 7:30 PM to 10:00 PM - Stay open a bit later for weekend social gatherings.</p>

				</div>
			</div>
		</div>
	</section>
	<!-- welcome ends -->

<!-- Our Menu Section -->
<section class="our-menu" id="menu">
    <div class="container">
        <div class="row">
            <div class="col-12 intro-text">
                <h1 class="heading text-white">Our Menu</h1>
                <center>
                    <h3>Looking for Refreshing Tea? Say no more, check out our most yummy and delightful drinks!</h3>
                </center>
            </div>
        </div>
    </div>

    <div class="container">
        <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-milktea-tab" data-bs-toggle="pill" data-bs-target="#pills-milktea"
                    type="button" role="tab" aria-controls="pills-milktea" aria-selected="true"><h3>Milk Tea</h3></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-fruittea-tab" data-bs-toggle="pill" data-bs-target="#pills-fruittea"
                    type="button" role="tab" aria-controls="pills-fruittea" aria-selected="true"><h3>Fruit Tea</h3></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-frappe-tab" data-bs-toggle="pill" data-bs-target="#pills-frappe"
                    type="button" role="tab" aria-controls="pills-frappe" aria-selected="true"><h3>Frappe</h3></button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            
            <!-- Milk Tea Tab -->
            <div class="tab-pane fade show active" id="pills-milktea" role="tabpanel" aria-labelledby="pills-milktea-tab" tabindex="0">
                <div class="row gy-3 justify-content-center">
                    <?php
                    $sql = "SELECT product_id, product_name, product_description, price, availability, ImageUrl FROM product WHERE category = 'Milktea' AND availability = 1";
                    $result = $sqlLink->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $productId = $row['product_id'];
                        $productName = $row['product_name'];
                        $description = $row['product_description'];
                        $price = $row['price'];
                        $availability = $row['availability'];
                        $imageUrl = $row['ImageUrl'];

                        if ($availability == 1) {
                            echo '
                            <div class="col-lg-3 col-sm-6">
                                <div class="menu-item bg-white shadow-on-hover">
                                    <img src="' . $imageUrl . '" width="250" height="250" alt="' . $productName . '">
                                    <div class="menu-item-content p-4">
                                        <div>
                                            <span>Rated(4.5)</span>
                                            <span class="stars">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-half-fill"></i>
                                            </span>
                                        </div>
                                        <h5 class="mt-1 mb-2">' . $productName . '</h5>
                                        <p class="small">' . $description . '</p>
                                        <div class="d-flex justify-content-center mb-2"><h3>&#8369;' . number_format($price, 2) . '</h3></div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <form action="add_to_cart.php" method="post">
                                            <input type="hidden" name="product_id" value="' . $productId . '">
                                            <input type="hidden" name="product_name" value="' . $productName . '">
                                            <input type="hidden" name="imageUrl" value="' . $imageUrl . '">
                                            <input type="hidden" name="description" value="' . $description . '">
                                            <select name="size" required>
                                                <option value="Small">SMALL</option>
                                                <option value="Medium">MEDIUM</option>
                                                <option value="Large">LARGE</option>
                                            </select>
                                            <hr>
                                            <input type="number" name="order_quantity" class="form-control input-number" required="required" min="1" value="1">
                                            <div class="d-flex justify-content-center mb-2">
                                                <button class="btn btn-primary" type="submit" name="add_to_cart">Add to Cart</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Fruit Tea Tab -->
            <div class="tab-pane fade" id="pills-fruittea" role="tabpanel" aria-labelledby="pills-fruittea-tab" tabindex="0">
                <div class="row gy-3 justify-content-center">
                    <?php
                    $sql = "SELECT product_id, product_name, product_description, price, availability, ImageUrl FROM product WHERE category = 'Fruitea' AND availability = 1";
                    $result = $sqlLink->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $productId = $row['product_id'];
                        $productName = $row['product_name'];
                        $description = $row['product_description'];
                        $price = $row['price'];
                        $availability = $row['availability'];
                        $imageUrl = $row['ImageUrl'];

                        if ($availability == 1) {
                            echo '
                            <div class="col-lg-3 col-sm-6">
                                <div class="menu-item bg-white shadow-on-hover">
                                    <img src="' . $imageUrl . '" width="250" height="250" alt="' . $productName . '">
                                    <div class="menu-item-content p-4">
                                        <div>
                                            <span>Rated(4.5)</span>
                                            <span class="stars">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-half-fill"></i>
                                            </span>
                                        </div>
                                        <h5 class="mt-1 mb-2">' . $productName . '</h5>
                                        <p class="small">' . $description . '</p>
                                        <div class="d-flex justify-content-center mb-2"><h3>&#8369;' . number_format($price, 2) . '</h3></div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <form action="add_to_cart.php" method="post">
                                            <input type="hidden" name="product_id" value="' . $productId . '">
                                            <input type="hidden" name="product_name" value="' . $productName . '">
                                            <input type="hidden" name="imageUrl" value="' . $imageUrl . '">
                                            <input type="hidden" name="description" value="' . $description . '">
                                            <select name="size" required>
                                                <option value="Small">SMALL</option>
                                                <option value="Medium">MEDIUM</option>
                                                <option value="Large">LARGE</option>
                                            </select>
                                            <hr>
                                            <input type="number" name="order_quantity" class="form-control input-number" required="required" min="1" value="1">
                                            <div class="d-flex justify-content-center mb-2">
                                                <button class="btn btn-primary" type="submit" name="add_to_cart">Add to Cart</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Frappe Tab -->
            <div class="tab-pane fade" id="pills-frappe" role="tabpanel" aria-labelledby="pills-frappe-tab" tabindex="0">
                <div class="row gy-3 justify-content-center">
                    <?php
                    $sql = "SELECT product_id, product_name, product_description, price, availability, ImageUrl FROM product WHERE category = 'Frappe' AND availability = 1";
                    $result = $sqlLink->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $productId = $row['product_id'];
                        $productName = $row['product_name'];
                        $description = $row['product_description'];
                        $price = $row['price'];
                        $availability = $row['availability'];
                        $imageUrl = $row['ImageUrl'];

                        if ($availability == 1) {
                            echo '
                            <div class="col-lg-3 col-sm-6">
                                <div class="menu-item bg-white shadow-on-hover">
                                    <img src="' . $imageUrl . '" width="250" height="250" alt="' . $productName . '">
                                    <div class="menu-item-content p-4">
                                        <div>
                                            <span>Rated(4.5)</span>
                                            <span class="stars">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-half-fill"></i>
                                            </span>
                                        </div>
                                        <h5 class="mt-1 mb-2">' . $productName . '</h5>
                                        <p class="small">' . $description . '</p>
                                        <div class="d-flex justify-content-center mb-2"><h3>&#8369;' . number_format($price, 2) . '</h3></div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <form action="add_to_cart.php" method="post">
                                            <input type="hidden" name="product_id" value="' . $productId . '">
                                            <input type="hidden" name="product_name" value="' . $productName . '">
                                            <input type="hidden" name="imageUrl" value="' . $imageUrl . '">
                                            <input type="hidden" name="description" value="' . $description . '">
                                            <select name="size" required>
                                                <option value="Small">SMALL</option>
                                                <option value="Medium">MEDIUM</option>
                                                <option value="Large">LARGE</option>
                                            </select>
                                            <hr>
                                            <input type="number" name="order_quantity" class="form-control input-number" required="required" min="1" value="1">
                                            <div class="d-flex justify-content-center mb-2">
                                                <button class="btn btn-primary" type="submit" name="add_to_cart">Add to Cart</button>
                                            </div>
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
    </div>
</section>


	<!-- our menu section ends -->

    <section class="welcome" id="devs">
		<h1 class="heading"><b>Meet The Devs!</b></h1>
		<center><h3 class="sub-heading"> ~ Developers ~ </h3></center>

		<div class="box-container">
			<div class="box">
				<div class="content">
					<h3>Santos, Gwen Aldrey C.</h3>
                    <img src="wen.png" width="200px" height="200px">
				</div>
			</div>

			<div class="box">
				<div class="content">
					<h3>Carlos, Franz Andrei E.</h3>
					<img src="franz.jpg" width="200px" height="200px">
				</div>
			</div>

			<div class="box">
				<div class="content">
					<h3>Barnes, Jake Eric </h3>
                    <img src="jake.png" width="200px" height="200px">
				</div>
            </div>

                <div class="box">
                    <div class="content">
                        <h3>Glorianne, Prince Charming</h3>
                        <img src="adik.jpg" width="200px" height="200px">
    
                    </div>
                </div>

                    <div class="box">
                        <div class="content">
                            <h3>Andaya, Aljhen Josh Hush</h3>
                            <img src="walangambag.png" width="200px" height="200px">
        
                        </div>
			</div>
		</div>

	</section>

	<!-- footer section start -->
	<section class="footer">
		<img src="thirstealogo.png" width="100" height="100" class="logo">

		<div class="container">
			<div>
				<h3>ABOUT US</h3>
				<p>Milk Tea Website masarap ito aTea!</p>
			</div>

			<div>
				<h3>GET NEWS & OFFERS</h3>
				<input type="email" name="" placeholder="enter your email">
				<ul>
					<li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
					<li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
					<li><a href="#"><i class="fa-brands fa-whatsapp"></i></a></li>
					<li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
				</ul>
			</div>

			<div>
				<h3>CONTACT US</h3>
				<span>ThirsTea!</span>
				<span>09969696969</span>
				<span>ThirsTeaOfficial@gmail.com</span>
				<span>www.ThirsTea.com</span>
			</div>
		</div>

		<p>&copy;2023 Reserved by Thirsteaters</p>
	</section>
	<!-- footer section end -->

	<!-- jump to top -->

	<a href="#"><button class="topbtn"><i class="fa-solid fa-angle-up"></i></button></a>
	



	<!-- Swiper JS -->
	

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
    <!-- Initialize Swiper -->
    <script>
      var swiper = new Swiper(".home-slider", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
          delay: 7500,
          disableOnInteraction: false,
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        loop:true,
      });
    </script>
	<script type="text/javascript">
		let menu = document.querySelector('#menu');
		let navbar = document.querySelector('.navbar');

		menu.onclick = () =>{
			menu.classList.toggle('fa-times');
			navbar.classList.toggle('active');
		}
	</script>
	


<script>
  window.addEventListener("scroll", function() {
    const header = document.getElementById("site-header");
    if (window.scrollY > 0) {
      header.style.display = "none";
    } else {
      header.style.display = "flex";
    }
  });
</script>





	
	
</body>
</html>