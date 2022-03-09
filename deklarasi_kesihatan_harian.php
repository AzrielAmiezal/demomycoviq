<?php

date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
require 'functions.php';

//check whether the user is login or not
if (!isset($_SESSION['login'])) {
  header("Location: patient_login.php");
  exit;
}

$patient_ID = $_SESSION['patient_id'];

$days = query("SELECT * FROM deklarasi_harian WHERE patient_id = '$patient_ID' ");


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


    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion toggled" id="accordionSidebar" style="background-color: #73B00B;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div> -->
        MYCOVIQ
        <div class="sidebar-brand-text mx-3">MYCOVIQ</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
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
      <li class="nav-item active">
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
            <h4>DEKLARASI KENDIRI</h4>
          </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Alerts -->
            <!-- <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i> -->
            <!-- Counter - Alerts -->
            <!-- <span class="badge badge-danger badge-counter">3+</span> -->
            <!-- </a> -->
            <!-- Dropdown - Alerts -->
            <!-- <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
              <h6 class="dropdown-header">
                Alerts Center
              </h6>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                  <div class="icon-circle bg-primary">
                    <i class="fas fa-file-alt text-white"></i>
                  </div>
                </div>
                <div>
                  <div class="small text-gray-500">December 12, 2019</div>
                  <span class="font-weight-bold">A new monthly report is ready to download!</span>
                </div>
              </a>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                  <div class="icon-circle bg-success">
                    <i class="fas fa-donate text-white"></i>
                  </div>
                </div>
                <div>
                  <div class="small text-gray-500">December 7, 2019</div>
                  $290.29 has been deposited into your account!
                </div>
              </a>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                  <div class="icon-circle bg-warning">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                  </div>
                </div>
                <div>
                  <div class="small text-gray-500">December 2, 2019</div>
                  Spending Alert: We've noticed unusually high spending for your account.
                </div>
              </a>
              <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
            </li> -->

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                // To fetch picture from phpmyadmin
                $conn = connection();
                $id = $_SESSION['patient_id'];
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
                <a class="dropdown-item" href="changePassword.php?id=<?= $_SESSION['patient_id']; ?>">
                  <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                  Tukar kata laluan
                </a>
                <a class="dropdown-item" href="">
                  <i class="fas fa-sm fa-fw fa-question-circle mr-2 text-gray-400"></i>
                  FAQ
                </a>
                <a class="dropdown-item" href="">
                  <i class="fas fa-info fa-sm fa-fw mr-2 text-gray-400"></i>
                  Privacy Policy
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
            <!-- Page Heading -->
            <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h4 class="h3 mb-0 text-gray-800">Paparan Deklarasi Kesihatan Harian pada <?= date('d M Y h:i:s A'); ?></h4>
            </div> -->

            <!-- Content Row -->

            <div class="row">
              <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">
                    <h6 class="m-0 font-weight-bold text-primary">KEMASKINI KESIHATAN HARIAN</h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="table-responsive col-lg-12">
                      <table class="table table-striped">
                        <thead class="table-dark" align="center">
                          <tr>
                            <th>Bil. Hari</th>
                            <th>Hari/Tarikh</th>
                            <th>Sesi 1</th>
                            <th>Sesi 2</th>
                          </tr>
                        </thead>
                        <?php if (empty($days)) : ?>
                          <tr>
                            <td colspan="4">
                              <p style="color: red; text-align:center;">Tiada Maklumat</p>
                            </td>
                          </tr>
                        <?php endif; ?>
                        <tbody align="center">
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
                              $date = new DateTime();
                              $time1 = $i->format('Y-m-d');
                              $time2 = $date->format('Y-m-d');
                              $hour = date('G');
                              $minute = date('i');
                              // $hour = 10;
                              // $minute = 00;
                            ?>
                              <tr>
                                <td><?= $a++; ?></td>
                                <td><?= $i->format("D, d/m/Y"); ?></td>
                                <td>
                                  <?php
                                  //echo $daySesi1; 4/03      28/20
                                  // $result1 = mysqli_query($conn, "SELECT * FROM health_status WHERE patient_id = '$patient_ID' AND sesi_No = 1 AND tarikh_kemaskini = '$time2'");
                                  $result1 = mysqli_query($conn, "SELECT * FROM health_status,sesi_kemaskini_kesihatan WHERE health_status.patient_id = sesi_kemaskini_kesihatan.patient_id AND health_status.sesi_id = sesi_kemaskini_kesihatan.sesi_id AND sesi_No = 1 AND tarikh_kemaskini = '$time1'");
                                  $row1 = mysqli_fetch_assoc($result1);
                                  //echo "num row: " . mysqli_num_rows($result1);

                                  if (($time1 == $time2) && ($hour >= 00 && $minute >= 00) && ($hour <= 12 && $minute <= 59)) {
                                    if (mysqli_num_rows($result1) < 1) {

                                      echo '<a href="borang_health_status.php?hari=' . $daySesi1 . '&sesi=1"><i class="fas fa-pen-square"></i></a>';
                                      //echo 'Sesi 2';
                                    } else {
                                      echo '<i class="fas fa-check-circle" style="color:green;"></i>';
                                    }
                                  } else if (($time1 != $time2) && ($hour >= 00 && $minute >= 00) && ($hour <= 12 && $minute <= 59)) {
                                    if (mysqli_num_rows($result1) < 1 && ($time2 > $time1)) {
                                      echo '<i class="fas fa-times-circle" style="color:red;"></i>';
                                      //echo 'Sesi 2';
                                    } else {
                                      if (mysqli_num_rows($result1) < 1) {
                                        echo '<i class="fas fa-times-circle" style="color:orange;"></i>';
                                      } else {
                                        echo '<i class="fas fa-check-circle" style="color:green;"></i>';
                                      }
                                    }
                                  }

                                  if (($time1 == $time2) && ($hour >= 13 && $minute >= 00) && ($hour <= 23 && $minute <= 59)) {
                                    if (mysqli_num_rows($result1) < 1) {
                                      echo '<i class="fas fa-times-circle" style="color:red;"></i>';
                                    } else {
                                      echo '<i class="fas fa-check-circle" style="color:green;"></i>';
                                    }
                                  } else if (($time1 != $time2) && ($hour >= 13 && $minute >= 00) && ($hour <= 23 && $minute <= 59)) {
                                    if (mysqli_num_rows($result1) < 1 && ($time2 > $time1)) {
                                      echo '<i class="fas fa-times-circle" style="color:red;"></i>';
                                      //echo 'Sesi 2';
                                    } else {
                                      if (mysqli_num_rows($result1) < 1) {
                                        echo '<i class="fas fa-times-circle" style="color:orange;"></i>';
                                      } else {
                                        echo '<i class="fas fa-check-circle" style="color:green;"></i>';
                                      }
                                    }
                                  }

                                  ?>
                                </td>
                                <td>
                                  <?php
                                  //echo $daySesi2;
                                  // $result2 = mysqli_query($conn, "SELECT * FROM health_status WHERE patient_id = '$patient_ID' AND sesi_No = 2 AND tarikh_kemaskini = '$time2'");
                                  $result2 = mysqli_query($conn, "SELECT * FROM health_status,sesi_kemaskini_kesihatan WHERE health_status.patient_id = sesi_kemaskini_kesihatan.patient_id AND health_status.sesi_id = sesi_kemaskini_kesihatan.sesi_id AND sesi_No = 2 AND tarikh_kemaskini = '$time1'");
                                  $row2 = mysqli_fetch_assoc($result2);

                                  if (($time1 == $time2) && ($hour >= 00 && $minute >= 00) && ($hour <= 12 && $minute <= 59)) {
                                    if (mysqli_num_rows($result2) < 1) {
                                      echo '<i class="fas fa-times-circle" style="color:orange;"></i>';
                                    } else {
                                      echo '<i class="fas fa-check-circle" style="color:green;"></i>';
                                    }
                                  } else if (($time1 != $time2) && ($hour >= 00 && $minute >= 00) && ($hour <= 12 && $minute <= 59)) {
                                    if (mysqli_num_rows($result2) < 1 && ($time2 > $time1)) {
                                      echo '<i class="fas fa-times-circle" style="color:red;"></i>';
                                      //echo 'Sesi 2';
                                    } else {
                                      if (mysqli_num_rows($result2) < 1) {
                                        echo '<i class="fas fa-times-circle" style="color:orange;"></i>';
                                      } else {
                                        echo '<i class="fas fa-check-circle" style="color:green;"></i>';
                                      }
                                    }
                                  }

                                  if (($time1 == $time2) && ($hour >= 13 && $minute >= 00) && ($hour <= 23 && $minute <= 59)) {
                                    if (mysqli_num_rows($result2) < 1) {
                                      echo '<a href="borang_health_status.php?hari=' . $daySesi2 . '&sesi=2"><i class="fas fa-pen-square"></i></a>';
                                      //echo 'Sesi 2';
                                    } else {
                                      echo '<i class="fas fa-check-circle" style="color:green;"></i>';
                                    }
                                  } else if (($time1 != $time2) && ($hour >= 13 && $minute >= 00) && ($hour <= 23 && $minute <= 59)) {
                                    if (mysqli_num_rows($result2) < 1 && ($time2 > $time1)) {
                                      echo '<i class="fas fa-times-circle" style="color:red;"></i>';
                                      //echo 'Sesi 2';
                                    } else {
                                      if (mysqli_num_rows($result2) < 1) {
                                        echo '<i class="fas fa-times-circle" style="color:orange;"></i>';
                                      } else {
                                        echo '<i class="fas fa-check-circle" style="color:green;"></i>';
                                      }
                                    }
                                  }
                                  ?>
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
                        </tbody>
                        <!-- ***************ARAHAN************************************ -->
                        <h5 style="text-align: center;"><b>Sila pastikan anda menjawab kesemua deklarasi kesihatan kendiri pada hari dan sesi yang ditetapkan.</b></h5>

                        <?php if ($a > 0) : ?>
                          <div class="alert alert-warning" style="text-align: center;">
                            <p style="color: red;">Sila kemaskini kesihatan harian anda dua kali sehari, sekali di sebelah pagi dan sekali di sebelah petang, masing-masing sebelum <b>1.00 PM</b> dan <b>12 tengah malam</b> </p>
                            <p style="color: red;">Anda akan menjalani tempoh kuarantin selama <b><?= $a - 1; ?> hari</b> bermula pada <b><?= date('d M Y', strtotime($d['tarikh_mula'])); ?></b> dijangka tamat pada <b><?= date('d M Y', strtotime($d['tarikh_tamat'])); ?></b></p>
                            <p style="color: red;">Tahap Jangkitan: <?= $d['covidStage']; ?> <br /> Status: <?= $d['status_kuarantin']; ?></p>
                            <p><i class="fas fa-pen-square" style="color:blue;"></i> : Pautan Dibuka | <i class="fas fa-times-circle" style="color:red;"></i> : Tidak dikemaskini | <i class="fas fa-times-circle" style="color:orange;"></i> : Pautan belum dibuka | <i class="fas fa-check-circle" style="color:green;"></i> : Berjaya dikemaskini</p>
                          </div>
                        <?php endif; ?>

                      </table>

                      <?php
                      if ($a > 0) {
                        if ($time2 > $d['tarikh_tamat'] && $d['status_kuarantin'] == 'Tamat Kuarantin') {

                          echo '<button>Print PDF</button>';
                        }
                      }
                      ?>
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