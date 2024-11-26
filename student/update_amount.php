<?php
session_start();

// Include the database connection file
require('Connection.php');

// Check if the request is a POST request and that the MST_ID is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['MST_ID'])) {
    
    // Get the MST_ID (Pin number) from the POST request
    $mstId = $_POST['MST_ID'];

    // Prepare the SQL query to update the amount to 0 for the given MST_ID (Pin)
    $query = "UPDATE students SET AMOUNT = 0 WHERE PIN = ?";
    
    if ($stmt = $con->prepare($query)) {
        // Bind the MST_ID to the query
        $stmt->bind_param("s", $mstId);
        
        // Execute the query
        if ($stmt->execute()) {
            // If the query was successful, send a success response
            echo "Payment updated successfully.";
        } else {
            // If there was an error executing the query, return an error message
            http_response_code(500);
            echo "Error updating payment.";
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // If there was an error preparing the query, return an error message
        http_response_code(500);
        echo "Error preparing query.";
    }
    
} else {
    // If the request is not a POST request or MST_ID is not set, return a bad request response
    http_response_code(400);
    echo "Invalid request.";
}

// Close the database connection
$con->close();
?>
