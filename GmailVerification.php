<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composer autoload

// Replace these with your user info and your Gmail
$email = 'ecgfit@gmail.com'; // Recipient's email
$verification_code = bin2hex(random_bytes(16)); // unique code

// Gmail SMTP setup
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ecgfit@gmail.com'; // Your Gmail
    $mail->Password = 'your_app_password';    // App password (NOT your Gmail password)
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Sender & recipient
    $mail->setFrom('ecgfit@gmail.com', 'ECG Fitness'); // sender
    $mail->addAddress($email);                             // recipient

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Verify Your Email';
    $mail->Body = "Click the link below to verify your email:<br><br>
        <a href='http://yourdomain.com/verify.php?code=$verification_code'>Verify Email</a>";

    $mail->send();
    echo "Verification email sent successfully!";
} catch (Exception $e) {
    echo "Error sending email: {$mail->ErrorInfo}";
}