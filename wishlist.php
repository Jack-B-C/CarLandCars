<?php
session_start();
include('db_connect.php'); 

if (!isset($_SESSION['user_id'])) {
    echo "error"; // If the user is not logged in, return an error
    exit;
}

if (isset($_SESSION['user_id']) && isset($_POST['vehicle_id'])) {
    $user_id = $_SESSION['user_id'];
    $vehicle_id = $_POST['vehicle_id'];

    // Check if the vehicle is already in the wishlist
    $query = "SELECT * FROM wishlist WHERE user_ID = ? AND Vehicle_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $vehicle_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If vehicle is already in the wishlist, remove it
            $query = "DELETE FROM wishlist WHERE user_ID = ? AND Vehicle_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $user_id, $vehicle_id);

            if ($stmt->execute()) {
                echo "removed";
            } else {
                echo "Error removing from wishlist.";
            }
        } else {
            // Add vehicle to wishlist
            $query = "INSERT INTO wishlist (user_ID, Vehicle_ID) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $user_id, $vehicle_id);

            if ($stmt->execute()) {
                echo "added";
            } else {
                echo "Error adding to wishlist.";
            }
        }
    } else {
        echo "Error executing query.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "error";
}
