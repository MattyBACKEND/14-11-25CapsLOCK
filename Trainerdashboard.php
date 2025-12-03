<?php
session_start();
if (!isset($_SESSION['trainer_name']) || !isset($_SESSION['trainer_id'])) {
    header("Location: Loginpage.php");
    exit();
}

include 'connection.php';

$trainerId = $_SESSION['trainer_id'];

// Make sure uploads folder exists
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aboutMe = $_POST['about_me'];
    $specialization = $_POST['specialization'];
    $location = $_POST['location'];

    $daysOfWeek = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    $schedule = [];
    foreach ($daysOfWeek as $day) {
        $schedule[$day] = isset($_POST['schedule'][$day]) ? true : false;
    }
    $scheduleJson = json_encode($schedule);

    $profilePic = "";
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
        $filename = 'uploads/trainer_' . $trainerId . '.' . $ext;
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filename);
        $profilePic = $filename;
    }

    $check = $conn->prepare("SELECT * FROM trainer_profiles WHERE trainer_id = ?");
    $check->bind_param("i", $trainerId);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        if (!empty($profilePic)) {
            $stmt = $conn->prepare("UPDATE trainer_profiles SET about_me=?, specialization=?, location=?, profile_pic=?, schedule=? WHERE trainer_id=?");
            $stmt->bind_param("sssssi", $aboutMe, $specialization, $location, $profilePic, $scheduleJson, $trainerId);
        } else {
            $stmt = $conn->prepare("UPDATE trainer_profiles SET about_me=?, specialization=?, location=?, schedule=? WHERE trainer_id=?");
            $stmt->bind_param("ssssi", $aboutMe, $specialization, $location, $scheduleJson, $trainerId);
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO trainer_profiles (trainer_id, about_me, specialization, location, profile_pic, schedule) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $trainerId, $aboutMe, $specialization, $location, $profilePic, $scheduleJson);
    }
    $stmt->execute();
    header("Location: Trainerdashboard.php?success=1");
    exit();
}

