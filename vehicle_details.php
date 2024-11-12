<?php
include('db_connect.php');
if (isset($_GET['ID'])) {
    $Vehicle_ID = $_GET['ID'];
} else {
    echo "Vehicle ID is missing.";
    exit;
}

// prevents SQL injection
$sql = "SELECT * FROM vehicles WHERE Vehicle_ID = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    // Handle error if prepare failed
    echo "Error preparing the SQL statement.";
    exit;
}
$stmt->bind_param("i", $Vehicle_ID);
$stmt->execute();
$result = $stmt->get_result();

// Check if the vehicle exists
if ($result->num_rows > 0) {
    $vehicle = $result->fetch_assoc(); // gets the vehicle details
} else {
    echo "Vehicle not found!"; // error message on not found
    exit;
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--makes the title the car thats being viewed-->
  <title> CarLand | <?php echo $vehicle['Vehicle_Make'] . ' ' . $vehicle['Vehicle_Model']; ?></title>
 
<!-- Bootstrap 4 CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">

<!-- FontAwesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>

<!-- Popper.js for Bootstrap tooltips and popovers -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>

<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
<!--bootstrap icons-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-sm">
        <a class="navbar-brand" href="index.php"><img src="images/carland2.png"></a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vehicles.php">Vehicles</span></a>
                </li> 
            </ul>
<?php
    session_start();
    if (isset($_SESSION['username'])) { 
        // if user is logged in then display logout button and wishlist button
        echo '
        <div class="dropdown">
            <button class="btn btn-outline-danger dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="images/Login-icon.png" alt="User Icon" class="login-icon">
                ' . htmlspecialchars($_SESSION['username']) . '
            </button>
            <div class="dropdown-menu" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">View Wishlist</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>';
    } else {
        // logged out user will see login button instead
        echo '
        <a href="login.php" class="btn btn-link login-btn">
        <i class="bi bi-box-arrow-in-right"></i> Log-in </a>
        </button>';
    }
?>
        </div>
    </nav>
<!-- back to vehicle list page -->
    <div class="back">
    <a href="vehicles.php"><span> &lt; </span> Back to vehicle listings</a>
</div>
    <!-- shows vehicle details from database in a box -->
    <div class="vehicle-details-container">
    <div class="vehicle-details-box">
        <h1><?php echo $vehicle['Vehicle_Make'] . ' ' . $vehicle['Vehicle_Model']; ?></h1>
        <img src="<?php echo $vehicle['Image']; ?>" alt="<?php echo $vehicle['Vehicle_Make'] . ' ' . $vehicle['Vehicle_Model']; ?>" style="max-width: 500px;">
        
        <p><span class="vehicle-attribute">Year:</span> <span class="vehicle-attribute-value"><?php echo $vehicle['Year']; ?></span></p>
        <p><span class="vehicle-attribute">Price:</span> <span class="vehicle-attribute-value">$<?php echo number_format($vehicle['Price'], 2); ?></span></p>
        <p><span class="vehicle-attribute">Fuel Type:</span> <span class="vehicle-attribute-value"><?php echo $vehicle['Fuel_Type']; ?></span></p>
        <p><span class="vehicle-attribute">Colour:</span> <span class="vehicle-attribute-value"><?php echo $vehicle['Colour']; ?></span></p>
        <p><span class="vehicle-attribute">Vehicle Type:</span> <span class="vehicle-attribute-value"><?php echo $vehicle['Vehicle_Type']; ?></span></p>
        <p><span class="vehicle-attribute">Safety Features:</span> <span class="vehicle-attribute-value"><?php echo $vehicle['Safety']; ?></span></p>
    </div>
</div>




<!-- boostrap 5 footer (found on geeks for geeks)-->
<footer class="footer">
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


</body>
</html>
