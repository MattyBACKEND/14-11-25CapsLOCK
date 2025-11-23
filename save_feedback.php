<?php
session_start();
include 'connection.php'; // your database connection

header('Content-Type: application/json');

if (!isset($_SESSION['trainer_id'])) {
    echo json_encode(['success' => false, 'error' => 'You must be logged in']);
    exit;
}

$trainer_id = $_SESSION['trainer_id'];

// Read JSON input
$input = json_decode(file_get_contents('php://input'), true);
$rating = $input['rating'] ?? null;
$comment = $input['comment'] ?? null;

if (!$rating || !$comment) {
    echo json_encode(['success' => false, 'error' => 'All fields are required']);
    exit;
}

// Insert feedback into trainer_feedback table
$stmt = $conn->prepare("INSERT INTO trainer_feedback (trainer_id, rating, comment, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iis", $trainer_id, $rating, $comment);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database error: '.$stmt->error]);
}

$stmt->close();
$conn->close();
?>
