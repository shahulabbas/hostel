<?php
// Establish a connection to the MySQL database
$con = mysqli_connect("localhost", "root", "root", "gptkpm");

// Check if the connection was successful
if (!$con) {
    // Display a user-friendly message and log the error
    error_log("Connection failed: " . mysqli_connect_error());
    die("Connection failed. Please try again later.");
}

// You can close the connection when it is no longer needed
// mysqli_close($con);
?>