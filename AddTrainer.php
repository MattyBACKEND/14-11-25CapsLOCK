<?php
include 'connection.php'; // your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trainer_name = $_POST['trainer_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Consider hashing this

    // Simple validation
    if (!empty($trainer_name) && !empty($email) && !empty($password)) {
        // Insert into DB
        $stmt = $conn->prepare("INSERT INTO trainers (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $trainer_name, $email, $password);

        if ($stmt->execute()) {
            header("Location: CreateTrainer.php"); // reloads trainer list
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "All fields are required.";
    }
}
?>