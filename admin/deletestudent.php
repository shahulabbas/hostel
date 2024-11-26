<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
require('connection1.php');    

    if (isset($_SESSION['pinnumber'])) {
        $pin = $_SESSION['pinnumber']; 
        $sql = "SELECT PIN FROM students WHERE PIN = '$pin'";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $delete_sql = "DELETE FROM students WHERE PIN = '$pin'";
            if ($conn->query($delete_sql) === TRUE) {
                echo "<script>alert('Record Deleted successfully'); window.location.href='singlestudent.php';</script>";
            } else {
                echo "<script>alert('Error: record not deleted'); window.location.href='singlestudent.php';</script>";
                echo $conn->error;
            }
        } else {
            echo "<script>alert('No record found for this PIN'); window.location.href='singlestudent.php';</script>";
        }
    } else {
        echo "<script>alert('Session expired or PIN not set.'); window.location.href='singlestudent.php';</script>";
    }


?>