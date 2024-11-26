<?php  
session_start();
session_regenerate_id(true); 

if (!isset($_SESSION['PinID'])) {
    header("Location: ../../index.php");
    exit();
}

require("../Connection.php");

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
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment Integration</title>
    <link rel="icon" type="image/x-icon" href="img/collagelogo.jpeg">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
  <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        background-repeat: no-repeat;
        background-size: cover;
    }
    
    .container {
        margin-top: 50px;
    }
    
    .panel {
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .panel-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #1D3B53;
        color: #fff;
        padding: 10px 15px;
        border-radius: 8px 8px 0 0;
    }

    .panel-title {
        font-size: 1.2em;
        margin: 10px;
    }

    .fa-close {
        color: #fff;
        cursor: pointer;
        font-size: 1.2em;
    }

    .panel-body {
        padding: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    .form-control {
        padding: 10px;
        font-size: 1em;
    }

    .btn-lg {
        font-size: 1em;
        padding: 15px 20px;
        margin:20px 0;
    }

    /* Media queries for responsiveness */
    @media (max-width: 768px) {
        .panel {
            margin: 0 15px;
        }

        .panel-title {
            font-size: 1em;
        }

        .btn-lg {
            font-size: 0.9em;
            padding: 10px 15px;
        }
    }

    @media (max-width: 576px) {
        .panel-title {
            font-size: 0.9em;
        }

        .form-control {
            padding: 8px;
            font-size: 0.9em;
        }

        .btn-lg {
            font-size: 0.8em;
            padding: 8px 10px;
        }
    }
</style>

    </style>
</head>

<body style="background-repeat: no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background:#1D3B53;color:#fff;" >
                        <h4 class="panel-title">Charge <?php echo htmlspecialchars($recentRecord['AMOUNT']); ?> INR</h4>
                        <i class="fa fa-close" onclick="back()"></i>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Payment Amount</label>
                            <input type="text" class="form-control" name="payAmount" id="payAmount"
                                value="<?php echo htmlspecialchars($recentRecord['AMOUNT']); ?>"
                                placeholder="Enter Amount" required="" autofocus="" disabled>
                        </div>

                        <!-- submit button -->
                        <button id="PayNow" class="btn btn-success btn-lg btn-block">Submit & Pay</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Pay Amount
    jQuery(document).ready(function($) {
        jQuery('#PayNow').click(function(e) {
            let payAmount = $('#payAmount').val();
            var request_url = "submitpayment.php";
            var formData = {
                payAmount: payAmount,
                action: 'payOrder'
            };

            $.ajax({
                type: 'POST',
                url: request_url,
                data: formData,
                dataType: 'json',
                encode: true,
            }).done(function(data) {
                if (data.res == 'success') {
                    var orderID = data.order_number;
                    var options = {
                        "key": data
                        .razorpay_key, // Enter the Key ID generated from the Dashboard
                        "amount": data.userData.amount, // Amount in currency subunits
                        "currency": "INR",
                        "name": "GPTKUPPAM HOSTEL", // your business name
                        "description": data.userData.description,
                        "image": "../images/collagelogo.jpeg",
                        "order_id": data.userData.rpay_order_id, // Order ID
                        "handler": function(response) {
                            window.location.replace("payment-success.php");
                                
                        },
                        "modal": {
                            "ondismiss": function() {
                                window.location.replace("payment-failed.php");
                            }
                        },
                        "prefill": {
                            "name": data.userData.name,
                            "email": data.userData.email,
                            "contact": data.userData.mobile
                        },
                        "theme": {
                            "color": "#3399cc"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                    e.preventDefault();
                }
            });
        });
    });
    </script>
    <script>
    function back() {
        window.location.href = "../details.php";

    }
    </script>
</body>

</html>
