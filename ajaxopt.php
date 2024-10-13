<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<h2>OTP Verification</h2>
<form id="otpForm">
    <label for="mobile">Mobile Number:</label>
    <input type="text" id="mobile" name="mobile" required>
    <button type="submit" id="send_otp">Send OTP</button>
</form>

<div id="otpResponse"></div>

<form id="verifyOtpForm" style="display:none;">
    <label for="otp">Enter OTP:</label>
    <input type="text" id="otp" name="otp" required>
    <button type="submit" id="verify_otp">Verify OTP</button>
</form>

<div id="verificationResponse"></div>

<script>
    $(document).ready(function() {
        // Handle sending OTP
        $('#otpForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            var mobile = $('#mobile').val();

            $.ajax({
                type: 'POST',
                url: '', // Same page for handling the request
                data: { send_otp: true, mobile: mobile },
                success: function(response) {
                    $('#otpResponse').html(response);
                    $('#verifyOtpForm').show(); // Show the OTP verification form
                },
                error: function() {
                    $('#otpResponse').html('Error sending OTP. Please try again.');
                }
            });
        });

        // Handle verifying OTP
        $('#verifyOtpForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            var otp = $('#otp').val();

            $.ajax({
                type: 'POST',
                url: '', // Same page for handling the request
                data: { verify_otp: true, otp: otp },
                success: function(response) {
                    $('#verificationResponse').html(response);
                },
                error: function() {
                    $('#verificationResponse').html('Error verifying OTP. Please try again.');
                }
            });
        });
    });
</script>

<?php
session_start();

if (isset($_POST['send_otp'])) {
    $contact = $_POST['mobile'];
    sendOtp($contact);
}

if (isset($_POST['verify_otp'])) {
    $enteredOtp = $_POST['otp'];
    verifyOtp($enteredOtp);
}

function sendOtp($contact) {
    date_default_timezone_set("Asia/Kolkata");
    $otp = rand(100000, 999999); // Generate a random OTP
    $message = urlencode("Welcome to BMAPAN. Your OTP to verify contact number is $otp. Developed by MISCOS Technologies Private Limited");

    $response_type = "json";
    $route = "4";
    $mobile = "91" . $contact;

    // Prepare your post parameters
    $postData = [
        "authkey" => "362180A9fmXMgXDi3O65c9e9bdP1",
        "mobiles" => $mobile,
        "message" => $message,
        "sender" => "BMAPAN",
        "route" => $route,
        "response" => $response_type,
    ];

    // API URL
    $url = "http://api.msg91.com/api/sendhttp.php?authkey=362180A9fmXMgXDi3O65c9e9bdP1&sender=BMAPAN&mobiles=$contact&route=$route&message=$message&DLT_TE_ID=1307171060435463268";

    // Init the resource
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
    ]);

    // Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    // Get response
    $output = curl_exec($ch);

    // Print error if any
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        echo 'API Response: ' . $output;
        // Store OTP in session or database for verification later
        $_SESSION['otp'] = $otp; // Save the generated OTP in session
    }

    curl_close($ch);
}

function verifyOtp($enteredOtp) {
    if (isset($_SESSION['otp']) && $enteredOtp == $_SESSION['otp']) {
        echo "OTP verified successfully!";
        unset($_SESSION['otp']); // Clear OTP after verification
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

</body>
</html>
