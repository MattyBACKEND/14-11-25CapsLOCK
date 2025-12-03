<?php
session_start();
include 'connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['trainer_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$trainer_id = $_SESSION['trainer_id'];

$stmt = $conn->prepare("
    SELECT b.date, b.time, u.fullname
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    WHERE b.trainer_id = ?
    ORDER BY b.booked_at DESC
    LIMIT 5
");

$stmt->bind_param("i", $trainer_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while($row = $result->fetch_assoc()){
    $notifications[] = "New booking from {$row['fullname']} on {$row['date']} at {$row['time']}";
}

echo json_encode([
    'success' => true,
    'count' => count($notifications),
    'notifications' => $notifications
]);
?>
