<?php
session_start(); // Start the session to store OTP

$err = "";
$ses = "";
$otpSent = false; // Flag to check if OTP was sent

if (isset($_POST['btn'])) {
    $otp = rand(1111, 9999); // Generate a random 4-digit OTP
    $no = $_POST['num']; // Get the mobile number from the form input
    
    // Validate the mobile number to ensure it contains exactly 10 digits
    if (preg_match("/^\d{10}$/", $no)) {
        $fields = array(
            "variables_values" => "$otp",
            "route" => "otp",
            "numbers" => "$no",
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => array(
                "authorization: hkyCeaw3t2KRDOdYGsBW0Qq8NHPJ7l64VbmZFAUzrTx5jXSgcE6phcv8dzEu9CgMS7HFO2jN5lyDrf3m", // Replace with your Fast2SMS API key after completing KYC
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // Print the entire response to see its structure for debugging
            echo "<pre>";
            print_r($response);
            echo "</pre>";

            $data = json_decode($response);
            // Check if the 'return' field exists and is true
            if (isset($data->return) && $data->return == true) {
                $_SESSION['otp'] = $otp; // Store the generated OTP in the session
                $ses = "Your OTP has been sent successfully!";
                $otpSent = true; // Set the flag to true if OTP was sent
            } else {
                $err = "Failed to send OTP. Please complete your KYC on Fast2SMS.";
            }
        }
    } else {
        $err = "Invalid Mobile Number";
    }
}

// Verify OTP
if (isset($_POST['verify'])) {
    $inputOtp = $_POST['inputOtp'];
    
    if (isset($_SESSION['otp']) && $inputOtp == $_SESSION['otp']) {
        $ses = "OTP verified successfully!";
        unset($_SESSION['otp']); // Clear OTP from session after verification
        $otpSent = false; // Reset the flag after successful verification
    } else {
        $err = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Send SMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center">Send OTP in PHP</h1>
        <form action="" method="post" class="mt-5">
            <input type="text" placeholder="Mobile number" name="num" class="form-control" required><br>
            <input type="submit" class="btn btn-primary" value="Send OTP" name="btn">
        </form>

        <?php if ($otpSent): // Only show this if OTP was sent ?>
        <form action="" method="post" class="mt-3">
            <input type="text" placeholder="Enter OTP" name="inputOtp" class="form-control" required>
            <input type="submit" class="btn btn-success mt-2" value="Verify OTP" name="verify">
        </form>
        <?php endif; ?>

        <p class="text-center text-danger"><?php echo $err; ?></p>
        <p class="text-center text-success"><?php echo $ses; ?></p>
    </div>

</body>

</html>
