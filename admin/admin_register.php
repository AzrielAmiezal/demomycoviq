<?php
require '../functions.php';
// require 'PHPMailer/PHPMailer.php';
// require 'PHPMailer/Exception.php';
// require 'PHPMailer/SMTP.php';

if (isset($_POST['register'])) {
  if (adminRegister($_POST) > 0) {
    echo "<script>
                alert('Your admin account succesfully registered. Please log in');
                document.location.href = 'login.php';
            </script>";
  } else {
    echo "<script>
                alert('Something went wrong. Please try again later.');
                document.location.href = 'login.php';
            </script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
  <link rel="icon" type="image/x-icon" href="../logo.png">
  <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <h3>Admin Registration Form</h3>
  <form action="" method="POST">

    <ul>
      <li>
        <label>
          Nama Penuh:
          <input type="text" name="admin_name" id="admin_name" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          Nama pengguna:
          <input type="text" name="admin_username" id="admin_username" autocomplete="off" autofocus required>
        </label>
      </li>

      <li>
        <label>
          No H/P :
          <input type="text" name="admin_telNo" id="admin_telNo" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          Emel:
          <input type="text" name="admin_email" id="admin_email" autofocus autocomplete="off" required>
        </label>
      </li>
      <li>
        <label>
          Kata laluan :
          <input type="password" name="admin_password1" id="admin_password1" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          Sahkan kata laluan :
          <input type="password" name="admin_password2" id="admin_password2" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          Gambar Profil :
          <input type="text" name="admin_profileImg" id="admin_profileImg" autocomplete="off" autofocus required>
        </label>
      </li>
      <br />

      <!-- <div class="form-row">
        <div class="g-recaptcha" data-sitekey="6Ldl_HYeAAAAAEUuybZkVB5pWBO2NURKUJo6fqeN"></div>
      </div> -->
      <br />
      <button type="submit" name="register">Daftar Akaun</button>
      <br /> <br />

      <a href="admin/login.php">Log masuk</a>

    </ul>

  </form>
</body>
<footer align="center">
  <small>&copy; Copyright 2021 - <?= date('Y'); ?>, All right reserved.</small>
</footer>

</html>