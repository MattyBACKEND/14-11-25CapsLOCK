<?php
session_start();

// SEND RECEIPT EMAIL -------------------------
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

// Check if user is logged in
if (!isset($_SESSION['client_id'])) {
    die("Error: No client logged in.");
}

$client_id = $_SESSION['client_id'];

// Connect to database
$conn = new mysqli("localhost", "root", "", "ecg_fitness");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch fullname & email of client
$stmt = $conn->prepare("SELECT fullname, email FROM users WHERE id = ?");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$stmt->bind_result($client_name, $client_email);
$stmt->fetch();
$stmt->close();

// Define membership options
$membershipOptions = [
    "student_1year"       => ["label" => "Student - 1 Year", "price" => 1],
    "student_lifetime"    => ["label" => "Student - Lifetime", "price" => 1],
    "student_1month"      => ["label" => "Student - 1 Month", "price" => 1],
    "student_3plus1"      => ["label" => "Student - 3 + 1 Month", "price" => 1],
    "student_6months"     => ["label" => "Student - 6 Months", "price" => 1],
    "student_12months"    => ["label" => "Student - 12 Months", "price" => 1],
    "nonstudent_1year"    => ["label" => "Non-Student - 1 Year", "price" => 1],
    "nonstudent_lifetime" => ["label" => "Non-Student - Lifetime", "price" => 1],
    "nonstudent_1month"   => ["label" => "Non-Student - 1 Month", "price" => 1],
    "nonstudent_3plus1"   => ["label" => "Non-Student - 3 + 1 Month", "price" => 1],
    "nonstudent_6months"  => ["label" => "Non-Student - 6 Months", "price" => 1],
    "nonstudent_12months" => ["label" => "Non-Student - 12 Months", "price" => 1],
];

// Process membership selection
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["membership"])) {
    $selected = $_POST["membership"];

    if (array_key_exists($selected, $membershipOptions)) {
        $membershipLabel = $membershipOptions[$selected]["label"];
        $price = $membershipOptions[$selected]["price"];
        $payment_type = "Paypal"; // Default payment type set to PayPal

        // Insert into payment_transaction with current timestamp
        $stmt = $conn->prepare("
            INSERT INTO payment_transaction (Time, client_id, Training, Amount, Payment_type)
            VALUES (NOW(), ?, ?, ?, ?)
        ");
        $stmt->bind_param("isds", $client_id, $membershipLabel, $price, $payment_type);
        $stmt->execute();
        $stmt->close();

        require 'PHPMailer-Master/src/PHPMailer.php';
        require 'PHPMailer-Master/src/SMTP.php';
        require 'PHPMailer-Master/src/Exception.php';

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ecgsender@gmail.com'; // your gmail
            $mail->Password   = 'aevyinvepakvvpxz';     // gmail app password
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom('ecgsender@gmail.com', 'ECG Fitness');
            $mail->addAddress($client_email, $client_name);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Payment Receipt - ECG Fitness';
            $mail->Body = "
                <h2>ECG Fitness Payment Receipt</h2>
                <p><strong>Name:</strong> {$client_name}</p>
                <p><strong>Membership:</strong> {$membershipLabel}</p>
                <p><strong>Amount Paid:</strong> ₱{$price}</p>
                <p><strong>Payment Method:</strong> Paypal</p>
                <p><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</p>
                <hr>
                <p>Thank you for your purchase!</p>
            ";

            $mail->send();

        } catch (Exception $e) {
            error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
        }
        // --------------------------------------------------------

        // Display confirmation page
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>Payment Confirmation</title>
            <style>
                body { background-color: #1e1e1e; color: #f1f1f1; font-family: Arial, sans-serif; padding: 20px; }
                .confirmation { background-color: #2c2c2c; border: 1px solid #444; padding: 20px; border-radius: 10px; }
                h2 { color: rgb(186,189,52); }
                .btn-dashboard { color: rgb(186,189,52); text-decoration: none; display: inline-block; margin-top: 15px; }
            </style>
        </head>
        <body>
            <div class='confirmation'>
                <h2>Payment Summary</h2>
                <p><strong>Client Name:</strong> {$client_name}</p>
                <p><strong>Membership Selected:</strong> {$membershipLabel}</p>
                <p><strong>Price:</strong> ₱{$price}</p>
                <p>A receipt has been sent to your email.</p>
                <a href='loginpage.php' class='btn-dashboard'>Go to Login</a>
            </div>
        </body>
        </html>";
    } else {
        echo "Invalid membership option selected.";
    }
} else {
    echo "No membership option selected. Please go back and choose a plan.";
}
?>