<?php
require '../functions.php';

if (isset($_POST['register']) && $_POST['g-recaptcha-response'] != "") {

  $secret = '6Ldl_HYeAAAAAEkq9rscLamRb9aAa-dkURgLnScO';
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);

  if ($responseData->success) {
    if (adminRegister($_POST) > 0) {
      echo "<script>
                alert('Akaun anda berjaya didaftarkan. Sila Log Masuk');
                document.location.href = 'admin_login.php';
            </script>";
    } else {
      echo "<script>
                alert('Something went wrong. Please try again later.');
                document.location.href = 'admin_login.php';
            </script>";
    }
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
  <meta name="author" content="">

  <link rel="icon" type="image/x-icon" href="logo.png">
  <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block"></div> -->
          <div class="col-lg">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4"><b>Daftar Akaun (Admin)</b></h1>
              </div>
              <form class="user" action="" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" name="admin_name" id="admin_name" autocomplete="off" placeholder="Nama Penuh" required style="text-transform:uppercase">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" name="admin_username" id="admin_username" autocomplete="off" placeholder="Nama Pengguna" required style="text-transform:uppercase">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" name="admin_telNo" id="admin_telNo" autocomplete="off" placeholder="No Telefon" required style="text-transform:uppercase">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" name="admin_email" id="admin_email" autocomplete="off" placeholder="EMAIL" required>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" name="admin_password1" id="admin_password1" autocomplete="off" placeholder="KATA LALUAN" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" name="admin_password2" id="admin_password2" autocomplete="off" placeholder="SAHKAN KATA LALUAN" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="g-recaptcha" data-sitekey="6Ldl_HYeAAAAAEUuybZkVB5pWBO2NURKUJo6fqeN"></div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block" name="register">Daftar akaun</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Google Captcha API -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>

<footer align="center">
  <small>&copy; Copyright 2021 - <?= date('Y'); ?>, All right reserved.</small>
</footer>

</html>