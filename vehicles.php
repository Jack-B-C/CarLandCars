<?php 
//starts php session and connects to database
session_start(); 
include('db_connect.php'); 

// Check if the user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// gets vehicles from the database
$query = "SELECT * FROM vehicles";  
$result = $conn->query($query);
$vehicles = $result->fetch_all(MYSQLI_ASSOC);

// Define the current page for pagination (creates/deletes new page when vehicles on database are above/below 6 on the given page) 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$vehiclesPerPage = 6;
$totalVehicles = count($vehicles);  
$totalPages = ceil($totalVehicles / $vehiclesPerPage);
$offset = ($page - 1) * $vehiclesPerPage;
$vehicles = array_slice($vehicles, $offset, $vehiclesPerPage);
?>

<!doctype html>
<html lang="en">
<head>
    <title>CarLand | Vehicles</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
    
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- jQuery  -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    
    <!-- Popper.js for Bootstrap tooltips and popovers -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-sm">
        <a class="navbar-brand" href="index.php"><img src="images/carland2.png"></a> <!--Logo that links to home-->
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
             <!-- navbar links (link marked with "active" is page currently on) -->
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="vehicles.php">Vehicles<span class="sr-only">(current)</span></a>
                </li>
            </ul>

            <?php
            if (isset($_SESSION['username'])) {
                // check if user is logged in, if so displays account button, with logout and wishlist drop down
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
            } else {
                 // if the user isn't logged in, display login button instead
                echo '
                <a href="login.php" class="btn btn-link login-btn">
                <i class="bi bi-box-arrow-in-right"></i> Log-in </a>';
            }
            ?>

        </div>
    </nav>

    <div class="titleH">
    <h1>Vehicles on Sale</h1> 
</div>

    <!-- Vehicle listings -->
    <div class="vehiclelist">
        <?php foreach ($vehicles as $vehicle): ?>
            <?php
            $isInWishlist = false;
            // checks if vehicles are in users wishlist
            if ($user_id) {
                // Check if this vehicle is in the user's wishlist
                $stmt = $conn->prepare("SELECT * FROM wishlist WHERE user_ID = ? AND Vehicle_ID = ?");
                $stmt->bind_param("ii", $user_id, $vehicle['Vehicle_ID']);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $isInWishlist = true;
                }
            }
            ?>
            <!-- gets vehicle name and information and displays them-->
            <div class="vehicle-card">
                <a href="vehicle_details.php?ID=<?php echo $vehicle['Vehicle_ID']; ?>">
                    <img src="<?php echo $vehicle['Image']; ?>" alt="<?php echo $vehicle['Vehicle_Make'] . ' ' . $vehicle['Vehicle_Model']; ?>">
                </a>

                <div class="car-details">
                    <a href="vehicle_details.php?ID=<?php echo $vehicle['Vehicle_ID']; ?>"><h3><?php echo $vehicle['Vehicle_Make'] . ' ' . $vehicle['Vehicle_Model']; ?></h3></a>
                    <p>Year: <?php echo $vehicle['Year']; ?></p>
                    <p>Price: $<?php echo number_format($vehicle['Price'], 2); ?></p>
                    <p>Fuel Type: <?php echo $vehicle['Fuel_Type']; ?></p>

                    <?php if (isset($_SESSION['username'])): ?>
                        <button class="wishlist-btn <?php echo $isInWishlist ? 'highlighted' : ''; ?>" data-vehicle-id="<?php echo $vehicle['Vehicle_ID']; ?>">
                            <i class="bi bi-heart<?php echo $isInWishlist ? '-fill' : ''; ?>"></i>
                        </button>

                    <?php endif; ?>
                
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="vehicles.php?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="vehicles.php?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>>
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="vehicles.php?page=<?php echo $page + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>

    <!-- Footer -->
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
                        <li>Address: 123 New Zealand Road, Hamilton, 3200</li>
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
            <p>&copy; 2024 Carland. All Rights Reserved.</p>
        </div>
    </footer>

    <!--  JavaScript -->
    <script src="js/wishlist.js"></script>

</body>
</html>
