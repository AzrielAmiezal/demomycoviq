<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
require '../functions.php';

$id = $_GET['patient'];

// $patient = query("SELECT patient.*,deklarasi_harian.*
//                   FROM patient
//                   INNER JOIN deklarasi_harian
//                   ON patient.patient_id = deklarasi_harian.patient_id
//                   WHERE patient.patient_id = '$id' ");

$patient = query("SELECT * FROM patient WHERE patient_id = '$id' ")[0];

$quarantine = query("SELECT * FROM deklarasi_harian WHERE patient_id = '$id' ");

$health_status = query("SELECT health_status.*, spo2.*, temperature.*,sesi_kemaskini_kesihatan.*,deklarasi_harian.* 
                        FROM health_status 
                          JOIN spo2 
                            ON health_status.spo2_id = spo2.spo2_id 
                            AND health_status.tarikh_kemaskini = spo2.tarikh_kemaskini 
                            AND health_status.masa_kemaskini = spo2.masa_kemaskini
                          JOIN temperature 
                            ON health_status.temperature_id = temperature.temperature_id 
                            AND health_status.tarikh_kemaskini = temperature.tarikh_kemaskini
                            AND health_status.masa_kemaskini = temperature.masa_kemaskini
                          JOIN sesi_kemaskini_kesihatan 
                            ON health_status.sesi_id = sesi_kemaskini_kesihatan.sesi_id
                          JOIN deklarasi_harian
                            ON health_status.patient_id = deklarasi_harian.patient_id
                          WHERE health_status.patient_id = '$id'");


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="icon" type="image/x-icon" href="../logo.png">
  <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <a href="../admin/index.php">Kembali ke halaman utama</a>
  <h2>Paparan Deklarasi Kesihatan Harian pada <?= date('d M Y h:i:s A'); ?></h2>
  <form method="POST" action="">

    <h3 align="center">Maklumat Pesakit</h3>
    <!-- Table Patient Info -->
    <table border="1" cellpadding="10" cellspacing="0" width=90% align="center">
      <tr>
        <td rowspan="4" align="center"><img src="../img/<?= $patient['patient_profileImg']; ?>" width="100" style="display: block;" id="output"></td>
      </tr>
      <tr>
        <th>Nama Pengguna</th>
        <td><?= $patient['patientName']; ?></td>
        <th>No Kad Pengenalan / Passport</th>
        <td><?= $patient['patient_icNo']; ?></td>
      </tr>
      <tr>
        <th>No H/P</th>
        <td>+60 <?= $patient['patient_telNo']; ?></td>
        <th>Email</th>
        <td><?= $patient['patientEmail']; ?></td>
      </tr>
      <tr>
        <th>Alamat</th>
        <td colspan="4"><?= $patient['patient_address']; ?></td>
      </tr>
    </table>
    <!-- End of table patient info -->

    <br /><br />

    <h3 align="center">Maklumat Kuarantin Kendiri dan Status Kesihatan</h3>
    <!-- Quarantine Information -->
    <table border="1" cellpadding="10" cellspacing="0" width=90% align="center">
      <tr>
        <th>Tahap Jangkitan COVID-19</th>
        <th>Tempoh Kuarantin</th>
        <th>Tarikh Mula</th>
        <th>Tarikh Tamat</th>
        <th>Status</th>
      </tr>

      <?php if (empty($quarantine)) : ?>
        <tr>
          <td colspan="5">
            <p style="color: red; text-align:center;">No information displayed</p>
          </td>
        </tr>
      <?php endif; ?>

      <?php

      foreach ($quarantine as $q) :
        //Calculate total days between start and end date
        $diff = strtotime($q['tarikh_tamat']) - strtotime($q['tarikh_mula']);
      ?>
        <tr align="center">
          <td><?= $q['covidStage']; ?></td>
          <td><?= round($diff / 86400) + 1; ?> Hari</td>
          <td><?= date('d M Y', strtotime($q['tarikh_mula'])); ?></td>
          <td><?= date('d M Y', strtotime($q['tarikh_tamat'])); ?></td>
          <td><?= $q['status_kuarantin']; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <!-- End of quarantine info table -->
    <br /><br />

    <!-- Graph/Charts -->

    <div class="row">
      <div class="col">
        <div id="curve_chart1"></div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div id="curve_chart2"></div>
      </div>
    </div>

    <!-- End of Graph Charts -->

    <br /><br />

    <!-- Patient health info -->
    <table border="1" cellpadding="10" cellspacing="0" width=90% align="center">
      <tr>
        <th>Tarikh/Masa Kemaskini</th>
        <th>Sesi</th>
        <th>Sakit Tekak</th>
        <th>Selesema</th>
        <th>Batuk</th>
        <th>Demam</th>
        <th>Loya / Muntah</th>
        <th>Kesukaran Bernafas</th>
        <th>Hilang Deria Rasa</th>
        <th>Hilang Deria Bau</th>
      </tr>

      <?php if (empty($health_status)) : ?>
        <tr>
          <td colspan="10">
            <p style="color: red; text-align:center;">No information displayed</p>
          </td>
        </tr>
      <?php endif; ?>

      <?php $i = 1;

      foreach ($health_status as $hs) : ?>

        <tr align="center">
          <td><?= $hs['hari_kemaskini']; ?> <?= $hs['tarikh_kemaskini']; ?> <?= $hs['masa_kemaskini']; ?></td>
          <td><?= $hs['sesi_No']; ?></td>
          <td><?= $hs['sakit_tekak']; ?></td>
          <td><?= $hs['selesema']; ?></td>
          <td><?= $hs['batuk']; ?></td>
          <td><?= $hs['demam']; ?></td>
          <td><?= $hs['loya_muntah']; ?></td>
          <td><?= $hs['kesukaran_bernafas']; ?></td>
          <td><?= $hs['deria_rasa']; ?></td>
          <td><?= $hs['deria_bau']; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <!-- End of table patient health info -->


  </form>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart1);
    google.charts.setOnLoadCallback(drawChart2);

    function drawChart1() {
      var data = google.visualization.arrayToDataTable([
        ['Tarikh', 'sPo2'],

        //PHP Code 
        <?php
        $conn = connection();
        $query = "SELECT * FROM spo2 WHERE patient_id = " . $_GET['patient'];
        $res = mysqli_query($conn, $query);
        while ($data = mysqli_fetch_array($res)) {
          $tarikh_kemaskini = $data['tarikh_kemaskini'];
          $spo2_level = $data['spo2_level'];
          //$expense = $data['expenses'];
        ?>['<?php echo $tarikh_kemaskini; ?>', <?php echo $spo2_level; ?>],
        <?php
        }

        //if no data show in graph
        if (mysqli_affected_rows($conn) == 0) {
        ?>[0, 0]

        <?php
        }

        ?>

      ]);

      var options = {
        // animationEnabled: true,
        title: 'Kadar Oksigen sPo2 sepanjang kuarantin',
        curveType: 'function',
        legend: {
          position: 'bottom'
        },
      };

      var chart = new google.visualization.LineChart(document.getElementById('curve_chart1'));

      chart.draw(data, options);
    }

    function drawChart2() {
      var data = google.visualization.arrayToDataTable([
        ['Tarikh', '°C'],

        //PHP Code 
        <?php
        $conn = connection();
        $query = "SELECT * FROM temperature WHERE patient_id = " . $_GET['patient'];
        $res = mysqli_query($conn, $query);
        while ($data = mysqli_fetch_array($res)) {
          $tarikh_kemaskini = $data['tarikh_kemaskini'];
          $temperature_level = $data['temperature_level'];
          //$expense = $data['expenses'];
        ?>['<?php echo $tarikh_kemaskini; ?>', <?php echo $temperature_level; ?>],
        <?php
        }

        //if no data show in graph
        if (mysqli_affected_rows($conn) == 0) {
        ?>[0, 0]

        <?php
        }

        ?>

      ]);

      var options = {
        title: 'Suhu Badan °C sepanjang kuarantin',
        curveType: 'function',
        legend: {
          position: 'bottom'
        },
      };

      var chart = new google.visualization.LineChart(document.getElementById('curve_chart2'));

      chart.draw(data, options);
    }
  </script>
</body>

<footer align="center">
  <small>&copy; Copyright 2021 - <?= date('Y'); ?>, All right reserved.</small>
</footer>

</html>