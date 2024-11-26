<?php
// Function to create a database connection
function getDatabaseConnection() {
   require('connection1.php');
}

// Using the connection in your main code
try {
    // Get the PDO connection
    $conn = getDatabaseConnection();
    
    // Start a transaction
    $conn->beginTransaction();
    
    // Retrieve input data
    $oldusername = $_POST['old_username'];
    $oldpassword = $_POST['old_password'];
    $newusername = $_POST['new_username'];
    $newpassword = $_POST['new_password'];

    // SQL query to find matching values
    $sqlSelect = "SELECT USERNAME, PASSWORDD FROM ADMINLOGIN WHERE ID = 1";
    
    // Prepare and execute the select statement
    $stmtSelect = $conn->prepare($sqlSelect);
    $stmtSelect->execute();
    
    // Fetch the result
    $result = $stmtSelect->fetch(PDO::FETCH_ASSOC);
    
    // Check if the entered old username and password match the current credentials
    if ($result && $result['USERNAME'] === $oldusername && $result['PASSWORDD'] === $oldpassword) {
        // SQL query to update username and password
        $sqlUpdate = "UPDATE ADMINLOGIN SET USERNAME = :newusername, PASSWORDD = :newpassword WHERE ID = 1";
        
        // Prepare the update statement with placeholders for security
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':newusername', $newusername);
        $stmtUpdate->bindParam(':newpassword', $newpassword);
        $stmtUpdate->execute();
        
        // Commit the transaction
        $conn->commit();
        
        // Check how many rows were updated
        if ($stmtUpdate->rowCount() > 0) {
            echo "<script>alert('Record updated successfully'); window.location.href='adminlogin.php';</script>";
        } else {
            echo "<script>alert('No changes were made.'); window.location.href='adminlogin.php';</script>";
        }
    } else {
        // Rollback the transaction and show an error message
        $conn->rollBack();
        echo "<script>alert('Incorrect current username or password.'); window.location.href='adminlogin.php';</script>";
    }
} catch (PDOException $e) {
    // Rollback the transaction if something goes wrong
    $conn->rollBack();
    echo "Database error: " . $e->getMessage();
}
?>
