<?php
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="UserDetailStyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>User Details</title>

</head>
<body>
<div class="sidebar">
    <h2>Member Panel</h2>
    <ul>
        <li><a href="UserDetails.php"><i class='bx bxs-bar-chart-alt-2'></i>User details</a></li>
        <li><a href="user.php"><i class='bx bxs-bar-chart-alt-2'></i> Workouts</a></li>
        <li><a href="Progress.php"><i class='bx bxs-bar-chart-square'></i>Progress</a></li>
        <li><a href="Trainer.php"><i class='bx bxs-cog'></i> Trainers</a></li>
        <li><a href="Loginpage.php"><i class='bx bx-log-out'></i> Logout</a></li>

    </ul>
</div>

<div class="main-content">
    <div class="header">
        <h1>User Details</h1>
        <p>Enter your Personal Details</p>
    </div>  

<div class = "txt-field basic-info">
    <div class="header">
        <h2>Basic Information</h2><br>
            <input type="text" name="FullName" id="FN" placeholder="Fullname"required>
            <input type="number" name="Age" id="AGE" placeholder="Age"required><br>

    <div class="gender-group">
            <label><input type="radio" name="gender" value="Male"> Male</label>
            <label><input type="radio" name="gender" value="Female"> Female</label>
            <label><input type="radio" name="gender" value="Non-Biary">Rather not Say</label>
    </div>

            <input type="text" name="Address" id="ADD" placeholder="Address"required>
            <input type="tel" name="Contact Number" id="CNumber" 
                    placeholder="09XXXXXXXXX" 
                    pattern="09[0-9]{9}"
                    maxlength="11"
                    required>
            <input type="text" name="EmergencyNum" id="Emergency" placeholder="Emergency Contanct Number">
</div>

<div class = "txt-field BMI">
    <div class="header">
       <h2>Physical Information</h2><br>
            <input type="text" name="Height" id="HN" placeholder="Height">
            <input type="text" name="Weight" id="WT" placeholder="Weight">
            <input type="text" name="BMI" id="BDY" placeholder="BMI/Body Mass Index"> 
    </div>
</div>
</div>
</body>

<!-- BMI CALCULATOR SECTION -->
<script>

</script>

</html>