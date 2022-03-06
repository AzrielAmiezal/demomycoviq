<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
require 'functions.php';

//check whether the user is login or not
if (!isset($_SESSION['login'])) {
  header("Location: patient_login.php");
  exit;
}

$conn = connection();

// $declaration = query(
//   "SELECT health_status.*,sesi_kemaskini_kesihatan.* FROM patient,health_status
//    JOIN sesi_kemaskini_kesihatan 
//     ON health_status.sesi_No = sesi_kemaskini_kesihatan.sesi_No
//    WHERE health_status.patient_id = " . $_SESSION['patient_id']
// );

$patient_ID = $_SESSION['patient_id'];

$days = query("SELECT * FROM deklarasi_harian WHERE patient_id = '$patient_ID' ");
// $result1 = mysqli_query($conn, "SELECT * FROM health_status WHERE patient_id = '$patient_ID' AND '$sesi_No' = 1 ");
// $result2 = mysqli_query($conn, "SELECT * FROM health_status WHERE patient_id = '$patient_ID' AND '$sesi_No' = 2 ");
// $result1 = mysqli_query($conn, "SELECT * FROM health_status,sesi_kemaskini_kesihatan WHERE health_status.patient_id = sesi_kemaskini_kesihatan.patient_id AND sesi_No = 1 ");
// $result2 = mysqli_query($conn, "SELECT * FROM health_status,sesi_kemaskini_kesihatan WHERE health_status.patient_id = sesi_kemaskini_kesihatan.patient_id AND sesi_No = 1 ");

// //echo "NumRow:" . mysqli_num_rows($result);
// $row1 = mysqli_fetch_assoc($result1);
// $row2 = mysqli_fetch_assoc($result2);

// if (mysqli_num_rows($result1) < 1) {
//   $submission_status1 = 0;
//   $row1["tarikh_kemaskini"] = '00/00/2022';
// } else {
//   $submission_status1 = $row1['submission_status'];

//   echo "Submission No 1:" . $submission_status1;
// }

// if (mysqli_num_rows($result2) < 1) {
//   $submission_status2 = 0;
//   $row2["tarikh_kemaskini"] = '00/00/2022';
// } else {
//   $submission_status2 = $row2['submission_status'];

//   echo "Submission No 2:" . $submission_status2;
// }
// $patient_ID = $_SESSION['patient_id'];
// $query = sprintf("SELECT patient.*, deklarasi_harian.*, health_status.*, deklarasi_harian.healthStatus_id AS id
// FROM patient 
// JOIN deklarasi_harian
// ON deklarasi_harian.patient_id = '$patient_ID'
// JOIN health_status
// ON health_status.healthStatus_id = deklarasi_harian.healthStatus_id ");
// $result = mysqli_query($conn, $query);

