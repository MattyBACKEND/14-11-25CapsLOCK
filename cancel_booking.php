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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cancel Booking</title>
</head>
<body>

<h2>Are you sure you want to cancel this booking?</h2>

<form method="POST" action="cancel_booking.php?id=<?= $booking_id ?>">
    <button type="submit" name="confirm" value="yes" style="background:red;color:white;">Yes, Cancel</button>
    <a href="trainerClients.php" style="margin-left:20px;">No, Go Back</a>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['confirm'] === "yes") {
    $delete = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $delete->bind_param("i", $booking_id);

    if ($delete->execute()) {
        header("Location: cancel_success.php");
        exit();
    } else {
        echo "Failed to cancel booking.";
    }
}
?>

</body>
</html>
