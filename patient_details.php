<?php
session_start();
require 'functions.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

//get id from url
$id = $_GET['id'];

//query students based on id
$pt = query("SELECT * FROM patient WHERE patient_id = '$id' ")[0];

if (isset($_POST['register']) && $_POST['g-recaptcha-response'] != "") {

  $secret = '6Ldl_HYeAAAAAEkq9rscLamRb9aAa-dkURgLnScO';
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);

  if ($responseData->success) {
    if (editProfile($_POST) > 0) {
      echo "<script>
                alert('Profile telah dikemaskini');
                document.location.href = 'index.php';
            </script>";
    } else {
      echo "<script>
                alert('Something went wrong. Please try again later.');
                document.location.href = 'patient_login.php';
            </script>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link rel="icon" type="image/x-icon" href="logo.png">
  <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <h3>Profil Pengguna</h3>
  <form action="" method="POST">

    <ul>
      <li>
        <label>
          Nama Pengguna:
          <input type="text" name="patientName" id="patientName" value="<?= $pt['patientName']; ?>" disabled>
        </label>
      </li>
      <li>
        <label>
          No IC / Passport (tanpa "-") :
          <input type="text" name="patient_icNo" id="patient_icNo" value="<?= $pt['patient_icNo']; ?>" autocomplete="off">
        </label>
      </li>
      <li>
        <label>
          Alamat :
          <input type="text" name="patient_address" id="patient_address" value="<?= $pt['patient_address']; ?>" autocomplete="off">
        </label>
      </li>
      <li>
        <label>
          No Tel :
          <input type="text" name="patient_telNo" id="patient_telNo" value="<?= $pt['patient_telNo']; ?>" autocomplete="off">
        </label>
      </li>
      <li>
        <label>
          Emel:
          <input type="text" name="patientEmail" id="patientEmail" value="<?= $pt['patientEmail']; ?>" disabled>
        </label>
      </li>

      <br />

      <div class="form-row">
        <div class="g-recaptcha" data-sitekey="6Ldl_HYeAAAAAEUuybZkVB5pWBO2NURKUJo6fqeN"></div>
      </div>
      <br />
      <button type="submit" name="register">Simpan</button>

    </ul>

  </form>
</body>
<footer align="center">
  <small>&copy; Copyright 2021 - <?= date('Y'); ?>, All right reserved.</small>
</footer>

</html>