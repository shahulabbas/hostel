<?php require("student/Connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="icon" type="image/x-icon" href="img/collagelogo.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="student/login.css?v=<?php echo time(); ?>"> <!-- Ensure latest CSS -->
    <style>
        
    </style>
</head>
<body>
    <div class="navbar-top">
        <div class="container">
            <div class="nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-headset"></i>Call us now: 08570-255444, 8367799101</a>
                    </li>
                </ul>
                <div class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="mailto:rp.kuppam101@gmail.com"><i class="fas fa-envelope"></i>Mail: rp.kuppam101@gmail.com</a>
                    </li>
                    <ul class="social-icons">
                        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <header>
        <div class="header">
            <div class="logo">
                <img src="student/images/collagelogo.jpeg" alt="">
                <p>DR. Y C JAMES YEN GOVERNMENT POLYTECHNIC<br> KUPPAM</p>
                <img src="student/images/sbtetlogo.png" alt="">
            </div>
            <i class="fa fa-bars icon" aria-hidden="true"></i>
            <div class="menu">
                <ul>
                    <li><a href="index.php" style="color: #1A82C4; " ><i class="fa fa-home" style="margin-right: 8px"></i>Home</a></li>
                    <li><a href="contact/login.html"><i class="fa fa-id-card" style="margin-right: 8px"></i>Contact Us</a></li>
                    <li><a href="admin/adminlogin.php"><i class="fa fa-lock" style="margin-right: 8px"></i>Admin</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <div class="main">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
                <legend style="margin-bottom: 10px;"><h3>Student Login</h3> </legend>
                <div class="from">
                    <input type="text" id="pin" name="Pin" required placeholder="Enter PIN">
                </div>
                <div class="from">
                    <select id="year" name="Year" required>
                        <option value="">Select Year</option>
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                    </select>
                </div>
                <div class="from">
                    <button type="submit" name="Submit">Submit</button>  
                </div>
            </form>
        </div>
    </main>

    <?php 
    function input_filter($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submit'])) {
        $PIN = input_filter($_POST['Pin']);
        $YEAR = input_filter($_POST['Year']);

        if (empty($YEAR)) {
            echo "<script>alert('Please select a year')</script>";
        } else {
            $PIN = mysqli_real_escape_string($con, $PIN);
            $YEAR = mysqli_real_escape_string($con, $YEAR);

            echo "Pin: $PIN, Year: $YEAR"; 

            $query = "SELECT * FROM `students` WHERE `PIN`=? AND `YEAR`=?";

            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt, "si", $PIN, $YEAR);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                echo "Number of rows: " . mysqli_stmt_num_rows($stmt);

                if (mysqli_stmt_num_rows($stmt) === 1) {
                    session_start();
                    $_SESSION['PinID'] = $PIN;
                    header("Location:student/details.php");
                    exit();
                } else {
                    echo "<script>alert('Invalid PIN or Year')</script>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "<script>alert('SQL Query cannot be prepared')</script>";
            }
        }
    }
    ?>

<script>
        let icon = document.querySelector(".icon");
        let menu = document.querySelector(".menu");

        icon.onclick = function() {
            menu.classList.toggle("active");
        }
    </script>
</body>
</html>
