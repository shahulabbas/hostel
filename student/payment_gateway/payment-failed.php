<?php 
if(isset($_GET)){
    // You can handle any GET parameters here if needed
}
if (!isset($_SESSION['PinID'])) {
    header("Location:../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #d9534f; /* Bootstrap danger color */
        }

        p {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff; /* Bootstrap primary color */
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button.secondary {
            background-color: #6c757d; /* Bootstrap secondary color */
        }

        .button:hover {
            background-color: #0056b3; /* Darker shade */
        }

        .button.secondary:hover {
            background-color: #5a6268; /* Darker shade */
        }

        img {
            max-width:20%; /* Make the image responsive */
            height: auto;    /* Maintain aspect ratio */
            margin: 20px 0;  /* Add margin around the image */
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }

            .button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>Payment Failed</h1>
            <img src="../images/faild.png" alt="Payment Failed">
            <p>We're sorry, but your payment could not be processed. Please try again.</p>
            <a href="../details.php" class="button">Go Back to Homepage</a>
        </div>
    </div>
</body>
</html>
