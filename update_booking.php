<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['trainer_id'])) {
    header("Location: Loginpage.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Booking ID is missing.");
}

$booking_id = $_GET['id'];

// Fetch booking
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    die("Booking not found.");
}

// Extract date & time from booked_at
$currentDate = date('Y-m-d', strtotime($booking['booked_at']));
$currentTime = date('H:i', strtotime($booking['booked_at']));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_count = $_POST['session_count'];
    $total_price = $_POST['total_price'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Combine date + time
    $newDateTime = $date . " " . $time . ":00";

    $update = $conn->prepare("UPDATE bookings SET session_count=?, total_price=?, booked_at=? WHERE id=?");
    $update->bind_param("idss", $session_count, $total_price, $newDateTime, $booking_id);

    if ($update->execute()) {
        header("Location: update_success.php");
        exit();
    } else {
        echo "Update failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Booking</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }
        input {
            padding: 8px;
            width: 250px;
        }
        button {
            padding: 10px 18px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <h2>Update Booking</h2>

    <form method="POST">

        <label>Session Count:</label><br>
        <input type="number" name="session_count" value="<?= $booking['session_count'] ?>" required><br><br>

        <label>Total Price:</label><br>
        <input type="number" name="total_price" step="0.01" value="<?= $booking['total_price'] ?>" required><br><br>

        <label>New Schedule (Date):</label><br>
        <input type="date" name="date" value="<?= $currentDate ?>" required><br><br>

        <label>New Time:</label><br>
        <input type="time" name="time" value="<?= $currentTime ?>" required><br><br>

        <button type="submit">Update Booking</button>
    </form>

</body>
</html>
