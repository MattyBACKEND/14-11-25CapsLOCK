<?php
include 'connection.php';

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

    <style>
        /* MODAL OVERLAY */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        /* MODAL BOX */
        .modal-box {
            background: #ffffff;
            width: 350px;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from { transform: scale(0.9); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }

        .modal-box h2 {
            margin-bottom: 15px;
            color: #222;
        }

        .modal-box input {
            width: 100%;
            padding: 10px;
            margin: 6px 0 15px;
            border: 1px solid #999;
            border-radius: 5px;
        }

        .modal-btn {
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        .save-btn { background: #28a745; color: white; }
        .cancel-btn { background: #dc3545; color: white; }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #222;
            color: white;
        }

        td button {
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .edit-btn { background: #ffc107; }
        .delete-btn { background: #dc3545; color: white; }

        .add-btn {
            padding: 10px 20px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            margin-bottom: 15px;
            cursor: pointer;
        }

    </style>
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="Images/ecglogo.jpg" class="sidebar-logo">
        <h2>ADMIN</h2>
    </div>

    <ul class="sidebar-menu">
        <li><a href="Admindashboard.php">User Accounts</a></li>
        <li><a href="Logsheets.php">Logsheets</a></li>
        <li><a href="Masterlist.php">Masterlist</a></li>
        <li><a href="#" class="active">Trainers Accounts</a></li>
        <li><a href="TransactionHistory.php">Transaction History</a></li>
    </ul>

    <div class="logout-container">
        <a href="Loginpage.php" class="logout-button">Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <div class="card">
        <h2>Create Trainer Accounts</h2>

        <!-- ADD TRAINER BUTTON -->
        <button class="add-btn" onclick="openAddModal()">Add Trainer Account</button>

        <!-- TRAINER TABLE -->
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

                        <button class="edit-btn"
                            onclick="openEditModal(
                                <?= $trainer['trainer_id'] ?>,
                                '<?= $trainer['name'] ?>',
                                '<?= $trainer['email'] ?>',
                                '<?= $trainer['password'] ?>'
                            )"
                        >Edit</button>

                        <form action="DeleteTrainer.php" method="POST" style="display:inline;">
                            <input type="hidden" name="trainer_id" value="<?= $trainer['trainer_id'] ?>">
                            <button type="submit" class="delete-btn"
                                onclick="return confirm('Delete this trainer?')"
                            >Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<!-- ADD MODAL -->
<div class="modal-overlay" id="addModal">
    <div class="modal-box">
        <h2>Add Trainer</h2>
        <form action="AddTrainer.php" method="POST">
            <input type="text" name="trainer_name" placeholder="Trainer Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button class="modal-btn save-btn" type="submit">Save</button>
            <button class="modal-btn cancel-btn" type="button" onclick="closeAddModal()">Cancel</button>
        </form>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <h2>Edit Trainer</h2>

        <form action="EditTrainer.php" method="POST">
            <input type="hidden" name="id" id="edit_id">

            <input type="text" name="trainer_name" id="edit_name" required>
            <input type="email" name="email" id="edit_email" required>
            <input type="text" name="password" id="edit_password" required>

            <button class="modal-btn save-btn" type="submit">Save</button>
            <button class="modal-btn cancel-btn" type="button" onclick="closeEditModal()">Cancel</button>
        </form>

    </div>
</div>

<script>
function openAddModal() {
    document.getElementById("addModal").style.display = "flex";
}
function closeAddModal() {
    document.getElementById("addModal").style.display = "none";
}

function openEditModal(id, name, email, password) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_name").value = name;
    document.getElementById("edit_email").value = email;
    document.getElementById("edit_password").value = password;
    document.getElementById("editModal").style.display = "flex";
}
function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
}
</script>

</body>
</html>
