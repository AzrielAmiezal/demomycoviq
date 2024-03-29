<?php
require 'functions.php';
session_start();

//check whether the user is login or not
if (!isset($_SESSION['login'])) {
  header("Location: patient_login.php");
  exit;
}


$conn = connection();
$id = $_SESSION['login_id'];

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
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">


    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion toggled" id="accordionSidebar" style="background-color: #73B00B;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <!-- <div class="sidebar-brand-icon rotate-n-15"> -->
        <!-- <i class="fas fa-laugh-wink"></i> -->
        MYCOVIQ
        <!-- </div> -->
        <div class="sidebar-brand-text mx-3">MYCOVIQ</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-home"></i>
          <span>Utama</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Menu
      </div>

      <!-- Nav Item - Deklarasi Kendiri-->
      <li class="nav-item">
        <a class="nav-link" href="deklarasi_kesihatan_harian.php?id=<?= $_SESSION['patient_id']; ?>">
          <i class="fas fa-fw fa-file-medical"></i>
          <span>Deklarasi Kendiri</span></a>
      </li>

      <!-- Nav Item - Chat-->
      <li class="nav-item">
        <a class="nav-link" href="patient_chat.php?id=<?= $_SESSION['patient_id']; ?>&enter=true">
          <i class="fas fa-fw fa-comments"></i>
          <span>Chat kami</span></a>
      </li>

      <!-- Nav Item - Profile -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="patient_profile.php?id=<?= $_SESSION['patient_id']; ?>">
          <i class="fas fa-fw fa-user"></i>
          <span>Akaun Saya</span></a>
      </li> -->

      <!-- Nav Item - FAQ -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="patient_faq.php">
          <i class="fas fa-fw fa-question-circle"></i>
          <span>FAQ</span></a>
      </li> -->
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
            <h4>FAQ</h4>
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
                $patient = mysqli_query($conn, "SELECT * FROM patient WHERE patient_id = '$id'");
                $rows = mysqli_fetch_array($patient);

                ?>
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= strtoupper($rows['patientName']);  ?></span>
                <img class="img-profile rounded-circle" src="img/<?= $rows['patient_profileImg'] ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="patient_profile.php?id=<?= $_SESSION['patient_id']; ?>">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Akaun Saya
                </a>
                <a class="dropdown-item" href="patient_change_password.php?id=<?= $_SESSION['patient_id']; ?>">
                  <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                  Tukar kata laluan
                </a>
                <a class="dropdown-item" href="">
                  <i class="fas fa-sm fa-fw fa-question-circle mr-2 text-gray-400"></i>
                  FAQ
                </a>
                <a class="dropdown-item" href="about.php">
                  <i class="fas fa-info fa-sm fa-fw mr-2 text-gray-400"></i>
                  About us
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
              <!-- Content Column -->
              <div class="col mb-2">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3 text-center">
                    <h6 class="m-0 font-weight-bold text-primary">FREQUENTLY ASKED QUESTION</h6>
                  </div>
                  <div class="card-body">

                    <div class="accordion" id="accordionExample">
                      <div class="card">
                        <div class="card-header" id="headingOne">
                          <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              <b>1. BILAKAH SAYA BOLEH MENGEMASKINI DEKLARASI HARIAN KENDIRI?</b>
                            </button>
                          </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                          <div class="card-body">
                            Sebaik sahaja anda mendaftar di MYCOVIQ anda akan menerima email dari pihak MYCOVIQ untuk mengemaskini deklarasi harian kendiri dalam masa 24 JAM.
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header" id="headingTwo">
                          <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              <b>2. BAGAIMANA SAYA INGIN MELIHAT PAPARAN KESIHATAN SEPANJANG TEMPOH KUARANTIN?</b>
                            </button>
                          </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                          <div class="card-body">
                            Anda boleh melihat paparan kesihatan kendiri di bahagian utama aplikasi.
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header" id="headingThree">
                          <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                              <b>3. BAGAIMANA SAYA INGIN MENGISI DEKLARASI HARIAN KENDIRI?</b>
                            </button>
                          </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                          <div class="card-body">
                            Anda boleh mengisi deklarasi harian kendiri sebaik sahaja anda menerima email dari pihak MYCOVIQ. Deklarasi Harian Kendiri perlu diisi mengikut hari,tarikh,masa dan sesi yang telah ditetapkan.
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header" id="headingFour">
                          <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                              <b>4. APAKAH WAKTU YANG SESUAI UNTUK SAYA MENGEMASKINI DEKLARASI HARIAN KENDIRI?</b>
                            </button>
                          </h2>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                          <div class="card-body">
                            Deklarasi harian terbahagi kepada dua sesi. Sesi 1 perlu diisi bermula dari 12:00 tengah malam sehingga 1:00 petang (1 jam masa tambahan sehingga pukul 2:00 petang), manakala sesi 2 bermula dari pukul 1:00 petang hingga 12:00 tengah malam.
                          </div>
                        </div>
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
          <a class="btn btn-danger" href="logout.php?id=<?= $_SESSION['patient_id']; ?>">Logout</a>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <!-- <a class="btn btn-primary" href="login.html">Logout</a> -->
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

</body>

</html>