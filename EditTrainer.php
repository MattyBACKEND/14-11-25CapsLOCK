<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $trainer_name = $_POST['trainer_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("UPDATE trainers SET name=?, email=?, password=? WHERE trainer_id=?");
    $stmt->bind_param("sssi", $trainer_name, $email, $password, $id);

    if ($stmt->execute()) {
        header("Location: CreateTrainer.php"); // adjust to your page
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>