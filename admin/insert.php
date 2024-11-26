<?php

require('connection1.php');
$pinnumber = $_POST['pinnumber'];
$studentname = $_POST['studentname'];
$branch = $_POST['branch'];
$yearr = $_POST['year'];
$email = $_POST['email'];
$phonenumber = $_POST['phonenumber'];
$sql_check = "SELECT * FROM students WHERE `PIN` = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $pinnumber);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Record already exists!'); window.history.back();</script>";
} else {
    $sql_insert = "INSERT INTO students (`PIN`, `NAME`, `YEAR`, `BRANCH`, `AMOUNT`, `PHONENO`, `EMAIL`, `DATE`)  
                   VALUES (?,?,?,?,?,?,?,?) 
                   ON DUPLICATE KEY UPDATE 
                   `PIN` = VALUES(`PIN`), 
                   `NAME` = VALUES(`NAME`), 
                   `YEAR` = VALUES(`YEAR`), 
                   `BRANCH` = VALUES(`BRANCH`), 
                   `PHONENO` = VALUES(`PHONENO`), 
                   `EMAIL` = VALUES(`EMAIL`)";
    
    $date = NULL;  
    $amount = 0;   

    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssssssss", $pinnumber, $studentname, $yearr, $branch, $amount, $phonenumber, $email, $date);
    if ($stmt_insert->execute()) {
        echo "<script>alert('Record inserted/updated successfully'); window.location.href='adminhomepage.php';</script>";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

$stmt_check->close();
$stmt_insert->close();
$conn->close();

?>
