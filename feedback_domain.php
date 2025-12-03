<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['trainer_id'])) {
    header("Location: Loginpage.php");
    exit;
}

$trainer_id = $_SESSION['trainer_id'];

$stmt = $conn->prepare("
    SELECT rating, comment, created_at
    FROM trainer_feedback
    WHERE trainer_id = ?
    ORDER BY created_at DESC
");
$stmt->bind_param("i", $trainer_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="Trainerdbstyle.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<title>Trainer Feedbacks</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f1f1f1;
    display: flex;
    min-height: 100vh;
    margin: 0;
}

.sidebar {
    width: 250px;
    background-color: #161515;
    color: #fff;
    padding: 20px;
}
.sidebar h2 { text-align: center; margin-bottom: 30px; }
.sidebar ul { list-style: none; padding: 0; }
.sidebar ul li { padding: 15px 0; }
.sidebar ul li a { color: #e6e6e6; text-decoration: none; display: flex; align-items: center; }
.sidebar ul li a i { margin-right: 10px; }
.sidebar ul li:hover { background: #333; border-radius: 5px; }

.main-content {
    flex-grow: 1;
    padding: 20px;
}

.header p { font-size: 22px; margin-bottom: 20px; }

.feedback-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}
.feedback-table th, .feedback-table td {
    padding: 14px 18px;
    border-bottom: 1px solid #eee;
    text-align: left;
}
.feedback-table th {
    background-color: #6c63ff;
    color: white;
}
.feedback-table tr:hover { background-color: #f9f9f9; }
</style>
</head>
<body>

<div class="sidebar">
    <h2>Trainer Dashboard</h2>
    <ul>
        <li><a href="Trainerdashboard.php"><i class='bx bxs-bar-chart-alt-2'></i> Profile</a></li>
        <li><a href="TrainerClients.php"><i class='bx bxs-bar-chart-alt-2'></i> Clients</a></li>
        <li><a href="feedback_domain.php"><i class='bx bxs-bar-chart-alt-2'></i> Feedbacks</a></li>
        <li><a href="Loginpage.php"><i class='bx bx-log-out'></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <h2>Your Feedback</h2>

    <table class="feedback-table">
        <thead>
            <tr>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= str_repeat("⭐", $row['rating']) ?></td>
                    <td><?= htmlspecialchars($row['comment']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3">No feedback yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
