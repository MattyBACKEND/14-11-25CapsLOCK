<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['trainer_id'])) {
    header("Location: Loginpage.php");
    exit();
}

$trainer_id = $_SESSION['trainer_id'];

// Fetch client bookings for this trainer
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
        .client-table tr:hover {
            background-color: #f9f9f9;
        }
        .header p {
            font-size: 22px;
            margin-left: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Trainer Dashboard</h2>
    <ul>
        <li><a href="Trainerdashboard.php"><i class='bx bxs-bar-chart-alt-2'></i> Profile</a></li>
        <li><a href="#"><i class='bx bxs-bar-chart-alt-2'></i> Clients</a></li>
        <li><a href="Loginpage.php"><i class='bx bx-log-out'></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header">
        <p>Lists of Clients</p>
    </div>

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
                    <tr>
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td><?= $row['session_count'] ?></td>
                        <td>₱<?= $row['total_price'] ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($row['booked_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No bookings yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>