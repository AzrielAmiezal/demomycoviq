<?php
session_start();
require 'functions.php';

//check whether the user is login or not
if (!isset($_SESSION['login'])) {
  header("Location: patient_login.php");
  exit;
}

//check whether the submit button is click or not
if (isset($_POST['submit'])) {

  //check whether data has been added or not
  if (editProfileImg($_POST) > 0) {
    echo "<script>
            alert('Profile picture changed!');
            //document.location.href = 'patient_profile.php?id=$_SESSION[patient_id]';
            </script>";
  } else {
    echo "<script>
            alert('Failed to submit! Maybe occur some error');
            document.location.href = 'patient_profile.php?id=$_SESSION[patient_id]';
            </script>";
  }
}

$patient = query("SELECT * FROM patient WHERE patient_id = " . $_SESSION['login_id'])[0];

//echo $_SESSION['patient_icNo'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="logo.png">
  <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <form method="POST" action="" enctype="multipart/form-data">
    <a href="index.php?id=<?= $_SESSION['login_id']; ?>">Kembali ke halaman utama</a>
    <h1>Akaun Pengguna</h1>
    <input type="hidden" name="patient_id" value="<?= $patient['patient_id']; ?>">
    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <th>Gambar Profil</th>
        <td><img src="img/<?= $patient['patient_profileImg']; ?>" width="120" style="display: block;" id="output"></td>
      </tr>
      <tr>
        <th>Nama Pengguna</th>
        <td><?= $patient['patientName']; ?></td>
      </tr>
      <tr>
        <th>No Kad Pengenalan</th>
        <td><?= $patient['patient_icNo']; ?></td>
      </tr>
      <tr>
        <th>No H/P</th>
        <td>+60 <?= $patient['patient_telNo']; ?></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><?= $patient['patientEmail']; ?></td>
      </tr>
    </table>

    <br /> <br />

    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <input type="hidden" name="old_profileImg" value="<?= $patient['patient_profileImg']; ?>">
        <th>Muat Naik Gambar Profil</th>
        <td>
          <input type="file" name="patient_profileImg" id="patient_profileImg" onchange="loadFile(event)">
        </td>
      </tr>
      <tr>
        <th rowspan="2">Tukar kata laluan</th>
        <td>
          <input type="password" name="patientPassword1" autocomplete="off" placeholder="Kata laluan">
        </td>
      </tr>
      <tr>
        <td>
          <input type="password" name="patientPassword2" autocomplete="off" placeholder="Sahkan Kata laluan">
        </td>
      </tr>
    </table>
    <br />
    <button type="submit" name="submit">Simpan</button>
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

</html>