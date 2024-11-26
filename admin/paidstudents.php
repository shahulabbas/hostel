<?php
session_start();

// Access session variables
if(isset($_SESSION['username']) && isset($_SESSION['email'])) {
    
} else {
     header("Location: adminlogin.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="img/collagelogo.jpeg">
    <link rel="stylesheet" href="paidstudentcss.css?v=<?php echo time();?>"> <!-- Link to your CSS file -->
    <title>paid student</title>
</head>
<body>
    <div class="container">
         <div class="first">
        <div class="left-panel" id="sidebar">
        <div class="top">
<p>MENU</p>
<div class="hide">
<i class="fa fa-close"></i>
</div>
</div>
        <div class="menu">
                <ul>
                    <li><a href="../index.php">
                        <i class="fa fa-home"></i> Home</a></li>
                    <li><a href="../contact/login.html">
                        <i class="fa fa-id-card"></i> Contact Us</a></li>
                    <li><a href="../admin/adminlogin.php">
                        <i class="fa fa-lock"></i> Admin</a></li>
                </ul>
            </div>
        <div class="main">
            <!-- <div>
            <i class="fa fa-university" style="font-size:30px;color:#fff"></i>

            </div> -->
        <div class="menu bar">
        <ul>
                    <li><a href="adminhomepage.php" class="active">All Students</a>
                    </li>
                    <li><a href="paidstudents.php" style="color:#1a82c4;">Paid Students</a>
                    </li>
                    <li><a href="notpaidstudents.php">Not Paid Students</a>
                </li>
                <li> <a href="singlestudent.php">Single Student Details</a>

                </li>
                <li>
                <div class="logout">    
                <button id="logoutButton">
                    <i class="fa fa-sign-out"></i>
                    <a href="logout.php">Log out</a>
                </button>
            </div>
                </li>
</ul>      
            </div>
        </div>

            <!-- Logout button -->
          
        </div>
        </div>
        <!-- Right Empty Panel -->
<div class="right-panel">
    <div class="navbar-top">
            <div class="box">
            <a class="nav-link" href="#"><i class="fa fa-headset"></i>Call us now: 08570-255444, 8367799101</a>
            </div>
            <div class="box">
            <a class="nav-link" href="mailto:rp.kuppam101@gmail.com"><i class="fa fa-envelope"></i>Mail: rp.kuppam101@gmail.com</a>
            </div>
            <div class="box">
                <i class="fab fa-youtube"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-youtube"></i>
            </div>
    </div>
<header>
           <div class="header">
            <div class="logo">
                <img src="img/collagelogo.jpeg" alt="">
                <p>DR. Y C JAMES YEN GOVERNMENT POLYTECHNIC<br> KUPPAM</p>
                <img src="img/sbtetlogo.png" alt="">
            </div>
            <div class="close">
            <i class="fa fa-bars icon" aria-hidden="true"></i>
          </div>
        </div>
</header>

<div class="container5">
<table class="table table-striped table-bordered">
<thead class="thead-dark">
                <tr>
                    
                    <th>Pin-Number</th>
                    <th>Student Name</th>
                    <th>Branch</th>
                    <th>Amount</th>
                    <th>Year</th>
                    <th>Phone number</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
            <?php
             require('connection1.php');
              $sql = "SELECT * FROM students WHERE AMOUNT IN ('0')";
              $result = $conn->query($sql);
              if(!$result)
              {
              die("invalid query".$mysqli->error);
              }
              while($row = $result->fetch_assoc()){
                echo "<tr>
                    <td data-label='Pin-Number'>". $row["PIN"] ."</td>
                    <td data-label='Student Name'>". $row["NAME"] ."</td>
                    <td data-label='Branch'>". $row["BRANCH"] ."</td>
                    <td data-label='Amount'>". $row["AMOUNT"] ."</td>
                    <td data-label='Year'>". $row["YEAR"] ."</td>
                    <td data-label='Phone number'>".$row["PHONENO"] ."</td>
                    <td data-label='Email'>". $row["EMAIL"] ."</td>
                </tr>"; 
            }
            
$sql = "SELECT AMOUNT FROM students WHERE AMOUNT = 0 ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   

} else {
    
    echo "<style>
    .table >thead>tr{
        display:none;
    }
   
</style>";
echo "Data not found!";
}

?>
            </tbody>
        </table>
    </div>
    <footer class="footer">
        <figure class="mb-0">
            <svg width="100%" height="150" viewBox="0 0 500 150" preserveAspectRatio="none">
                <path d="M0,150 L0,40 Q250,150 500,40 L580,150 Z"></path>
            </svg>
        </figure>

        <div class="container1">
            <img src="img/co.png" alt="logo">
            <p>YANADIPALLI VILLAGE, KRISNADASANA PALLI POST, KUPPAM - 517425, CHITTOOR (D.T),<br> ANDHRA PRADESH PH:8367799101, 08570 - 255444</p>
            <ul class="social-icons">
                <li><a href="#" class="fab fa-facebook-f"></a></li>
                <li><a href="#" class="fab fa-youtube"></a></li>
                <li><a href="#" class="fab fa-twitter"></a></li>
                <li><a href="#" class="fab fa-linkedin-in"></a></li>
            </ul>
            <div class="bottom-footer">
                ©️2023 <a href="#" target="_blank">Dr YC James Yen Government Polytechnic - Kuppam</a>. All rights reserved.
            </div>
        </div>
    </footer>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.close').click(function() {
                $('.first').slideToggle(); // Toggles the visibility of the menu
            });
        });
        $(document).ready(function() {
            $('.hide').click(function() {
                $('.first').slideToggle(); // Toggles the visibility of the menu
            });
        });
       
        $(document).ready(function() {
            if ($(window).width() <= 767) {
                $(window).scroll(function() {
            $('.first').slideUp(); // Close the menu
        });// Slide up the .first class if width is 767px or less
            } else {
                $('.first').slideDown(); // Optional: Slide down if width is greater than 767px
            }
    });
    </script>
</body>
</html>
