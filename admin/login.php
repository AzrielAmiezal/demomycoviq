<?php
//session
session_start();

require '../functions.php';

//database connection
$conn = connection();
global $conn;

//when usual login button is clicked
if (isset($_POST['admin_login'])) {

  $login = adminLogin($_POST);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../logo.png">
  <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <h3>ADMIN LOGIN</h3>
  <?php if (isset($login['error'])) : ?>
    <p style="color:red; font-style:italic;"><?= $login['message']; ?></p>
  <?php endif; ?>
  <form action="" method="POST">
    <b>Note : First time users are advised to update their temporary password to the password they prefer.</b>
    <ul>
      <li>
        <label>
          Nama Pengguna:
          <input type="text" name="admin_username" id="admin_username" autocomplete="off" required>
        </label>
      </li>
      <li>
        <label>
          Password:
          <input type="password" name="admin_password" id="admin_password" required>
        </label>
      </li>
      <br />

      <button type="submit" name="admin_login">Log Masuk</button>

    </ul>

  </form>
</body>
<footer align="center">
  <small>&copy; Copyright 2021 - <?= date('Y'); ?>, All right reserved.</small>
</footer>

</html>