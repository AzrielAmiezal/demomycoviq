<?php

session_start();

date_default_timezone_set('Asia/Kuala_Lumpur');

//check whether the user is login or not
if (!isset($_SESSION['login'])) {
  header("Location: patient_login.php");
  exit;
}

require 'functions.php';

$sesi = $_GET['sesi'];
$hari = $_GET['hari'];

//check whether the submit button is click or not
if (isset($_POST['submit'])) {

  //check whether data has been added or not
  if (addHealthStatusReport($_POST) > 0) {
    echo "<script>
            alert('Health status has been submit');
            document.location.href = 'deklarasi_kesihatan_harian.php?id=$_SESSION[patient_id]';
            </script>";
  } else {
    echo "<script>
            alert('Failed to submit! Maybe occur some error');
            document.location.href = 'deklarasi_kesihatan_harian.php?id=$_SESSION[patient_id]';
            </script>";
  }
}

$id = $_SESSION['login_id'];
$date = query("SELECT * FROM deklarasi_harian WHERE patient_id = '$id'")[0];


//echo $date['tarikh_mula'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="icon" type="image/x-icon" href="logo.png">
  <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>

  <form method="post" action="">
    <a href="deklarasi_kesihatan_harian.php?id=<?= $_SESSION['login_id']; ?>">Kembali</a>

    <?php
    $increaseDay = $_GET["hari"] - 1;

    $date2 = new DateTime($date['tarikh_mula']);
    $date2->add(new DateInterval('P' . $_GET["hari"] . 'D'));
    //echo $date2->format('d-m-Y') . "\n";

    ?>
    <!-- <h2>DEKLARASI KESIHATAN PADA <?= strtoupper(date('d F Y', strtotime($date['tarikh_mula']))); ?></h2> -->
    <h2>DEKLARASI KESIHATAN PADA <?php $date2 = new DateTime($date['tarikh_mula']);
                                  $date2->add(new DateInterval('P' . $increaseDay . 'D'));
                                  echo strtoupper($date2->format('d F Y'))  ?></h2>


    <h2>SESI <?= $sesi; ?> </h2>
    <h4><?= strtoupper($_SESSION['patientName']); ?></h4>
    <h4>NO KAD PENGENALAN MALAYSIA</h4>
    <h4><?= $_SESSION['patient_icNo']; ?></h4>

    SILA TANDA JIKA TERDAPAT SIMPTOM BERIKUT <br /> <br />
    <input type="hidden" name="tarikh_kemaskini" id="tarikh_kemaskini" value="<?= $date2->format('Y-m-d') ?>">
    <input type="hidden" name="hari_kemaskini" id="hari_kemaskini" value="<?= $date2->format('D'); ?>">
    <input type="hidden" name="masa_kemaskini" id="masa_kemaskini" value="<?= date('h:i:s A'); ?>">
    <label>
      1. Sakit Tekak?<br />
      <input type="radio" name="sakit_tekak" value='<i class="fas fa-check-circle" style="color: green;"></i>'>Ada <br />
      <input type="radio" name="sakit_tekak" value='<i class="fas fa-times-circle" style="color: red;"></i>'>Tiada
    </label>

    <br /> <br />

    <label>
      2. Selesema?<br />
      <input type="radio" name="selesema" value='<i class="fas fa-check-circle" style="color: green;"></i>'>Ada <br />
      <input type="radio" name="selesema" value='<i class="fas fa-times-circle" style="color: red;"></i>'>Tiada
    </label>

    <br /> <br />

    <label>
      3. Batuk?<br />
      <input type="radio" name="batuk" value='<i class="fas fa-check-circle" style="color: green;"></i>'>Ada <br />
      <input type="radio" name="batuk" value='<i class="fas fa-times-circle" style="color: red;"></i>'>Tiada
    </label>

    <br /> <br />

    <label>
      4. Demam?<br />
      <input type="radio" name="demam" value='<i class="fas fa-check-circle" style="color: green;"></i>'>Ada <br />
      <input type="radio" name="demam" value='<i class="fas fa-times-circle" style="color: red;"></i>'>Tiada
    </label>

    <br /> <br />

    <label>
      5. Loya dan Muntah?<br />
      <input type="radio" name="loya_muntah" value='<i class="fas fa-check-circle" style="color: green;"></i>'>Ada <br />
      <input type="radio" name="loya_muntah" value='<i class="fas fa-times-circle" style="color: red;"></i>'>Tiada
    </label>

    <br /> <br />

    <label>
      6. Suhu Badan (°C)?<br />
      <input type="text" name="temperature_level" autocomplete="off"> <br />
    </label>

    <br />

    <label>
      7. SPo2 (%)?<br />
      <input type="text" name="spo2_level" autocomplete="off"> <br />
    </label>

    <br />

    <label>
      8. Kesukaran bernafas?<br />
      <input type="radio" name="kesukaran_bernafas" value='<i class="fas fa-check-circle" style="color: green;"></i>'>Ada <br />
      <input type="radio" name="kesukaran_bernafas" value='<i class="fas fa-times-circle" style="color: red;"></i>'>Tiada
    </label>

    <br /> <br />

    <label>
      9. Hilang Deria Rasa?<br />
      <input type="radio" name="deria_rasa" value='<i class="fas fa-check-circle" style="color: green;"></i>'>Ada <br />
      <input type="radio" name="deria_rasa" value='<i class="fas fa-times-circle" style="color: red;"></i>'>Tiada
    </label>

    <br /> <br />

    <label>
      10. Hilang Deria Bau?<br />
      <input type="radio" name="deria_bau" value='<i class="fas fa-check-circle" style="color: green;"></i>'>Ada <br />
      <input type="radio" name="deria_bau" value='<i class="fas fa-times-circle" style="color: red;"></i>'>Tiada
    </label>

    <br /> <br />


    <button type="submit" name="submit">Hantar</button>

  </form>

</body>
<footer align="center">
  <small>&copy; Copyright 2021 - <?= date('Y'); ?>, All right reserved.</small>
</footer>

</html>