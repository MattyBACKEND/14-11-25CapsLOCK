<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "msg" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$trainer_id = $_POST['trainer_id']; 
$sessions = $_POST['sessions'];
$total_price = $_POST['total_price'];

$stmt = $conn->prepare("
    INSERT INTO bookings (user_id, trainer_id, session_count, total_price)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param("iiid", $user_id, $trainer_id, $sessions, $total_price);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "booking_id" => $stmt->insert_id
    ]);
} else {
    echo json_encode(["status" => "error", "msg" => $conn->error]);
}
?>
