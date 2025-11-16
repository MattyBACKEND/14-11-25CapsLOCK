<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

// CONNECT TO DATABASE
$conn = new mysqli("localhost", "root", "", "ecg_fitness");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// GET CLIENT NAME
$client_id = $_SESSION['client_id'] ?? "Unknown User";

// MAP MEMBERSHIP TO PRICE + LABEL
$membership = $data['membership'];
$prices = [
    "student_1year" => 499,
    "student_lifetime" => 1999,
    "student_1month" => 1099,
    "student_3plus1" => 3799,
    "student_6months" => 5499,
    "student_12months" => 9999,

    "nonstudent_1year" => 799,
    "nonstudent_lifetime" => 3999,
    "nonstudent_1month" => 1399,
    "nonstudent_3plus1" => 4899,
    "nonstudent_6months" => 6999,
    "nonstudent_12months" => 12999
];

$labels = [
    "student_1year" => "Student 1 Year",
    "student_lifetime" => "Student Lifetime",
    "student_1month" => "Student 1 Month",
    "student_3plus1" => "Student 3+1",
    "student_6months" => "Student 6 Months",
    "student_12months" => "Student 12 Months",

    "nonstudent_1year" => "Non-Student 1 Year",
    "nonstudent_lifetime" => "Non-Student Lifetime",
    "nonstudent_1month" => "Non-Student 1 Month",
    "nonstudent_3plus1" => "Non-Student 3+1",
    "nonstudent_6months" => "Non-Student 6 Months",
    "nonstudent_12months" => "Non-Student 12 Months"
];

$amount = $prices[$membership];
$trainingType = $labels[$membership];
$paymentType = "PayPal";

// INSERT INTO DATABASE
$sql = "INSERT INTO payment_transaction (Time, client_name, Training, Amount, Payment_type)
        VALUES (NOW(), ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssis", $client_name, $trainingType, $amount, $paymentType);

if ($stmt->execute()) {
    echo "SUCCESS: Payment stored.";
} else {
    echo "ERROR: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
