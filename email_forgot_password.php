<?php
require 'functions.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';



if (isset($_POST['submit'])) {

  $conn = connection();
  $patient = mysqli_query($conn, "SELECT * FROM patient WHERE patientEmail ='" . $_POST['patientEmail'] . "'");
  if (mysqli_num_rows($patient) > 0) {
    if (forgotPassword($_POST) > 0) {
      echo "<script>
                alert('Link kata laluan telah dihantar ke email anda. Sila semak email dan klik pada link untuk menukar kata laluan baru.');
                document.location.href = 'patient_login.php';
            </script>";
    } else {
      echo "<script>
                alert('Something went wrong. Please try again later.');
                document.location.href = 'patient_login.php';
            </script>";
    }
  } else {
    // echo "<script>
    //             alert('Email tidak berdaftar. Sila Cuba lagi!');
    //             document.location.href = 'email_forgot_password.php';
    //         </script>";

    $error = true;
    $message = 'Email tidak wujud!';
  }
}



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
                    <?php if (isset($error)) : ?>
                      <p class="alert alert-danger" role="alert" style="text-align: center; font-size: small;"><?= $message; ?></p>
                    <?php endif; ?>
                    <!-- <form class="user"> -->
                    <div class=" form-group">
                      <input type="email" class="form-control form-control-user" name="patientEmail" id="patientEmail" autocomplete="off" placeholder="Sila masukkan email anda" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                                                                          echo htmlentities($_POST['patientEmail']);
                                                                                                                                                                                        } ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block" name="submit">Hantar</button>
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

</body>

<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; MyCOVIQ <?= date('Y'); ?>. All right reserved.</span>
    </div>
  </div>
</footer>

</html>