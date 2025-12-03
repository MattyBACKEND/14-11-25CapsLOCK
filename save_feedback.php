<?php
session_start();
include 'connection.php';

header("Content-Type: application/json");

// JSON input
$input = json_decode(file_get_contents("php://input"), true);

$trainer_id = $input['trainer_id'] ?? null;
$rating = $input['rating'] ?? null;
$comment = $input['comment'] ?? null;

// VALIDATION
if (!$trainer_id || !$rating || !$comment) {
    echo json_encode(["success" => false, "error" => "Missing fields"]);
    exit;
}

// INSERT FEEDBACK
$stmt = $conn->prepare("
    INSERT INTO trainer_feedback (trainer_id, rating, comment, created_at)
    VALUES (?, ?, ?, NOW())
");
$stmt->bind_param("iis", $trainer_id, $rating, $comment);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
