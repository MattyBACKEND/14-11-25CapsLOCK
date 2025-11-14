<?php
session_start();
// Database connection
$conn = new mysqli("localhost", "root", "", "ecg_fitness");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch user data
$sql = "SELECT Time, client_name, Training, Amount, Payment_type FROM payment_transaction";
$result = $conn->query($sql);

//LOGSHEETS
//if($_SERVER ["REQUEST_METHOD"] == "POST") {

//}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="TransactionHistoryStyle.css">
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<div class="sidebar">
        <div class="sidebar-header">
            <img src="Images/ecglogo.jpg" alt="Logo" class="sidebar-logo">
            <h2>ADMIN</h2>
        </div>
        <ul class="sidebar-menu">
            
            <li><a href="Admindashboard.php" id="masterlist-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
        </svg> <i class="bi bi-person-vcard-fill"></i> User accounts</a></li>

            <li><a href="Logsheets.php"id="logins-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
            </svg> <i class="bi bi-person-fill"></i> Logsheets</a></li>
            
            <li><a href="Masterlist.php" id="masterlist-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
        </svg> <i class="bi bi-person-vcard-fill"></i> Masterlist</a></li>

           <!-- <li><a href="Special_Training.php" id="training-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-standing" viewBox="0 0 16 16">
        <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M6 6.75v8.5a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2.75a.75.75 0 0 0 1.5 0v-2.5a.25.25 0 0 1 .5 0"/>
        </svg> <i class="bi bi-person-standing"></i> Special Training</a></li> -->

            <li><a href="CreateTrainer.php" id="trainer-acc-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
        </svg> <i class="bi bi-box-seam-fill"></i> Trainers Account</a></li>

            <li><a href="#" id="transac-histo-tab" class="active"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
        </svg> <i class="bi bi-box-seam-fill"></i> Transaction History</a></li>
        </ul>

    <div class="logout-container">
    <a href="Loginpage.php" class="logout-button">
        <i class='bx bx-log-out-circle'></i> Logout
    </a>
</div> 
</div>

 <!-- Main Content Area -->
  <div class="main-content">
    <div class="content-header">
      <h1 class="content-title">User Accounts</h1>
      <button class="add-btn" id="add-user-btn">
        <i class="fas fa-plus"></i> Add New User
      </button>
    </div>
    
    <div class="search-bar">
      <input type="text" id="search-input" placeholder="Search users...">
      <button id="search-btn"><i class="fas fa-search"></i></button>
    </div>

    <div class="card">
      <div class="table-responsive">
        <table id="users-table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Time</th>
              <th>Client Name</th>
              <th>Training Type</th>
              <th>Amount</th>
              <th>Payment Type</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="users-table-body">
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['NoID'] ?></td>
      <td><?= $row['Time'] ?></td>
      <td><?= $row['client_name'] ?></td>
      <td><?= $row['Training'] ?></td>
      <td><?= $row['Amount'] ?></td>
      <td><?= $row['Payment_type'] ?></td>
    <td>
    <form method="POST" class="d-inline">
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="noid" value="<?= $row['NoID'] ?>">
      <input type="hidden" name="time" value="<?= $row['Time'] ?>">
      <input type="hidden" name="client_name" value="<?= $row['client_name'] ?>">
      <input type="hidden" name="training" value="<?= $row['Training'] ?>">
      <input type="hidden" name="amount" value="<?= $row['Amount'] ?>">
      <input type="hidden" name="payment_type" value="<?= $row['Payment_type'] ?>">
      <button type="submit" class="btn btn-warning btn-sm">Edit</button>
    </form>
    <a href="?delete=<?= $row['NoID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</a>
  </td>
</tr>
<?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>