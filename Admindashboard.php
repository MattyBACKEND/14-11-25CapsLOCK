<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecg_fitness");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$edit_user = null;
if (isset($_GET['edit'])) {
    $edit_user = $conn->query("SELECT * FROM users WHERE id=" . intval($_GET['edit']))->fetch_assoc();
}

if (isset($_POST['add']) || isset($_POST['update'])) {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = trim($_POST['password']);

    if (isset($_POST['add'])) {
        $pw = password_hash($password, PASSWORD_DEFAULT);
        $conn->query("INSERT INTO users (fullname,email,password) VALUES ('$fullname','$email','$pw')");
    } else {
        $id = intval($_POST['id']);
        $set = "fullname='$fullname', email='$email'";
        if (!empty($password)) {
            $pw = password_hash($password, PASSWORD_DEFAULT);
            $set .= ", password='$pw'";
        }
        $conn->query("UPDATE users SET $set WHERE id=$id");
    }
    header("Location:" . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['delete'])) {
    // Get the user ID to delete
    $userId = intval($_GET['delete']);
    
    // Delete related bookings first
    $conn->query("DELETE FROM bookings WHERE user_id = $userId");

    // Now delete the user
    $conn->query("DELETE FROM users WHERE id = $userId");

    // Redirect to avoid re-submitting the form if the page is refreshed
    header("Location:" . $_SERVER['PHP_SELF']);
    exit;
  
}
$users = $conn->query("SELECT * FROM users");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Admindbstyle.css">
</head>
<body>

<!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="Images/ecglogo.jpg" alt="Logo" class="sidebar-logo">
            <h2>ADMIN</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" class="active" id="logins-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
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

            <li><a href="CreateTrainer.php" id="trainer-acc-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
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
    <!-- SIDEBAR END -->

<div class="main-content">
  <div class="content-header">
    <h1 class="content-title">User Accounts</h1>
    <button class="add-btn" data-bs-toggle="modal" data-bs-target="#userModal"> <i class="fas fa-plus"></i> Add New User</button>
  </div>

  <div class="search-bar">
    <input type="text" id="search-input" placeholder="Search users...">
    <button id="search-btn"><i class="fas fa-search"></i></button>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="users-table">
        <thead>
          <tr>
            <th>ID</th><th>Full Name</th><th>Email</th><th>Password</th><th>Actions</th>
          </tr>
        </thead>
        <tbody id="users-table-body">
         <?php while ($row = $users->fetch_assoc()): ?>
  <tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['fullname'] ?></td>
    <td><?= $row['email'] ?></td>
    <td>********</td>  <!-- Password hidden -->
    <td>
      <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
      <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
         onclick="return confirm('Delete this user?')">Delete</a>
    </td>
  </tr>
<?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="">
      <div class="modal-header">
        <h5 class="modal-title"><?= $edit_user ? 'Edit User' : 'Add New User' ?></h5>
        <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn-close"></a>
      </div>
      <div class="modal-body">
        <?php if ($edit_user): ?>
          <input type="hidden" name="id" value="<?= $edit_user['id'] ?>">
        <?php endif; ?>
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" name="fullname" class="form-control" value="<?= $edit_user['fullname'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?= $edit_user['email'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label"><?= $edit_user ? 'New Password (optional)' : 'Password' ?></label>
          <input type="text" name="password" class="form-control" <?= $edit_user ? '' : 'required' ?>>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="<?= $edit_user ? 'update' : 'add' ?>" class="btn btn-success">
          <?= $edit_user ? 'Update' : 'Add' ?>
        </button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const rows = document.querySelectorAll('#users-table-body tr');
  const searchIn = document.getElementById('search-input');
  const editFlag = <?= $edit_user ? 'true' : 'false' ?>;
  if (editFlag) {
    new bootstrap.Modal(document.getElementById('userModal')).show();
  }

  document.getElementById('search-btn').addEventListener('click', () => {
    const q = searchIn.value.toLowerCase();
    rows.forEach(r => {
      const name = r.children[1].textContent.toLowerCase();
      const email = r.children[2].textContent.toLowerCase();
      r.style.display = (name.includes(q) || email.includes(q)) ? '' : 'none';
    });
  });
});
</script>

</body>
</html>