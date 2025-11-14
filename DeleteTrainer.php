<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['trainer_id'];

    // Start a transaction to ensure both delete operations are handled together
    $conn->begin_transaction();

    try {
        // Delete related bookings first
        $stmt = $conn->prepare("DELETE FROM bookings WHERE trainer_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Now delete the trainer
        $stmt = $conn->prepare("DELETE FROM trainers WHERE trainer_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Commit the transaction
        $conn->commit();

        // Redirect to the trainers page
        header("Location: CreateTrainer.php"); // adjust to your page
        exit;

    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
