<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['email'])) {
    session_destroy();
    echo '<script language="javascript">';
  echo 'alert(are you confirm to logout)';  
  echo '</script>';
    header("Location: adminlogin.php");
    
} else {
   
}
?>