<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
require '../functions.php';


//check whether the user is login or not
if (!isset($_SESSION['admin_login'])) {
  header("Location: admin_login.php");
  exit;
}

if (isset($_POST['register']) && $_POST['g-recaptcha-response'] != "") {

  $secret = '6Ldl_HYeAAAAAEkq9rscLamRb9aAa-dkURgLnScO';
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);

  if ($responseData->success) {
    if (adminRegister($_POST) > 0) {
      echo "<script>
                alert('Akaun berjaya didaftarkan. Sila Log Masuk');
            </script>";
    } else {
      echo "<script>
                alert('Something went wrong. Please try again later.');
            </script>";
    }
  }
}

$id = $_SESSION['admin_id'];
$patientList = query("SELECT * FROM patient");

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
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />



</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">


    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion toggled" id="accordionSidebar" style="background-color: #FFA500;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_index.php">
        <!-- <div class="sidebar-brand-icon rotate-n-15"> -->
        <!-- <i class="fas fa-laugh-wink"></i> -->
        MYCOVIQ
        <!-- </div> -->
        <div class="sidebar-brand-text mx-3">MYCOVIQ</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="admin_index.php">
          <i class="fas fa-fw fa-home"></i>
          <span>Utama</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Menu
      </div>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="admin_register.php">
          <i class="fas fa-fw fa-user-cog"></i>
          <span>Daftar Admin</span></a>
      </li>



    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <h4>DAFTAR ADMIN</h4>
          </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                // To fetch picture from phpmyadmin
                $conn = connection();
                $admin = mysqli_query($conn, "SELECT * FROM `admin` WHERE admin_id = '$id'");
                $rows = mysqli_fetch_array($admin);

                ?>
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= strtoupper($rows['admin_name']);  ?></span>
                <img class="img-profile rounded-circle" src="../admin/img/<?= $rows['admin_profileImg'] ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="admin_profile.php?id=<?= $_SESSION['admin_id']; ?>">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Akaun Saya
                </a>
                <a class="dropdown-item" href="admin_changePassword.php?id=<?= $_SESSION['admin_id']; ?>">
                  <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                  Tukar kata laluan
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Log Keluar
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <form method="POST" action="">
          <!-- Begin Page Content -->
          <div class="container-fluid">

            <!-- Content Row -->
            <div class="row">

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
                        <form action="" method="POST">
                          <div class="form-group">
                            <input type="text" class="form-control form-control-sm" name="admin_name" id="admin_name" autocomplete="off" placeholder="Nama Penuh" required style="text-transform:uppercase">
                          </div>
                          <div class="form-group">
                            <input type="text" class="form-control form-control-sm" name="admin_username" id="admin_username" autocomplete="off" placeholder="Nama Pengguna" required style="text-transform:uppercase">
                          </div>
                          <div class="form-group">
                            <input type="text" class="form-control form-control-sm" name="admin_telNo" id="admin_telNo" autocomplete="off" placeholder="No Telefon" required style="text-transform:uppercase">
                          </div>
                          <div class="form-group">
                            <input type="text" class="form-control form-control-sm" name="admin_email" id="admin_email" autocomplete="off" placeholder="EMAIL" required>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                              <input type="password" class="form-control form-control-sm" name="admin_password1" id="admin_password1" autocomplete="off" placeholder="KATA LALUAN" required>
                            </div>
                            <div class="col-sm-6">
                              <input type="password" class="form-control form-control-sm" name="admin_password2" id="admin_password2" autocomplete="off" placeholder="SAHKAN KATA LALUAN" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6Ldl_HYeAAAAAEUuybZkVB5pWBO2NURKUJo6fqeN"></div>
                            <span style="color: red;">Sila klik pada captcha.</span>
                          </div>
                          <button type="submit" class="btn btn-warning btn-user btn-block" name="register" onclick="return confirm('Adakah anda pasti tentang maklumat yang dimasukkan?')">Daftar akaun</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- /.container-fluid -->
        </form>
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; MyCOVIQ <?= date('Y'); ?>. All right reserved.</span>
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

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Anda pasti untuk log keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pilih "Logout" jika anda memilih untuk tamatkan sesi.</div>
        <div class="modal-footer">
          <a class="btn btn-danger" href="admin_logout.php?id=<?= $_SESSION['admin_id']; ?>">Log Keluar</a>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <!-- <a class="btn btn-primary" href="login.html">Logout</a> -->
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

</html>