// while ($row = mysqli_fetch_row($result)) {
//   echo "Submission = " . $row['id'];
// }



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
  <a href="index.php?id=<?= $patient_ID; ?>">Kembali ke halaman utama</a>
  <form method="get" action="" align="center">
    <h1>KEMASKINI KESIHATAN HARIAN</h1>
    <table border="1" cellpadding="10" cellspacing="0" align="center">
      <tr>
        <th>Hari</th>
        <th>Tarikh</th>
        <th>Sesi 1</th>
        <th>Sesi 2</th>
      </tr>

      <?php if (empty($days)) : ?>
        <tr>
          <td colspan="4">
            <p style="color: red; text-align:center;">No task available at this moment</p>
          </td>
        </tr>
      <?php endif; ?>

      <?php
      $a = 0;
      foreach ($days as $d) :
        $a = 1;
        $daySesi1 = 1;
        $daySesi2 = 1;
        $startDate = new DateTime($d['tarikh_mula']);
        $endDate = new DateTime($d['tarikh_tamat']);
      ?>
        <?php
        for ($i = $startDate; $i <= $endDate; $i->modify('+1 day')) :
          $date = new DateTime('2022-03-05');
          $time1 = $i->format('Y-m-d');
          $time2 = $date->format('Y-m-d');
          // $hour = date('G');
          // $minute = date('i');
          $hour = 19;
          $minute = 00;
        ?>
          <tr align="center">
            <td><?= $a++; ?></td>
            <td><?= $i->format("D, Y-m-d"); ?></td>
            <td>
              <?php
              //echo $daySesi1; 4/03      28/20
              // $result1 = mysqli_query($conn, "SELECT * FROM health_status WHERE patient_id = '$patient_ID' AND sesi_No = 1 AND tarikh_kemaskini = '$time2'");
              $result1 = mysqli_query($conn, "SELECT * FROM health_status,sesi_kemaskini_kesihatan WHERE health_status.patient_id = sesi_kemaskini_kesihatan.patient_id AND health_status.sesi_id = sesi_kemaskini_kesihatan.sesi_id AND sesi_No = 1 AND tarikh_kemaskini = '$time2'");
              $row1 = mysqli_fetch_assoc($result1);
              //echo "num row: " . mysqli_num_rows($result1);

              if (($time1 == $time2) && ($hour >= 00 && $minute >= 00) && ($hour <= 12 && $minute <= 59)) : ?>
                <?php if (mysqli_num_rows($result1) < 1) { ?>
                  <a href="borang_health_status.php?hari=<?= $daySesi1; ?>&sesi=2">Sesi 1</a>
                <?php
                } else {
                  echo 'Sesi 1';
                } ?>
              <?php else : ?>
                Sesi 1
              <?php endif; ?>
            </td>
            <td>
              <?php
              //echo $daySesi2;
              // $result2 = mysqli_query($conn, "SELECT * FROM health_status WHERE patient_id = '$patient_ID' AND sesi_No = 2 AND tarikh_kemaskini = '$time2'");
              $result2 = mysqli_query($conn, "SELECT * FROM health_status,sesi_kemaskini_kesihatan WHERE health_status.patient_id = sesi_kemaskini_kesihatan.patient_id AND health_status.sesi_id = sesi_kemaskini_kesihatan.sesi_id AND sesi_No = 2 AND tarikh_kemaskini = '$time2'");
              $row2 = mysqli_fetch_assoc($result2);

              if (($time1 == $time2) && ($hour >= 13 && $minute >= 00) && ($hour <= 23 && $minute <= 59)) : ?>
                <?php if (mysqli_num_rows($result2) < 1) { ?>
                  <a href="borang_health_status.php?hari=<?= $daySesi2; ?>&sesi=2">Sesi 2</a>
                <?php
                } else {
                  echo 'Sesi 2';
                } ?>
              <?php else : ?>
                Sesi 2
              <?php endif; ?>

            </td>
          </tr>
        <?php
          $daySesi1 = $daySesi1 + 1;
          //echo "DaySesi1: " . $daySesi1;
          $daySesi2 = $daySesi2 + 1;
        //echo "DaySesi2: " . $daySesi2;
        endfor;
        ?>
      <?php endforeach; ?>

      <!-- ***************ARAHAN************************************ -->
      <?php if ($a > 0) : ?>
        <b>(<?= $a - 1; ?> HARI KUARANTIN)</b>

      <?php endif; ?>
      <h3>Sila pastikan anda menjawab kesemua deklarasi kesihatan kendiri pada hari dan sesi yang ditetapkan.</h3>
      <?php if ($a > 0) : ?>
        <p>Sila kemaskini kesihatan harian anda dua kali sehari, sekali di sebelah pagi dan sekali di sebelah petang, masing-masing sebelum <b>1.00 PM</b> dan <b>12 tengah malam</b> </p>
        <p>Anda akan menjalani tempoh kuarantin selama <b><?= $a - 1; ?> hari</b> bermula pada <b><?= date('d M Y', strtotime($d['tarikh_mula'])); ?></b> dijangka tamat pada <b><?= date('d M Y', strtotime($d['tarikh_tamat'])); ?></b></p>
        <p>Tahap Jangkitan: <?= $d['covidStage']; ?> <br /> Status: <?= $d['status_kuarantin']; ?></p>
      <?php endif; ?>
    </table>
  </form>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
</body>
<br />
<footer align="center">
  <small>&copy; Copyright 2021 - <?= date('Y'); ?>, All right reserved.</small>
</footer>

</html>

<!-- <script type="text/javascript">
  $(function() {
    disableChildButtonByTime(14, 0, "zillow-5");
    disableChildButtonByTime(16, 0, "zillow-4");

    function disableChildButtonByTime(hour, minute, parentId) {
      var date = new Date();
      if (date.getHours() >= hour && date.getMinutes() >= minute) {
        $("#" + parentId).children(".button").addClass("disabled");
      }
    }
  });
</script> -->