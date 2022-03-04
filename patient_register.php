<?php
require 'functions.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

if (isset($_POST['register']) && $_POST['g-recaptcha-response'] != "") {

  $secret = '6Ldl_HYeAAAAAEkq9rscLamRb9aAa-dkURgLnScO';
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);

  if ($responseData->success) {
    if (patientRegister($_POST) > 0) {
      echo "<script>
                alert('A verification link has been sent to your email account. Please click on the link that has just been sent to your email account and continue the registration process.');
                document.location.href = 'patient_login.php';
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
  <h3>Registration Form</h3>
  <form action="" method="POST" enctype="multipart/form-data">

    <ul>
      <li>
        <label>
          Nama Penuh mengikut IC / Passport :
          <input type="text" name="patientName" id="patientName" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          No IC / Passport :
          <input type="text" name="patient_icNo" id="patient_icNo" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          Alamat :
          <input type="text" name="patient_address" id="patient_address" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          No Tel :
          <input type="text" name="patient_telNo" id="patient_telNo" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          Emel:
          <input type="text" name="patientEmail" id="patientEmail" autofocus autocomplete="off" required>
        </label>
      </li>
      <li>
        <label>
          Kata laluan :
          <input type="password" name="patientPassword1" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          Sahkan kata laluan :
          <input type="password" name="patientPassword2" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          Gambar Profile :
          <input type="file" name="patient_profileImg" id="patient_profileImg" onchange="loadFile(event)">
          <br /><br />
          <img src="img/default.jpg" width="120" style="display: block;" id="output">
        </label>
      </li>
      <br />

      <div class="form-row">
        <div class="g-recaptcha" data-sitekey="6Ldl_HYeAAAAAEUuybZkVB5pWBO2NURKUJo6fqeN"></div>
      </div>
      <br />
      <button type="submit" name="register">Register</button>
      <br /> <br />

      <a href="patient_login.php">Login Now</a>

    </ul>

  </form>
  <script>
    var loadFile = function(event) {
      var output = document.getElementById('output');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
      }
    };
  </script>

</body>
<footer align="center">
  <small>&copy; Copyright 2021 - <?= date('Y'); ?>, All right reserved.</small>
</footer>

</html>