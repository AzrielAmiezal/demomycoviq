<?php
session_start();
require '../functions.php';

//check whether the submit button is click or not
if (isset($_POST['submit'])) {

  //check whether data has been added or not
  if (addIsolation($_POST) > 0) {
    echo "<script>
            alert('Tempoh kuarantin berjaya ditetapkan kepada akaun pengguna');
            document.location.href = 'index.php';
            </script>";
  } else {
    echo "<script>
            alert('Failed to submit! Maybe occur some error');
            document.location.href = 'index.php';
            </script>";
  }
}

//echo $_GET['patient'];

?>

<!DOCTYPE html>
<html>

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
  <form method="POST" action="">

    <label>
      Tahap Jangkitan Pesakit COVID-19 :
      <select name="covidStage" id="covidStage">
        <option value="None">Sila Pilih</option>
        <option value="1 - Tidak menunjukkan sebarang gejala">1 - Tidak menunjukkan sebarang gejala</option>
        <option value="2 - Bergejala ringan, tiada radang paru-paru">2 - Bergejala ringan, tiada radang paru-paru</option>
        <option value="3 - Bergejala, mengalami radang paru-paru">3 - Bergejala, mengalami radang paru-paru</option>
      </select>
    </label>

    <br />

    <label>
      Tarikh Pesakit Mula Kuarantin :
      <input type="date" name="tarikh_mula" id="tarikh_mula">
    </label>

    <br />

    <label>
      Tarikh Jangkaan Tamat Kuarantin :
      <input type="date" name="tarikh_tamat" id="tarikh_tamat">
    </label>

    <br />

    <label>
      Status Kuarantin :
      <select name="status_kuarantin" id="status_kuarantin">
        <option value="None">Sila Pilih</option>
        <option value="Sedang dalam pemantauan">Sedang dalam pemantauan</option>
        <option value="Tamat Kuarantin">Tamat Kuarantin</option>
      </select>
    </label>


    <br /><br />
    <button type="submit" name="submit">Hantar</button>

  </form>
</body>

</html>