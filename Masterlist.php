<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecg_fitness");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch master list entries with client fullname from users table
$rows = $conn->query("
    SELECT m.*, u.fullname AS client_name
    FROM master_list m
    LEFT JOIN users u ON m.user_id = u.id
");
if (!$rows) {
    die("Query Failed: " . $conn->error);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master List Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="MasterlistStyle.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="Images/ecglogo.jpg" alt="Logo" class="sidebar-logo">
            <h2>ADMIN</h2>
        </div>
        <ul class="sidebar-menu">
            <!-- Sidebar links unchanged -->
            <li><a href="Admindashboard.php" id="logins-tab"><i class="bi bi-person-fill"></i> User Accounts</a></li>
            <li><a href="Logsheets.php" id="logsheets-tab"><i class="bi bi-person-lines-fill"></i> Logsheets</a></li>
            <li><a href="#" id="masterlist-tab" class="active"><i class="bi bi-person-vcard-fill"></i> Masterlist</a></li>
            <li><a href="CreateTrainer.php" id="trainer-acc-tab"><i class="bi bi-box-seam-fill"></i> Trainers Account</a></li>
            <li><a href="TransactionHistory.php" id="transac-histo-tab"><i class="bi bi-box-seam-fill"></i> Transaction History</a></li>
        </ul>
        <div class="logout-container">
            <a href="Loginpage.php" class="logout-button"><i class='bx bx-log-out-circle'></i> Logout </a>
        </div>
    </div>
    <!-- SIDEBAR END -->

   <!-- Main Content Area -->
  <div class="main-content">
    <div class="content-header">
      <h1 class="content-title">Master List</h1>
      <button class="add-btn" data-bs-toggle="modal" data-bs-target="#editModal">+ Add Entry</button>
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
            <th>Name</th>
            <th>Notes</th>
            <th>CP No.</th>
            <th>Membership</th>
            <th>Start</th>
            <th>End</th>
            <th>Remaining</th>
            <th>Terms</th>
            <th>Months</th>
            <th>Program</th>
            <th>Monthly Terms</th>
            <th>Start of Term</th>
            <th>End of Term</th>
            <th>Days</th>
            <th>Remaining Days</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
      </thead>
<tbody>
<?php while($r = $rows->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($r['client_name'] ?? $r['Name']) ?></td>
    <?php foreach(['Notes','CP_No','Membership','Start','End','Remaining','Terms','Months','Program','Monthly_Terms','Start_of_Term','End_of_Term','Days','Remaining_Days','Status'] as $c): ?>
        <td><?= htmlspecialchars($r[$c]) ?></td>
    <?php endforeach; ?>
    <td>
        <a href="?edit=<?= $r['NoID'] ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="?delete=<?= $r['NoID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>

    </table>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <form method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?= $edit ? 'Edit Entry' : 'Add Entry' ?></h5>
          <a href="Masterlist.php" class="btn-close"></a>
        </div>
        <div class="modal-body row g-3">
          <input type="hidden" name="noid" value="<?= $edit['NoID'] ?? '' ?>">
          <?php foreach(['Name'=>12,'Notes'=>12,'CP_No'=>6,'Membership'=>6,'Start'=>6,'End'=>6,'Remaining'=>6,'Terms'=>6,'Months'=>6,'Program'=>6,'Monthly_Terms'=>6,'Start_of_Term'=>6,'End_of_Term'=>6,'Days'=>6,'Remaining_Days'=>6,'Status'=>6] as $f=>$wd): ?>
          <div class="col-md-<?= $wd ?>"><label><?= str_replace('_',' ', $f) ?></label>
            <input type="text" name="<?= $f ?>" class="form-control" value="<?= htmlspecialchars($edit[$f] ?? '') ?>">
          </div>
          <?php endforeach; ?>
        </div>
        <div class="modal-footer">
          <button name="save" class="btn btn-success"><?= $edit ? 'Update' : 'Add' ?></button>
        </div>
      </form>
    </div>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded',()=>{
      <?php if($edit):?> new bootstrap.Modal('#editModal').show(); <?php endif;?>
    });
  </script>
</body>
</html>
