<!doctype html> 
<html lang="en"> 
<head>
    <title>CarLand | Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--Aos libary--> 
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">

<!-- FontAwesome for icons-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>

<!-- Popper.js for Bootstrap tooltips and popovers -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>

<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
<!--bootstrap icons-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!--stylesheet-->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- NAVBAR (boostrap) -->
    <nav class="navbar navbar-expand-sm">
        <a class="navbar-brand" href="index.php"><img src="images/carland2.png"></a> <!--Logo that links to home-->
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <!-- navbar links (link marked with "active" is page currently on) -->
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vehicles.php">Vehicles</a>
                </li>
            </ul>
            
<?php
    session_start();
    // check if user is logged in
    if (isset($_SESSION['username'])) {
        // if user is logged in then display logout button and wishlist button
        echo '
        <div class="dropdown">
            <button class="btn btn-outline-danger dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="images/Login-icon.png" alt="User Icon" class="login-icon">
                ' . htmlspecialchars($_SESSION['username']) . '
            </button>
            <div class="dropdown-menu" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="viewWishlist.php">View Wishlist</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>';
        // if the user isn't logged in, display login button instead
    } else {
        echo '
        <a href="login.php" class="btn btn-link login-btn">
        <i class="bi bi-box-arrow-in-right"></i> Log-in </a>
        </button>';
    }
?>
        </div>
    </nav>

 <!-- banner showing current sale -->
    <div class="banner" data-aos="fade-up" >
        <div class="bannerTxt">
        <h1> Chevrolet’s Cars up to 20% off!<br> Until 29/10/2024</h1>
        <a href="vehicles.php" class="btn">Shop Now</a>
        </div>
        <img src="images/bannerImg.png" alt="bannerImg" class="bannerImg">
    </div>

<!-- row column section showing supported car brands, that link to vehicle page-->
<div class="supportedcars" data-aos="fade-in">
    <h1> Our supported car brands </h1>
</div>
<div class="row">
    <div class="column" >
        <img src="images/ford.jpg" data-aos="zoom-in">
        <a href="vehicles.php"><h2>Ford Cars ></h2></a>
        <h4>From <span>$70,000</span> nzd</h4>
    </div>
    <div class="column">
        <img src="images/Jeep.jpg"data-aos="zoom-in">
        <a href="vehicles.php"><h2>Jeep Cars ></h2></a>
        <h4>From <span>$70,000</span> nzd</h4>
    </div>
    <div class="column">
        <img src=" images/honda.jpg"data-aos="zoom-in">
        <a href="vehicles.php"><h2>Honda Cars ></h2></a>
        <h4>From <span>$70,000</span> nzd</h4>
    </div>
    
    <div class="column">
        <img src=" images/subaru.jpg" data-aos="zoom-in">
        <a href="vehicles.php"><h2>Subaru Cars ></h2></a>
        <h4>From <span>$70,000</span> nzd</h4>
    </div>
    <div class="column">
        <img src=" images/Chevorlet.jpg" data-aos="zoom-in">
        <a href="vehicles.php"><h2>Chevorlet Cars ></h2></a>
        <h4>From <span>$70,000</span> nzd</h4>
    </div>
    <div class="column">
        <img src=" images/toyota.jpg" data-aos="zoom-in">
        <a href="vehicles.php"><h2>Toyota Cars ></h2></a>
        <h4>From <span>$70,000</span> nzd</h4>
    </div>

  </div>

  <!--banner 2, sends users to vehicle page--->
  <div class="banner2" data-aos="fade-up" >
    <div class="banner2Txt">
    <h1> Explore our catalog of cars!<br> <span>20,000</span> vehicles in stock</h1> 
    <a href="vehicles.php" class="btn">Shop Now</a>
    </div>

</div>

<!-- boostrap 5 footer (found on geeks for geeks)-->
<footer class="footer" data-aos="fade-in">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2>Carland</h2>
            </div>
            <div class="col-md-3">
                <h5>About Us</h5>
                <p>
                    Carland is the best carshop Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim
                    veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat.
               </p>
            </div>
            <div class="col-md-3">
                <h5>Contact Us</h5>
                <ul class="list-unstyled">
                    <li>Email: carland@gmail.com</li>
                    <li>Phone: 0800 815 6458</li>
                    <li>Address:  123 New Zealand Road, Hamilton, 3200</li>
                </ul>
            </div>
            <!-- social media links-->
            <div class="col-md-3">
                <h5>Follow Us</h5>
                <ul class="list-inline footer-links">
                    <li class="list-inline-item">
                        <a href="https://www.facebook.com">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://twitter.com">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.instagram.com">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://nz.linkedin.com">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        
</footer>
<script>
    AOS.init();
</script>
</body>
</html>