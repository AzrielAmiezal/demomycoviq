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
            alert('Deklarasi Kendiri berjaya dikemaskini');
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

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <form method="POST" action="">
          <!-- Begin Page Content -->
          <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <a href="deklarasi_kesihatan_harian.php?id=<?= $_SESSION['login_id']; ?>">Kembali</a>
            </div>

            <!-- Content Row -->

            <div class="row">
              <!-- Deklarasi Info -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">
                    <?php
                    $increaseDay = $_GET["hari"] - 1;

                    $date2 = new DateTime($date['tarikh_mula']);
                    $date2->add(new DateInterval('P' . $_GET["hari"] . 'D'));
                    //echo $date2->format('d-m-Y') . "\n";

                    ?>

                    <h6 class="m-0 font-weight-bold text-dark">DEKLARASI KESIHATAN PADA
                      <?php
                      $date2 = new DateTime($date['tarikh_mula']);
                      $date2->add(new DateInterval('P' . $increaseDay . 'D'));
                      echo strtoupper($date2->format('d F Y'))
                      ?>
                    </h6>

                  </div>
                  <!-- Card Body -->
                  <div class="card-body text-center">
                    <div class=" alert alert-info">
                      <h6 class="card-title"><?= strtoupper($_SESSION['patientName']); ?></h6>
                      <!-- <h6 class="card-title">No. Kad Pengenalan Malaysia</h6>
                      <h6 class="card-title"><b><?= $_SESSION['patient_icNo']; ?></b></h6> -->
                      <h6 class="card-title"><b> SESI <?= $sesi; ?></b> </h6>
                      <h6 class="card-title" style="color: red;">* Required</h6>
                    </div>
                    <input type="hidden" name="tarikh_kemaskini" id="tarikh_kemaskini" value="<?= $date2->format('Y-m-d') ?>">
                    <input type="hidden" name="hari_kemaskini" id="hari_kemaskini" value="<?= $date2->format('D'); ?>">
                    <input type="hidden" name="masa_kemaskini" id="masa_kemaskini" value="<?= date('h:i:s A'); ?>">
                  </div>
                </div>
              </div>
              <!-- end of Deklarasi Info -->

              <!-- q1 -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-dark">
                    <label> 1. Adakah anda mengalami Sakit Tekak? <b style="color: red;">*</b></label>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sakit_tekak" id="sakit_tekak" value='<i class="fas fa-check-circle" style="color: green;"></i>' required>
                      <label class="form-check-label">
                        Ya
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sakit_tekak" id="sakit_tekak" value='<i class="fas fa-times-circle" style="color: red;"></i>'>
                      <label class="form-check-label">
                        Tidak
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of q1 -->

              <!-- q2 -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-dark">
                    <label> 2. Adakah anda mengalami Selesema? <b style="color: red;">*</b></label>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="selesema" id="selesema" value='<i class="fas fa-check-circle" style="color: green;"></i>' required>
                      <label class="form-check-label">
                        Ya
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="selesema" id="selesema" value='<i class="fas fa-times-circle" style="color: red;"></i>'>
                      <label class="form-check-label">
                        Tidak
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of q2 -->

              <!-- q3 -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-dark">
                    <label> 3. Adakah anda mengalami Batuk? <b style="color: red;">*</b></label>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="batuk" id="batuk" value='<i class="fas fa-check-circle" style="color: green;"></i>' required>
                      <label class="form-check-label">
                        Ya
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="batuk" id="batuk" value='<i class="fas fa-times-circle" style="color: red;"></i>'>
                      <label class="form-check-label">
                        Tidak
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of q3 -->


              <!-- q4 -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-dark">
                    <label> 4. Adakah anda mengalami Demam? <b style="color: red;">*</b></label>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="demam" id="demam" value='<i class="fas fa-check-circle" style="color: green;"></i>' required>
                      <label class="form-check-label">
                        Ya
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="demam" id="demam" value='<i class="fas fa-times-circle" style="color: red;"></i>'>
                      <label class="form-check-label">
                        Tidak
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of q4 -->

              <!-- q5 -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-dark">
                    <label> 5. Adakah anda mengalami Loya dan Muntah? <b style="color: red;">*</b></label>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="loya_muntah" id="loya_muntah" value='<i class="fas fa-check-circle" style="color: green;"></i>' required>
                      <label class="form-check-label">
                        Ya
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="loya_muntah" id="loya_muntah" value='<i class="fas fa-times-circle" style="color: red;"></i>'>
                      <label class="form-check-label">
                        Tidak
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of q5 -->

              <!-- q6 -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-dark">
                    <label> 6. Suhu Badan (°C)?</label>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-group">
                      <input class="form-control form-control-sm" type="text" name="temperature_level" id="temperature_level" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of q6 -->

              <!-- q7 -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-dark">
                    <label> 7. SPo2 (%)?</label>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-group">
                      <input class="form-control form-control-sm" type="text" name="spo2_level" id="spo2_level" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of q7 -->

              <!-- q8 -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-dark">
                    <label> 8. Adakah anda mengalami Kesukaran untuk bernafas? <b style="color: red;">*</b></label>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="kesukaran_bernafas" id="kesukaran_bernafas" value='<i class="fas fa-check-circle" style="color: green;"></i>' required>
                      <label class="form-check-label">
                        Ya
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="kesukaran_bernafas" id="kesukaran_bernafas" value='<i class="fas fa-times-circle" style="color: red;"></i>'>
                      <label class="form-check-label">
                        Tidak
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of q8 -->

              <!-- q9 -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-dark">
                    <label> 9. Adakah anda mengalami Hilang deria rasa? <b style="color: red;">*</b></label>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="deria_rasa" id="deria_rasa" value='<i class="fas fa-check-circle" style="color: green;"></i>' required>
                      <label class="form-check-label">
                        Ya
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="deria_rasa" id="deria_rasa" value='<i class="fas fa-times-circle" style="color: red;"></i>'>
                      <label class="form-check-label">
                        Tidak
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of q9 -->


              <!-- q10 -->
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-dark">
                    <label> 10. Adakah anda mengalami Hilang deria bau? <b style="color: red;">*</b></label>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="deria_bau" id="deria_bau" value='<i class="fas fa-check-circle" style="color: green;"></i>' required>
                      <label class="form-check-label">
                        Ya
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="deria_bau" id="deria_bau" value='<i class="fas fa-times-circle" style="color: red;"></i>'>
                      <label class="form-check-label">
                        Tidak
                      </label>
                    </div>
                  </div>
                </div>

              </div>
              <!-- end of q10 -->

              <!-- button -->
              <div class="col-xl-12 col-lg-7">
                <div class="mb-4">
                  <div class="form-check text-center">
                    <button class="btn btn-light" onclick="history.back()">Batal</button>
                    <button type="submit" class="btn btn-light" onclick="return confirm('Adakah anda pasti tentang maklumat yang dimasukkan?')" name="submit">Hantar</button>
                  </div>
                </div>
              </div>
              <!-- end of button -->

            </div>
            <!-- End of content row -->
          </div>
          <!-- /.container-fluid -->
        </form>
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy;2021 - <?= date('Y'); ?>, All right reserved.</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>