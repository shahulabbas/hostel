<?php  
session_start();
session_regenerate_id(true); 

if (!isset($_SESSION['PinID'])) {
    header("Location: ../index.php");
    exit();
}

require("Connection.php");

$query = "SELECT * FROM students WHERE PIN = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $_SESSION['PinID']); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $recentRecord = $result->fetch_assoc();
} else {
    $recentRecord = null;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student Details</title>
    <link rel="icon" href="images/collagelogo.jpeg" type="image/icon type">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="details.css?v=<?php echo time(); ?>"> <!-- Ensure latest CSS -->
   
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
                <img src="images/collagelogo.jpeg" alt="">
                <p>DR. Y C JAMES YEN GOVERNMENT POLYTECHNIC<br> KUPPAM</p>
                <img src="images/sbtetlogo.png" alt="">
            </div>
            <i class="fa fa-bars icon" aria-hidden="true"></i>
            <div class="menu">
                <ul>
                <li><a href="../index.php" style="color: #1A82C4;" ><i class="fa fa-home" style="margin-right: 8px"></i>Home</a></li>
                    <li><a href="../contact/login.html"><i class="fa fa-id-card" style="margin-right: 8px"></i>Contact Us</a></li>
                    <li><a href="../admin/adminlogin.php"><i class="fa fa-lock" style="margin-right: 8px"></i>Admin</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <section class="section">
            <div class="details">
                <div class="details0">
                    <img src="images/student1.png" alt="student" style="height: 50px;">
                    <h3>Student Summary</h3>
                </div>
                <div class="logout">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <button type="submit" name="logout">LOGOUT<i class="fa fa-sign-out" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
            <section class="section1">
                <div class="details-box">
                    <?php
                    if ($recentRecord) {
                        echo '<div class="form-group">';
                        echo '<label for="name">Student Name</label>';
                        echo '<label class="colon1" for="name">:</label>';
                        echo '<input type="text" id="name" value="' . htmlspecialchars($recentRecord['NAME']) . '" disabled>';
                        echo '</div>';
                        
                        echo '<div class="form-group">';
                        echo '<label for="pin">Pin-No:</label>';
                        echo '<label class="colon2" for="pin">:</label>';
                        echo '<input type="text" id="pin" value="' . htmlspecialchars($recentRecord['PIN']) . '" disabled>';
                        echo '</div>';
                        
                        echo '<div class="form-group">';
                        echo '<label for="branch">Branch:</label>';
                        echo '<label class="colon3" for="branch">:</label>';
                        echo '<input type="text" id="branch" value="' . htmlspecialchars($recentRecord['BRANCH']) . '" disabled>';
                        echo '</div>';
                        
                    } else {
                        echo '<p>No recent record found.</p>';
                    }
                    ?>
                </div>
                <div class="studentimg">
                    <img src="images/student2.png" alt="student">
                </div>
            </section>
        <?php if ($recentRecord && $recentRecord['AMOUNT'] > 0): ?>
        <section class="section2">
            <div class="details1">
                <div class="date">
                    <img src="images/date.png" alt="Date">
                    <span>Date: <?php echo htmlspecialchars(date('Y-m-d')); ?></span>
                </div>
                <div class="data">
                    <div class="note">
                        <h3><center>Note:</center></h3>
                        <label class="note1" for="note"> Dear students, please clear the mass bill before the due date "</label>
                        <input type="text" id="date" value="<?php if($recentRecord['DATE'] ==NULL){
                            echo "NULL";
                        }
                        else{
                        echo htmlspecialchars($recentRecord['DATE']);} ?>" disabled>
                        <label class="note1" for="note">"Otherwise, you will incur a fine of RS 100.</label>
                    </div>
                    <div class="Amount">
                        <label for="Amount">Total Amount</label>
                        <label class="colon1" for="amount">:</label>
                        <input type="text" id="amount" value="<?php echo htmlspecialchars($recentRecord['AMOUNT']); ?>" disabled>
                    </div>
                    <div class="pay">
                        <button class="pay1" id="payBtn" onclick="redirect()">Pay</button>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        </section>
        <section class="section3">
    <div class="sec">
        <div><i class="fa fa-file-text" aria-hidden="true"></i></div>
        <p>Your Uploaded PDFs</p>
    </div>
    <ul class="pdf-list">
        <?php
            $userPin = htmlspecialchars($recentRecord['PIN']); 
            $upload_dir = "uploads/";
            $files_to_display = array();

            if (is_dir($upload_dir)) {
                $files = array_diff(scandir($upload_dir), array('.', '..'));

                // Collect files that match the user's PIN
                foreach ($files as $file) {
                    if (strpos($file, $userPin) === 0) {
                        $file_path = $upload_dir . $file;
                        $files_to_display[$file] = filemtime($file_path); // Store file modification time
                    }
                }

                // Sort files by modification time in descending order (latest first)
                arsort($files_to_display);

                if (!empty($files_to_display)) {
                    foreach ($files_to_display as $file => $time) {
                        echo '<li class="list-group-item">';
                        echo '<a href="' . htmlspecialchars($upload_dir . $file) . '" target="_blank">' . htmlspecialchars($file) . '</a>';
                        echo ' <a href="' . htmlspecialchars($upload_dir . $file) . '" class="btn btn-danger btn-sm" download>Download</a>';
                        echo '</li>';
                    }
                } else {
                    echo '<li class="list-group-item">No PDFs found for your PIN.</li>';
                }
            } else {
                echo '<li class="list-group-item">Upload directory does not exist.</li>';
            }
        ?>
    </ul>
</section>
        
    </main>

    <footer class="footer">
        <figure class="mb-0">
            <svg width="100%" height="150" viewBox="0 0 500 150" preserveAspectRatio="none">
                <path d="M0,150 L0,40 Q250,150 500,40 L580,150 Z"></path>
            </svg>
        </figure>

        <div class="container">
            <img src="images/co.png" alt="logo">
            <p style="font-size: 10px;">YANADIPALLI VILLAGE, KRISNADASANA PALLI POST, KUPPAM - 517425, CHITTOOR (D.T),<br> ANDHRA PRADESH PH:8367799101, 08570 - 255444</p>
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


<script>
        let icon = document.querySelector(".icon");
        let menu = document.querySelector(".menu");
    
        icon.onclick = function() {
            menu.classList.toggle("active");
        }
        
        function redirect(){
            window.location.href = "payment_gateway/index.php";

        }
    </script>

</body>
</html>