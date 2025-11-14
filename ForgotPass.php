<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="Loginstyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <div class="wrapper">
        <form action="Sendverification.php" method="POST">
            <h1>Forgot Password</h1>

            <div class="input-box">
                <input type="email" name="email" placeholder="Enter your email" required>
                <i class='bx bxs-envelope'></i>
            </div>

            <button type="submit" class="btn">Send Verification Code</button>
            <a href="Loginpage.php" class="back-icon"><i class='bx bx-arrow-back'></i></a>
        </form>
    </div>

</body>
</html>