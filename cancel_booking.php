<?php
include 'connection.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->bind_param("i", $id);
echo $stmt->execute() ? "success" : "error";
