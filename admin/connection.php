<?php  
session_start();    
    require('connection1.php');    
    $username = $_POST['user'];  
    $password = $_POST['pass'];  
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $password;
    
        //to prevent from mysqli injection  
        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $username = mysqli_real_escape_string($conn, $username);  
        $password = mysqli_real_escape_string($conn, $password);  
      
        $sql = "SELECT USERNAME, PASSWORDD from adminlogin where USERNAME = '$username' and PASSWORDD = '$password'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){  
            header("Location: adminhomepage.php");
        }  
        else{  
            phpAlert();
           
        }     
    
    function phpAlert() {
        echo "<script>
alert('Username or Password is Incorrect ');
window.location.href='adminlogin.php';
</script>";
       
       

    }
?>