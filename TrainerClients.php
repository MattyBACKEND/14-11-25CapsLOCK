<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['trainer_id'])) {
    header("Location: Loginpage.php");
    exit();
}

$trainer_id = $_SESSION['trainer_id'];

$stmt = $conn->prepare("
    SELECT b.*, u.fullname
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    WHERE b.trainer_id = ?
    ORDER BY b.booked_at DESC
");

$stmt->bind_param("i", $trainer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trainer Clients</title>
<link rel="stylesheet" href="Trainerdbstyle.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
.client-table {
    margin: 30px auto;
    width: 90%;
    background: #fff;
    border-collapse: collapse;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}
.client-table th, .client-table td {
    padding: 14px 18px;
    border-bottom: 1px solid #eee;
    text-align: left;
}
.client-table th {
    background-color: #6c63ff;
    color: white;
}
.client-table tr:hover { background-color: #f9f9f9; }
.header p { font-size: 22px; margin-left: 20px; }

/* Toast Style */
#toast {
    position: fixed;
    top: 25px;
    right: 25px;
    z-index: 9999;
}
.toast-message {
    background: #4CAF50;
    color: white;
    padding: 14px 18px;
    margin-top: 10px;
    border-radius: 8px;
    animation: fadein .5s, fadeout .5s 2.5s;
    font-size: 15px;
}
.toast-message.error { background: #e74c3c; }

@keyframes fadein { from{opacity:0; transform:translateX(40px);} to{opacity:1; transform:translateX(0);} }
@keyframes fadeout { from{opacity:1;} to{opacity:0;} }
</style>
</head>

<body>

<div id="toast"></div> <!-- TOAST CONTAINER -->

<div class="sidebar">
    <h2>Trainer Dashboard</h2>
    <ul>
        <li><a href="Trainerdashboard.php"><i class='bx bxs-bar-chart-alt-2'></i> Profile</a></li>
        <li><a href="#"><i class='bx bxs-bar-chart-alt-2'></i> Clients</a></li>
        <li><a href="Loginpage.php"><i class='bx bx-log-out'></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header"><p>List of Clients</p></div>

    <table class="client-table">
        <thead>
            <tr>
                <th>Client Username</th>
                <th>Sessions Booked</th>
                <th>Total Paid</th>
                <th>Booking Date</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr id="row-<?= $row['id'] ?>">
                <td><?= htmlspecialchars($row['fullname']) ?></td>
                <td><?= $row['session_count'] ?></td>
                <td>₱<?= $row['total_price'] ?></td>
                <td>
                    <?= date('Y-m-d H:i', strtotime($row['booked_at'])) ?>

                    <a href="update_booking.php?id=<?= $row['id'] ?>" 
                       style="padding:6px 10px; background:#4CAF50; color:white; border-radius:5px; text-decoration:none; margin-left:10px; font-size:13px;">
                       Update
                    </a>

                    <button onclick="cancelBooking(<?= $row['id'] ?>)" 
                            style="padding:6px 10px; background:#e74c3c; color:white; border-radius:5px; border:none; margin-left:5px; font-size:13px; cursor:pointer;">
                        Cancel
                    </button>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">No bookings yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
// Toast function
function showToast(msg, type='success') {
    const box = document.getElementById("toast");
    const div = document.createElement("div");
    div.className = "toast-message " + (type === 'error' ? 'error' : '');
    div.textContent = msg;
    box.appendChild(div);
    setTimeout(() => div.remove(), 3000);
}

// Cancel booking AJAX
function cancelBooking(id) {
    if (!confirm("Are you sure you want to cancel this booking?")) return;

    fetch("cancel_booking.php?id=" + id, { method: "POST" })
    .then(res => res.text())
    .then(resp => {
        if (resp.trim() === "success") {
            document.getElementById("row-" + id).remove();
            showToast("Booking successfully canceled.");
        } else {
            showToast("Failed to cancel booking.", "error");
        }
    });
}
</script>

</body>
</html>
