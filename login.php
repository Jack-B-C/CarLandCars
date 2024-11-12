<?php
session_start();

// Redirect logged-in users to the homepage or any other page
if (isset($_SESSION['username'])) {
    // Redirect to the homepage or a dashboard if logged in
    header("Location: index.php");
    exit(); // Ensures no further code is executed after the redirect
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'carlandcars');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Clear previous error
$error = ''; // Reset error before handling login

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input values
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if username or password is empty
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify the password (assuming passwords are hashed)
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to the homepage after successful login
                header("Location: index.php");
                exit(); // Ensure that no further code is executed
            } else {
                $error = "Invalid username/email or password.";
            }
        } else {
            $error = "Invalid username/email or password.";
        }

        
        $stmt->close();
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <title>CarLand | Login</title>
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
<!--bootstrap icons-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
    <!-- NAVBAR B4 -->
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
                    <a class="nav-link" href="vehicles.php">Vehicles</a>
                </li>
            </ul>
<?php
    if (isset($_SESSION['username'])) {
        // login / logout button
        echo '
        <div class="dropdown">
            <button class="btn btn-outline-danger dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="images/Login-icon.png" alt="User Icon" class="login-icon">
                ' . htmlspecialchars($_SESSION['username']) . '
            </button>
            <div class="dropdown-menu" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="wishlist.php">View Wishlist</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>';
    } else {
        echo '
        <a href="login.php" class="btn btn-link login-btn">
        <i class="bi bi-box-arrow-in-right"></i> Log-in </a>
        </button>';
    }
?>
        </div>
    </nav>

    <!-- Display Error Message Here (Only If There Is An Error) -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST" id="loginForm">
            <div class="form-group">
                <label for="username">Email or Username:</label>
                <input type="text" name="username" id="username" placeholder="Enter username or email..." required class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter password..." required class="form-control">
            </div>
            
            <div class="btn-container">
                <button type="submit" class="btn-submit">Login</button>
            </div>
        </form>
        <div class="text-center mt-3">
    <p class="small">Don't have an account? <a href="register.php" class="custom-link">Register here</a></p>
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
