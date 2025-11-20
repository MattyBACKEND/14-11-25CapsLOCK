<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Processing Payment...</title>
</head>
<body>
<h2>Finalizing your booking…</h2>
<p>Please wait, do not close the page.</p>

<form id="submitBooking" action="save_booking.php" method="POST">
    <input type="hidden" name="trainer_id" id="trainer_id">
    <input type="hidden" name="date" id="date">
    <input type="hidden" name="time" id="time">
    <input type="hidden" name="sessions" id="sessions">
    <input type="hidden" name="total_price" id="total_price">
</form>

<script>
// Retrieve booking selected before PayPal checkout
let booking = JSON.parse(localStorage.getItem("selectedBooking"));

if (!booking) {
    alert("No booking data found. Payment succeeded but booking was not recorded.");
} else {

    document.getElementById("trainer_id").value = new URLSearchParams(window.location.search).get("trainer_id");
    document.getElementById("date").value = booking.date;
    document.getElementById("time").value = booking.time;
    document.getElementById("sessions").value = booking.sessions;
    document.getElementById("total_price").value = booking.amount;

    // Auto-submit to save into database
    document.getElementById("submitBooking").submit();
}
</script>

</body>
</html>
