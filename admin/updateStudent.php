<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
require('connection1.php');

    if (isset($_SESSION['pinnumber'])) {
       
        $amount = (int)$_POST['amount']; 
        $pin = $_SESSION['pinnumber']; 

        
        $stmt = $conn->prepare("SELECT PIN FROM STUDENTS WHERE PIN = ?");
        $stmt->bind_param("s", $pin);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
              
                $update_stmt = $conn->prepare("UPDATE STUDENTS SET AMOUNT = ? WHERE PIN = ?");
                $update_stmt->bind_param("is", $amount, $pin); 

                if ($update_stmt->execute()) {
                    echo "<script>alert('Record updated successfully'); window.location.href='singlestudent.php';</script>";
                } else {
                    echo "<script>alert('Error: record not updated'); window.location.href='singlestudent.php';</script>";
                    echo $conn->error;
                }
                $update_stmt->close();
            } else {
                echo "<script>alert('No record found for this PIN'); window.location.href='singlestudent.php';</script>";
            }
        } else {
            echo "<script>alert('Error executing query'); window.location.href='singlestudent.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Session expired or PIN not set.'); window.location.href='singlestudent.php';</script>";
    }


$conn->close();
?>
