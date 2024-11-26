<?php
if(isset($_GET)){

    session_start();
    session_regenerate_id(true);
    
    // Check if user is logged in; redirect if not
    if (!isset($_SESSION['PinID'])) {
        header("Location: ../../index.php");
        exit();
    }
}
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE');
header("Content-Type: application/json");
header("Accept: application/json");
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Access-Control-Allow-Methods, Content-Type');

if (isset($_POST['action']) && $_POST['action'] == 'payOrder') {

    $razorpay_mode = 'test'; // Change to 'live' for production environment

    $razorpay_test_key = 'rzp_test_25Gp5w3FzMFZu3'; // Test Key
    $razorpay_test_secret_key = 'zRnLnm42mzo817hDawdAvt2e'; // Test Secret Key

    $razorpay_live_key = 'Your_Live_Key'; // Replace with live key
    $razorpay_live_secret_key = 'Your_Live_Secret_Key'; // Replace with live secret key

    if ($razorpay_mode == 'test') {
        $razorpay_key = $razorpay_test_key;
        $authAPIkey = "Basic " . base64_encode($razorpay_test_key . ":" . $razorpay_test_secret_key);
    } else {
        $authAPIkey = "Basic " . base64_encode($razorpay_live_key . ":" . $razorpay_live_secret_key);
        $razorpay_key = $razorpay_live_key;
    }

    // Set transaction details
    $order_id = uniqid();

    $payAmount = $_POST['payAmount']; // Amount from form
    $note = "Payment of amount Rs. " . $payAmount;

    // Prepare the request data
    $postdata = array(
        "amount" => $payAmount * 100, // Amount in paise
        "currency" => "INR",
        "receipt" => $note,
        "notes" => array(
            "notes_key_1" => $note,
            "notes_key_2" => ""
        )
    );

    // Initialize cURL to call Razorpay's order API
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.razorpay.com/v1/orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($postdata),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: ' . $authAPIkey
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $orderRes = json_decode($response);

    if (isset($orderRes->id)) {
        // Razorpay order ID created
        $rpay_order_id = $orderRes->id;

        // Prepare the response to be sent back to the form
        $dataArr = array(
            'amount' => $payAmount,
            'description' => "Pay bill of Rs. " . $payAmount,
            'rpay_order_id' => $rpay_order_id,
            'razorpay_key' => $razorpay_key
        );

        // Send response with order ID and user data
        echo json_encode(['res' => 'success', 'order_number' => $order_id, 'userData' => $dataArr, 'razorpay_key' => $razorpay_key]);
        exit;
    } else {
        // Handle errors
        echo json_encode(['res' => 'error', 'order_id' => $order_id, 'info' => 'Error with payment']);
        exit;
    }
} else {
    // Handle incorrect requests
    echo json_encode(['res' => 'error']);
    exit;
}
?>
