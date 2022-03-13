<?php

date_default_timezone_set('Asia/Kuala_Lumpur');
require 'functions.php';
session_start();

$email = $_GET['email'];

//check whether the submit button is click or not
if (isset($_POST['submit'])) {

  //check whether data has been added or not
  if (updateForgotPassword($_POST) > 0) {
    echo "<script>
            alert('Kata Laluan Berjaya Ditukar');
            document.location.href = 'patient_login.php';
            </script>";
  } else {
    echo "<script>
            alert('Failed to submit! Maybe occur some error');
            document.location.href = 'patient_login.php';
            </script>";
  }
}

$patient = query("SELECT * FROM patient WHERE patientEmail = '$email'")[0];

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="theme-color" content="#FFFFFF">
  <link rel="icon" type="image/x-icon" href="logo.png">
  <link rel="manifest" href="manifest.json">
  <link rel="apple-touch-icon" href="logo192.png">
  <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />

</head>

<body>
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <!-- <div class="col-xl-10 col-lg-12 col-md-9"> -->
      <div class="col-lg-5 pt-5">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
              <!-- <div class="col-lg-6"> -->
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><b>MYCOVIQ</b></h1>
                  </div>
                  <form class="user" action="" method="POST">
                    <input type="hidden" name="patientEmail" id="patientEmail" value="<?= $patient['patientEmail']; ?>">
                    <!-- <form class="user"> -->
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="patientPassword1" autocomplete="off" placeholder="Kata laluan baru" id="myInput" required>

                    </div>
                    <div class="form-group">

                      <input type="password" class="form-control form-control-user" name="patientPassword2" autocomplete="off" placeholder="Sahkan kata laluan baru" required>

                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck" onclick="myFunction()">
                        <label class="custom-control-label" for="customCheck">Lihat Kata Laluan</label>
                      </div>
                    </div>
                    <!-- <button type="submit" class="btn btn-primary btn-user btn-block" name="submit">Hantar</button> -->
                    <button class="btn btn-primary btn-user btn-block" type="submit" name="submit" onclick="return confirm('Adakah anda pasti tentang maklumat yang dimasukkan?')">Simpan</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- PWA Service Worker -->
  <script src="js/pwa/index.js"></script>
  <!-- Show password -->
  <script>
    function myFunction() {
      var x = document.getElementById("myInput");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>

</body>

<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; MyCOVIQ <?= date('Y'); ?>. All right reserved.</span>
    </div>
  </div>
</footer>

</html>