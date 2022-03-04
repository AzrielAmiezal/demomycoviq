<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
require '../functions.php';
session_start();

$conn = connection();

//check whether the user is login or not
if (!isset($_SESSION['admin_login'])) {
  header("Location: login.php");
  exit;
}

$patientList = query("SELECT * FROM patient");

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

  <form method="post" action="">
    <h1>MYCOVIQ ADMIN DASHBOARD</h1>
    <h2>Selamat Datang <?= $_SESSION['admin_name']; ?></h2>

    <a href="index.php">Utama</a> | <a href="patient_profile.php">Profil Admin</a> | <a href="">Ruang Chat</a> | <a href="">FAQ</a> | <a href="admin_logout.php">Log Keluar</a>

    <br /><br />

    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <th>NO</th>
        <th>NAMA PENGGUNA</th>
        <th>IC NO</th>
        <th>TELEFON</th>
        <th>EMEL PENGGUNA</th>
        <th>TINDAKAN</th>
      </tr>
      <?php if (empty($patientList)) : ?>
        <tr>
          <td colspan="7">
            <p style="color: red; font-style:italic; text-align:center;">No information displayed</p>
          </td>
        </tr>
      <?php endif; ?>

      <?php
      $i = 1;
      foreach ($patientList as $p) : ?>

        <tr>
          <td><?= $i++; ?></td>
          <td><?= $p['patientName']; ?></td>
          <td><?= $p['patient_icNo']; ?></td>
          <td>+60 <?= $p['patient_telNo']; ?></td>
          <td><?= $p['patientEmail']; ?></td>
          <td>
            <a href="patient_quarantine.php?patient=<?= $p['patient_id']; ?>">Kemaskini Tempoh Kuarantin</a> |
            <a href="patient_view.php?patient=<?= $p['patient_id']; ?>">Maklumat Pesakit</a> |
            <a href="admin_chat.php?id=<?= $p['patient_id']; ?>&enter=true">Ruangan Chat</a>
            <!-- <form method="POST" action="admin_chat.php?id=<?= $p['patient_id']; ?>">
            <input type="button" name="enter" id="enter" value="Ruang Chat" />
          </form> -->
          </td>
        </tr>

      <?php endforeach; ?>




    </table>


  </form>
</body>
<footer align=" center">
  <small>&copy; Copyright 2021 - <?= date('Y'); ?>, All right reserved.</small>
</footer>

</html>