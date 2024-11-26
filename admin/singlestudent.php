<?php
error_reporting(E_ERROR | E_PARSE);
require('connection1.php');

     
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
<link rel="stylesheet" href="singlestudentcss.css?v=<?php echo time();?>">
    <title>Admin Panel</title>
    <style>
       

    </style>
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
                        <li>
                            <a href="../index.php">
                                <i class="fa fa-home"></i> Home
                            </a>
                        </li>
                        <li>
                            <a href="../contact/login.html">
                                <i class="fa fa-id-card"></i> Contact Us
                            </a>
                        </li>
                        <li>
                            <a href="../admin/adminlogin.php">
                                <i class="fa fa-lock"></i> Admin
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="main">
                    <div class="menu bar">
                        <ul>
                            <li><a href="adminhomepage.php" class="active">All Students</a></li>
                            <li><a href="paidstudents.php">Paid Students</a></li>
                            <li><a href="notpaidstudents.php">Not Paid Students</a></li>
                            <li><a href="singlestudent.php" style="color:#1a82c4;">Single Student Details</a></li>
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
            </div>
        </div>

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
                <form id="myform" method="POST" action="">
                    <div>
                        <input type="text" placeholder="Enter Pin Number" id="pinnumber" value="" name="pinnumber" required>
                    </div>
                    <div>
                        <button name="select">Submit</button>
                    </div>
                </form>
            </div>

            <div class="container6">
                <div class="box1">
                <table class=table>
                       
                    <?php
                    $_pinnumber = $_POST['pinnumber'];
                    $_SESSION['pinnumber'] = $_pinnumber;
                    $sql = "SELECT * FROM students WHERE PIN = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $_pinnumber);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "
                         <thead>
                          
                        </thead>
                        <tbody>
                          <tr>
                                <th>Pin-Number</th>
                                <th>Student Name</th>
                                <th>Branch</th>
                                <th>Amount</th>
                                <th>Year</th>
                                <th>Phone number</th>
                                <th>Email</th>
                            </tr>
                            <tr>
                                <td>" . $row["PIN"] . "</td>
                                <td>" . $row["NAME"] . "</td>
                                <td>" . $row["BRANCH"] . "</td>
                                <td>" . $row["AMOUNT"] . "</td>
                                <td>" . $row["YEAR"] . "</td>
                                <td>" . $row["PHONENO"] . "</td>
                                <td>" . $row["EMAIL"] . "</td>
                            </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class=box2>
                            <div class=box id=box1 onclick=deleteStudent()>
                                <p>Delete</p>
                            </div>
                            <div class=box id=box2 onclick=updateStudent()>
                                <p>Update</p>
                            </div>
                        </div>";
                        echo "<script>
                            function deleteStudent() {
                                if (confirm('Are you sure you want to delete this student?')) {
                                    window.location.href = 'deletestudent.php'
                                }
                            }
                            function updateStudent() {
                                if (confirm('Are you sure you want to update this student?')) {
                                    window.location.href = 'updatestudents.html'
                                }
                            }
                        </script>";
                    } else {
                        echo "<tr>
                        <td colspan=7>No matching data found.</td>
                        </tr>";
                    }
                    $_pinnumber = '0';
                    $stmt->close();
                    ?>
                </div>
            </div>
        </div>
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
                }); // Slide up the .first class if width is 767px or less
            } else {
                $('.first').slideDown(); // Optional: Slide down if width is greater than 767px
            }
        });
    </script>
</body>


</html>
