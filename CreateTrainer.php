<?php
include 'connection.php'; // Your DB connection file

// Fetch all trainers
$result = $conn->query("SELECT * FROM trainers");
$trainers = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trainers[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trainer Dashboard</title>
    <link rel="stylesheet" href="Admindbstyle.css">
    <link rel="stylesheet" href="CreateTrainer.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="Images/ecglogo.jpg" alt="Logo" class="sidebar-logo">
            <h2>ADMIN</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="Admindashboard.php" id="logins-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
            </svg> <i class="bi bi-person-fill"></i> User Accounts</a></li>

            <li><a href="Logsheets.php" id="logsheets-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/>
        </svg> <i class="bi bi-person-lines-fill"></i> Logsheets</a></li>

            <li><a href="Masterlist.php" id="masterlist-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
        </svg> <i class="bi bi-person-vcard-fill"></i> Masterlist</a></li>

           <!-- <li><a href="Special_Training.php" id="training-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-standing" viewBox="0 0 16 16">
        <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M6 6.75v8.5a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2.75a.75.75 0 0 0 1.5 0v-2.5a.25.25 0 0 1 .5 0"/>
        </svg> <i class="bi bi-person-standing"></i> Special Training</a></li> -->

            <li><a href="#" class="active" id="trainer-acc-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
        </svg> <i class="bi bi-box-seam-fill"></i> Trainers Accounts</a></li>

            <li><a href="TransactionHistory.php" id="products-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
        </svg> <i class="bi bi-box-seam-fill"></i> Transaction History</a></li>
        </ul>

      <div class="logout-container">
          <a href="Loginpage.php" class="logout-button">
            <i class='bx bx-log-out-circle'></i> Logout </a>
</div> 
    </div>

    <!-- Main Content -->
    <div class="main-content">
   
        <!-- <div class="card">
            <h2>Trainer Lists</h2>
            <div class="clients">
                <div class="client-card">
                    <h3>Trainer Name</h3>
                    <p>Training: Boxing</p>
                    <p>Clients: 5</p>
                    <button>View</button>
                </div>
                <div class="client-card">
                    <h3>Trainer Name</h3>
                    <p>Training: Muay Thai</p>
                    <p>Clients: 2</p>
                    <button>View</button>
                </div>
                <div class="client-card">
                    <h3>Trainer Name</h3>
                    <p>Training: Weightlifting</p>
                    <p>Clients: 3</p>
                    <button>View</button>
                </div>
            </div>
        </div>  -->
            

        <!-- Create Trainer Accounts Section -->
        <div class="card">
            <h2>Create Trainer Accounts</h2>

            <!-- Add Trainer Account Button -->
            <button onclick="document.getElementById('addTrainerModal').style.display='block'">
                Add Trainer Account
            </button>

            <!-- Add Trainer Modal -->
            <div id="addTrainerModal" style="display:none; position:fixed; top:37%; left:43%; background-color: color-mix(in hsl, black 100%); padding:75px; border-radius:8px; box-shadow:0 0 10px #000;">
                <form action="AddTrainer.php" method="POST">
                    <label>Trainer Name:</label><br>
                    <input type="text" name="trainer_name" required><br><br>

                    <label>Email:</label><br>
                    <input type="email" name="email" required><br><br>

                    <label>Password:</label><br>
                    <input type="password" name="password" required><br><br>

                    <button type="submit">Submit</button>
                    <button type="button" onclick="document.getElementById('addTrainerModal').style.display='none'">Cancel</button>
                </form>
            </div>

            <!-- Trainer Table (Now Dynamic) -->
            <table>
                <thead>
                    <tr>
                        <th>Trainer Name</th>
                        <th>Email</th>
                        <th>Password</th>
                    </tr>
                </thead>
               <tbody>
                <?php foreach ($trainers as $trainer): ?>
                    <tr>
                    <td><?= htmlspecialchars($trainer['name']) ?></td>
                    <td><?= htmlspecialchars($trainer['email']) ?></td>
                    <td>
                        <?= htmlspecialchars($trainer['password']) ?>
                        <!-- Edit Button -->
                        <button onclick="openEditModal(<?= $trainer['trainer_id'] ?>, '<?= $trainer['name'] ?>', '<?= $trainer['email'] ?>', '<?= $trainer['password'] ?>')">Edit</button>
                        <!-- Delete Form -->
                        <form action="DeleteTrainer.php" method="POST" style="display:inline;">
                        <input type="hidden" name="trainer_id" value="<?= $trainer['trainer_id'] ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this trainer?')">Delete</button>
                        </form>
                    </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>

        </div>

    </div>

    <div id="editTrainerModal" style="display:none; position:fixed; top:20%; left:35%; background:white; padding:20px; border-radius:8px; box-shadow:0 0 10px #000;">
    <form action="EditTrainer.php" method="POST">
        <input type="hidden" name="id" id="edit_id">
        
        <label>Trainer Name:</label><br>
        <input type="text" name="trainer_name" id="edit_name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" id="edit_email" required><br><br>

        <label>Password:</label><br>
        <input type="text" name="password" id="edit_password" required><br><br>

        <button type="submit">Save</button>
        <button type="button" onclick="document.getElementById('editTrainerModal').style.display='none'">Cancel</button>
    </form>
    </div>

    <script>
    function openEditModal(id, name, email, password) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_password').value = password;
    document.getElementById('editTrainerModal').style.display = 'block';
    }
    </script>


</body>
</html>