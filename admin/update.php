<?php
require('connection1.php');

    $amount = $_POST["amount"];
    $date = $_POST["date"];
    $sql = "SELECT PIN, AMOUNT, DATE FROM students WHERE id > 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $pin = $row['PIN'];  
            $current_value = $row['AMOUNT'];  
            $new_value = $current_value + $amount;  

            if (is_numeric($pin)) {
                $update_sql = "UPDATE students SET AMOUNT = $new_value , DATE = '$date' WHERE pin = $pin";
            } else {
                $update_sql = "UPDATE students SET AMOUNT = $new_value , DATE = '$date' WHERE pin = '$pin'";
            }

            if ($conn->query($update_sql) === TRUE) {
                echo "<script>alert('Record updated successfully'); window.location.href='adminhomepage.php';</script>";
            } else {
                echo "<script>alert('Error updating record'); window.location.href='adminhomepage.php';</script>";
                echo $conn->error;
            }
        }
    } else {
        echo "No records found.";
    }


$conn->close();
?>
