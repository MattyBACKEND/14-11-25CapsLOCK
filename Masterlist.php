<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecg_fitness");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// For Add & Update
$edit = null;
if (isset($_GET['edit'])) {
  $edit = $conn->query("SELECT * FROM master_list WHERE NoID = ".intval($_GET['edit']))->fetch_assoc();
}
if (isset($_POST['save'])) {
  $fields = ['Name','Notes','CP_No','Membership','Start','End','Remaining','Terms','Months','Program','Monthly_Terms','Start_of_Term','End_of_Term','Days','Remaining_Days','Status','NoID'];
  $vals = [];
  foreach ($fields as $f) $vals[$f] = $conn->real_escape_string($_POST[$f]);
  if ($_POST['id']) {
    $sets = [];
    foreach ($fields as $f) $sets[] = "$f='{$vals[$f]}'";
    $conn->query("UPDATE master_list SET ".implode(",", $sets)." WHERE NoID=".intval($_POST['id']));
  } else {
    $conn->query("INSERT INTO master_list (".implode(",",$fields).") VALUES ('".implode("','",$vals)."')");
  }
  header('Location: Masterlist.php');
  exit;
}

// Delete Record
if (isset($_GET['delete'])) {
  $deleteId = intval($_GET['delete']);
  $deleteQuery = "DELETE FROM master_list WHERE NoID = $deleteId";

  if ($conn->query($deleteQuery)) {
    // Redirect after successful delete
    header('Location: Masterlist.php');
    exit;
  } else {
    // Show error if delete fails
    echo "Error deleting record: " . $conn->error;
  }
}

$rows = $conn->query("SELECT * FROM master_list");
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
            <li><a href="Admindashboard.php" id="logins-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
            </svg> <i class="bi bi-person-fill"></i> User Accounts</a></li>

            <li><a href="Logsheets.php" id="logsheets-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/>
        </svg> <i class="bi bi-person-lines-fill"></i> Logsheets</a></li>

            <li><a href="#" id="masterlist-tab" class="active" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
        </svg> <i class="bi bi-person-vcard-fill"></i> Masterlist</a></li>

            <li><a href="CreateTrainer.php" id="trainer-acc-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
        </svg> <i class="bi bi-box-seam-fill"></i> Trainers Account</a></li>

            <li><a href="TransactionHistory.php" id="transac-histo-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
        </svg> <i class="bi bi-box-seam-fill"></i> Transaction History</a></li>
        </ul>

      <div class="logout-container">
          <a href="Loginpage.php" class="logout-button">
            <i class='bx bx-log-out-circle'></i> Logout </a>
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
      <thead><tr>
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
        <?php while($r=$rows->fetch_assoc()): ?>
        <tr>
          <?php foreach(['Name',
                        'Notes',
                        'CP_No',
                        'Membership',
                        'Start',
                        'End',
                        'Remaining',
                        'Terms',
                        'Months',
                        'Program',
                        'Monthly_Terms',
                        'Start_of_Term',
                        'End_of_Term',
                        'Days',
                        'Remaining_Days',
                        'Status'] AS $c): ?>
          <td><?= htmlspecialchars($r[$c]) ?></td>
          <?php endforeach; ?>
          <td>
            <a href="?edit=<?= $r['NoID'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="?delete=<?= $r['NoID'] ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('Delete?')">Delete</a>
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
            <input type="text" name="<?= $f ?>" class="form-control"
               value="<?= htmlspecialchars($edit[$f] ?? '') ?>">
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