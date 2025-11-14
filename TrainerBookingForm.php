<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
  die("You must be logged in to book a session.");
};

// Step 1: Get trainer_id from GET for form display
$trainer_id = $_GET['trainer_id'] ?? $_POST['trainer_id'] ?? null;

// Step 2: Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // Always get trainer_id from POST
    $trainer_id = $_POST['trainer_id'];

    $session_count = intval($_POST['session_count']);
    $price_per_session = 50;
    $total_price = $session_count * $price_per_session;

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, trainer_id, session_count, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $user_id, $trainer_id, $session_count, $total_price);

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;

        header("Location: TrainerBooking.php?receipt=1&booking_id=$booking_id&trainer_id=$trainer_id");
        exit();
    } else {
        echo "Booking failed: " . $conn->error;
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Training Session</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Book Training Session</h1>

    <?php if ($trainer_id): ?>
        <form action="TrainerBookingForm.php" method="POST">
            <input type="hidden" name="trainer_id" value="<?= htmlspecialchars($trainer_id) ?>">
            <label>Number of Sessions:</label>
            <select name="session_count" required>
                <?php for ($i = 1; $i <= 16; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?> session<?= $i > 1 ? 's' : '' ?> - ₱<?= $i * 50 ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit">Proceed to Payment →</button>
        </form>
    <?php else: ?>
        <p style="color:red;">Trainer ID missing. Please go back and choose a trainer.</p>
    <?php endif; ?>
</body>
</html>