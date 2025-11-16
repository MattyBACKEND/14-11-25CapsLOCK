<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "ecg_fitness");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all transactions
$sql = "SELECT Time, client_id, Training, Amount, Payment_type FROM payment_transaction ORDER BY Time DESC";
$result = $conn->query($sql);
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
            <li><a href="Admindashboard.php"><i class="bi bi-person-vcard-fill"></i> User accounts</a></li>
            <li><a href="Logsheets.php"><i class="bi bi-person-fill"></i> Logsheets</a></li>
            <li><a href="Masterlist.php"><i class="bi bi-person-vcard-fill"></i> Masterlist</a></li>
            <li><a href="CreateTrainer.php"><i class="bi bi-box-seam-fill"></i> Trainers Account</a></li>
            <li><a href="#" class="active"><i class="bi bi-box-seam-fill"></i> Transaction History</a></li>
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
    <h1 class="content-title">Transaction History</h1>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table id="transactions-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Time</th>
            <th>Client Name</th>
            <th>Training Type</th>
            <th>Amount</th>
            <th>Payment Type</th>
          </tr>
        </thead>
        <tbody>
<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <!-- Display DB Time -->
      <td><?= htmlspecialchars($row['Time']) ?></td>

      <!-- Client fullname -->
      <td>
        <?php
        $stmt = $conn->prepare("SELECT fullname FROM users WHERE id = ?");
        $stmt->bind_param("i", $row['client_id']);
        $stmt->execute();
        $stmt->bind_result($client_name);
        $stmt->fetch();
        $stmt->close();
        echo htmlspecialchars($client_name);
        ?>
      </td>

      <td><?= htmlspecialchars($row['Training']) ?></td>
      <td>₱<?= number_format($row['Amount'], 2) ?></td>
      <td><?= htmlspecialchars($row['Payment_type']) ?></td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="text-center">No transactions found.</td>
    </tr>
<?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
