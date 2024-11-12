<?php
session_start();
session_destroy(); // end the session
header("Location: index.php"); // Redirect to the homepage
exit();
?>
