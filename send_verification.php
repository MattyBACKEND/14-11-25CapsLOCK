<?php
session_start();

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'PHPMailer-Master/src/PHPMailer.php';
require 'PHPMailer-Master/src/SMTP.php';
require 'PHPMailer-Master/src/Exception.php';

// Check if email was submitted
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $code = rand(100000, 999999);
    $_SESSION['verification_code'] = $code;

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ecgsender@gmail.com'; // Replace with your Gmail
        $mail->Password   = 'jxvmvstlihznchay';     // Replace with your Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Email content
        $mail->setFrom('ecgsender@gmail.com', 'ECG Fitness'); // Sender
        $mail->addAddress($email);                            // Recipient
        $mail->Subject = 'Your Verification Code';
        $mail->Body    = "Your verification code is: $code";

        $mail->send();
        echo 'sent';
    } catch (Exception $e) {
        echo 'fail';
    }
}
?>