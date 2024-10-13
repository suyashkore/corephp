

<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // This will load all necessary files including PHPMailer

// $mail = new PHPMailer(true);

// try {
//     // Server settings
//     $mail->isSMTP();
//     $mail->Host = 'smtp.gmail.com'; // Set your mail server host
//     $mail->SMTPAuth = true;
//     $mail->Username = 'koresuyashravan@gmail.com'; // Your Gmail address
//     $mail->Password = 'ummz quhl waek ynlr'; // Your Gmail app password
//     $mail->SMTPSecure = 'tls';
//     $mail->Port = 587;

//     // Recipients
//     $mail->setFrom('koresuyashravan@gmail.com', 'mail');
//     $mail->addAddress('koresuyashravan@gmail.com');

//     // Content
//     $mail->isHTML(true);
//     $mail->Subject = 'Suyash';
//     $mail->Body    = 'Suyash kore mail send';

//     $mail->send();
//     echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
    <title>Contact Form</title>
</head>
<body>
    <div class="container">
        <h2>mail Send</h2>
        <form id="contactForm" action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="text">Message:</label>
            <textarea id="text" name="msg" required></textarea>

            <button type="submit" name="send">Submit</button>
        </form>
    </div>

    <?php
      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\Exception;
if (isset($_POST['send'])) {

    require 'vendor/autoload.php'; // Autoload PHPMailer classes

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['msg']);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'pawarnana2000@gmail.com'; 
        $mail->Password = 'qpie ixgz sjbo erhy'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('pawarnana2000@gmail.com', $name); 
        $mail->addAddress($email); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Message from $name";
        $mail->Body    = "<p><strong>Name:</strong> $name</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Message:</strong><br>$message</p>";

        $mail->send();
        echo '<p style="color: green;">Message has been sent successfully to ' . $email . '!</p>';
    } catch (Exception $e) {
        echo "<p style='color: red;'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>";
    }
}
?>

</body>
</html>
