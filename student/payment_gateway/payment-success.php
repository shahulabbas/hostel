<?php 
if(isset($_GET)){

session_start();
session_regenerate_id(true);

// Check if user is logged in; redirect if not
if (!isset($_SESSION['PinID'])) {
    header("Location: ../../index.php");
    exit();
}

require('../connection.php');

// Fetch the amount for confirmation from the database
$amountValue = 0; // Default amount
$query = "SELECT AMOUNT FROM STUDENTS WHERE PIN = ?";
$stmt = $con->prepare($query);
if ($stmt === false) {
    error_log("Prepare failed: " . $con->error);
    die("Database query failed.");
}

$stmt->bind_param("s", $_SESSION['PinID']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $recentRecord = $result->fetch_assoc();
    $amountValue = $recentRecord['AMOUNT'];
}}
$stmt->close();
$con->close(); // Close the database connection after use
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <link rel="icon" href="images/collagelogo.jpeg" type="image/icon type">
    <style>
      body {
    background-color: rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    height: 100vh; /* Full viewport height */
    margin: 0; /* Remove default body margin */
    overflow: hidden; /* Prevent body scrolling */
}

.popup {
    width: 700px; /* Increased width for smaller screens */
    max-width: 600px; /* Set a max-width for larger screens */
    padding: 20px;
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #888;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px; /* Add rounded corners for a smoother look */
}

h2 {
    margin: 0 0 15px; /* Add spacing below the heading */
}

img {
    width: 100%; /* Make image responsive */
    max-width: 200px; /* Limit maximum width */
    height: auto; /* Maintain aspect ratio */
}

button.proceedPaymentBtn {
    background-color: #007bff; /* Example button color */
    color: white; /* Text color */
    border: none; /* Remove border */
    padding: 10px 20px; /* Padding for button */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer on hover */
    transition: background-color 0.3s; /* Smooth transition for hover effect */
}

button.proceedPaymentBtn:hover {
    background-color: #0056b3; /* Darker color on hover */
}

/* Add media queries for responsiveness */
@media (max-width: 600px) {
    .popup-content {
        width: 100%; /* Full width on small screens */
        padding:10px;
        margin-left:-10px; /* Reduce padding for smaller screens */
    }
    .popup {
        width: 90%;
    }

    h2 {
        font-size: 1.5rem; /* Adjust heading size for mobile */
    }
}

    </style>
</head>

<body>

    <main>
        <div id="amountConfirmationPopup" class="popup" role="dialog" aria-labelledby="amountConfirmationTitle" aria-modal="true">
            <div class="popup-content">
                <h2 id="amountConfirmationTitle">Confirm Payment</h2>
                <img src="../images/payment-done.png" alt="Payment Confirmation" style="width: 200px; height: auto;">
                <p>Please collect the mess bill ₹ <span
                        id="amountToConfirm"><?php echo htmlspecialchars($amountValue); ?></span> in the homepage.<br>
                    <label>
                        <input type="checkbox" id="confirmPaymentCheckbox" checked disabled/> Confirm the payment done
                    </label>
                </p>
                <!-- <div>
                    <button id="proceedPaymentBtn" class="proceedPaymentBtn">Proceed</button>
                </div> -->
            </div>
        </div>
    </main>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const proceedPaymentBtn = document.getElementById('proceedPaymentBtn');
        const confirmPaymentCheckbox = document.getElementById('confirmPaymentCheckbox');

     
            if (confirmPaymentCheckbox.checked) {
                const MST_ID = '<?php echo $_SESSION["PinID"]; ?>';
                window.location.href = '../pdf_maker.php?MST_ID=' + encodeURIComponent(MST_ID) +
                    '&ACTION=UPLOAD';
            } else {
                alert("Please confirm the payment.");
            }
    });
    </script>

</body>

</html>