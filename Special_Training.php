<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "ecg_fitness");
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

$sql = "SELECT NoID, Name, Type_of_Training, Amount, Terms, DownPayment, Daily, No_of_Session, Entry_of_Sessions FROM special_training_sp";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Training Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Admindbstyle.css">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="https://scontent.fmnl4-1.fna.fbcdn.net/v/t39.30808-6/471162732_122180547374100636_2607041914606744030_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeE6D1imUD2siVS-_HczZUm6XyMjWvLJLwBfIyNa8skvAN4rZw09nYlusAp1WnbrvmBNVIlbTg0MKLJMEo2GzUtY&_nc_ohc=asMhda-F_WoQ7kNvwFMoe1R&_nc_oc=Adn5-Wp3paBMpEPhC96hlKdLOch1_4YDZgdtqUWPlu4ev5JVoN6IYF8qsc9FZjDmAbc&_nc_zt=23&_nc_ht=scontent.fmnl4-1.fna&_nc_gid=6z8avOW5v3FQINpTFGc2cw&oh=00_AfOc3G9gDT0k_xw02h0EdyDltuOyGVScayspH1ATlurXcg&oe=685984C4" alt="Logo" class="sidebar-logo">
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

            <li><a href="#" class="active" id="training-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-standing" viewBox="0 0 16 16">
        <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M6 6.75v8.5a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2.75a.75.75 0 0 0 1.5 0v-2.5a.25.25 0 0 1 .5 0"/>
        </svg> <i class="bi bi-person-standing"></i> Special Training</a></li>

            <li><a href="Products.php" id="products-tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
        </svg> <i class="bi bi-box-seam-fill"></i> Products</a></li>
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
      <h1 class="content-title">Special Training</h1>
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
              <th>NoID</th>
              <th>Name</th>
              <th>Type of Training</th>
              <th>Amount</th>
              <th>Terms</th>
              <th>DownPayment</th>
              <th>Daily</th>
              <th>No. of Sessions</th>
              <th>Entry of Sessions</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="users-table-body">
            <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['NoID'] ?></td>
      <td><?= $row['Name'] ?></td>
      <td><?= $row['Type_of_Training'] ?></td>
      <td><?= $row['Amount'] ?></td>
      <td><?= $row['Terms'] ?></td>
      <td><?= $row['DownPayment'] ?></td>
      <td><?= $row['Daily'] ?></td>
      <td><?= $row['No_of_Session'] ?></td>
      <td><?= $row['Entry_of_Sessions'] ?></td>
    <td>
    <form method="POST" class="d-inline">
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="NoID" value="<?= $row['NoID'] ?>">
      <input type="hidden" name="name" value="<?= $row['Name'] ?>">
      <input type="hidden" name="type_of_training" value="<?= $row['Type_of_Training'] ?>">
      <input type="hidden" name="amount" value="<?= $row['Amount'] ?>">
      <input type="hidden" name="terms" value="<?= $row['Terms'] ?>">
      <input type="hidden" name="downPayment" value="<?= $row['DownPayment'] ?>">
      <input type="hidden" name="daily" value="<?= $row['Daily'] ?>">
      <input type="hidden" name="no_of_sessions" value="<?= $row['No_of_Sessions'] ?>">
      <input type="hidden" name="entry_of_Sessions" value="<?= $row['Entry_of_Sessions'] ?>">

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

  <script>
    // You can reuse or simplify your JS here now
    document.addEventListener('DOMContentLoaded', function () {
      const searchInput = document.getElementById('search-input');
      const searchBtn = document.getElementById('search-btn');
      const rows = document.querySelectorAll('#users-table-body tr');

      searchBtn.addEventListener('click', () => {
        const query = searchInput.value.toLowerCase();
        rows.forEach(row => {
          const fullName = row.children[1].textContent.toLowerCase();
          const email = row.children[2].textContent.toLowerCase();
          row.style.display = (fullName.includes(query) || email.includes(query)) ? '' : 'none';
        });
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>