$profile = $conn->query("SELECT * FROM trainer_profiles WHERE trainer_id = $trainerId")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trainer Dashboard</title>
    <link rel="stylesheet" href="Trainerdbstyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .week-schedule input[type="checkbox"] {
            transform: scale(1.2);
            margin-right: 6px;
        }
        .week-schedule label {
            display: inline-block;
            margin-bottom: 8px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Trainer Dashboard</h2>
    <ul>
        <li><a href="#"><i class='bx bxs-bar-chart-alt-2'></i> Profile</a></li>
        <li><a href="TrainerClients.php"><i class='bx bxs-bar-chart-alt-2'></i> Clients</a></li>
        <li><a href="feedback_domain.php"><i class='bx bxs-bar-chart-alt-2'></i> Feedbacks</a></li>
        <li><a href="Loginpage.php"><i class='bx bx-log-out'></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header" style="display: flex; justify-content: space-between; align-items: center;">
    <p style="font-weight: bold">Welcome <?= htmlspecialchars($_SESSION['trainer_name']) ?> ! </p>

    <!-- Notification Bell -->
    <div style="position: relative;">
        <button id="notifBtn" style="background:none; border:none; cursor:pointer; font-size:20px; position: relative;">
            🔔
            <span id="notifCount" style="
                display:none;
                position:absolute;
                top:-5px;
                right:-5px;
                background:red;
                color:white;
                border-radius:50%;
                padding:2px 6px;
                font-size:12px;
            ">0</span>
        </button>

        <div id="notifDropdown" style="
            display:none;
            position:absolute;
            right:0;
            margin-top:5px;
            background:white;
            border:1px solid #ccc;
            width:250px;
            max-height:300px;
            overflow-y:auto;
            box-shadow:0 4px 12px rgba(0,0,0,0.15);
            z-index:100;
        ">
            <div id="notifList"></div>
        </div>
    </div>
</div>

    <?php if (!isset($_GET['edit']) && $profile): ?>
        <div class="trainer-profile-display">
            <?php if (!empty($profile['profile_pic'])): ?>
                <img src="<?= $profile['profile_pic'] ?>" width="150"><br>
            <?php endif; ?>
            <h3>About Me</h3>
            <p><?= nl2br(htmlspecialchars($profile['about_me'])) ?></p>

            <h3>Workout Specialization</h3>
            <p><?= htmlspecialchars($profile['specialization']) ?></p>

            <h3>Location</h3>
            <p><?= htmlspecialchars($profile['location']) ?></p>

            <h3>Weekly Availability</h3>
            <ul style="list-style: none; padding: 0;">
                <?php
                    $schedule = json_decode($profile['schedule'] ?? '{}', true);
                    foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day) {
                        if (!empty($schedule[$day])) {
                            echo "<li> $day</li>";
                        }
                    }
                ?>
            </ul>

            <a href="?edit=1"><button>Edit Profile</button></a>
        </div>
    <?php else: ?>
        <form method="POST" enctype="multipart/form-data" class="trainer-profile-form">
            <h2><?= $profile ? "Edit Profile" : "Create Profile" ?></h2>

            <?php if (!empty($profile['profile_pic'])): ?>
                <img src="<?= $profile['profile_pic'] ?>" width="150"><br>
            <?php endif; ?>

            <label>Upload Profile Picture:</label><br>
            <input type="file" name="profile_pic"><br><br>

            <label>About Me:</label><br>
            <textarea name="about_me" rows="4" required><?= htmlspecialchars($profile['about_me'] ?? '') ?></textarea><br><br>

            <label>Workout Specialization:</label><br>
            <select name="specialization" required>
                <option <?= ($profile['specialization'] ?? '') === "Boxing" ? "selected" : "" ?>>Boxing</option>
                <option <?= ($profile['specialization'] ?? '') === "Muay Thai" ? "selected" : "" ?>>Muay Thai</option>
                <option <?= ($profile['specialization'] ?? '') === "Circuit Training" ? "selected" : "" ?>>Circuit Training</option>
                <option <?= ($profile['specialization'] ?? '') === "Weight Lifting" ? "selected" : "" ?>>Weight Lifting</option>
            </select><br><br>

            <label>Location:</label><br>
            <select name="location" required>
                <option <?= ($profile['location'] ?? '') === "Ecg Pro" ? "selected" : "" ?>>Ecg Pro</option>
                <option <?= ($profile['location'] ?? '') === "Pascam II" ? "selected" : "" ?>>Pascam II</option>
            </select><br><br>

            <label>Weekly Availability:</label><br>
            <div class="week-schedule">
                <?php
                    $savedSchedule = json_decode($profile['schedule'] ?? '{}', true);
                    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                    foreach ($days as $day):
                        $checked = !empty($savedSchedule[$day]) ? "checked" : "";
                ?>
                    <label style="margin-right: 15px;">
                        <input type="checkbox" name="schedule[<?= $day ?>]" <?= $checked ?>> <?= $day ?>
                    </label>
                <?php endforeach; ?>
            </div><br><br>

            <button type="submit">Save Profile</button>
        </form>
    <?php endif; ?>
</div>

<script>
// Toggle notifications dropdown
document.getElementById('notifBtn').addEventListener('click', () => {
    const dropdown = document.getElementById('notifDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
});

// Function to update notification bell and list
function updateNotifications() {
    fetch('fetch_notifications.php')
    .then(res => res.json())
    .then(data => {
        if(!data.success) return;

        const notifCount = document.getElementById('notifCount');
        const notifList = document.getElementById('notifList');

        notifCount.style.display = data.count > 0 ? 'inline-block' : 'none';
        notifCount.textContent = data.count;

        notifList.innerHTML = '';
        if(data.notifications.length === 0){
            notifList.innerHTML = '<div style="padding:8px; border-bottom:1px solid #eee;">No new notifications</div>';
        } else {
            data.notifications.forEach(msg => {
                notifList.innerHTML += `<div style="padding:8px; border-bottom:1px solid #eee;">${msg}</div>`;
            });
        }
    })
    .catch(err => console.error(err));
}

// Initial fetch
updateNotifications();

// Optional: refresh every 15 seconds
setInterval(updateNotifications, 15000);
</script>


</body>
</html>