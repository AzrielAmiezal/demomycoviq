<?php
session_start();
require 'functions.php';

//check whether the user is login or not
if (!isset($_SESSION['login'])) {
  header("Location: patient_login.php");
  exit;
}

$patient = query("SELECT * FROM patient WHERE patient_id = " . $_SESSION['login_id'])[0];

if (isset($_POST['update'])) {

  if (editProfile($_POST) > 0) {
    echo "<script>
                alert('Akaun anda berjaya dikemaskini');
                document.location.href = 'patient_profile.php';
            </script>";
  } else {
    echo "<script>
                alert('Something went wrong. Please try again later.');
                document.location.href = 'patient_profile.php';
            </script>";
  }
}

//echo $_SESSION['patient_icNo'];

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
        <!-- <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"> -->

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Navbar -->
        <!-- <ul class="navbar-nav">
            <h3>Akaun Saya</h3>

          </ul> -->

        <!-- </nav> -->
        <!-- End of Topbar -->

        <form method="POST" action="">
          <!-- Begin Page Content -->
          <div class="container-fluid">

            <!-- Content Row -->

            <div class="row justify-content-center">
              <div class="col-xl-5 col-lg-7 mt-5">
                <h3 class="card-title">AKAUN SAYA</h3>
                <div class="card border-info shadow mb-4">
                  <!-- Card Body -->
                  <div class="card-body">
                    <div style="text-align: right;">
                      <a href="edit_profile.php?id=<?= $_SESSION['patient_id']; ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-user-edit"></i></a>
                    </div>
                    <div class="image-upload text-center">
                      <div class="container">
                        <img class="img-thumbnail img-profile rounded-circle border border-info" src="img/<?= $patient['patient_profileImg']; ?>" style="width: 12rem; height: 12rem;" draggable="false"> <br /><br />
                      </div>

                      <b><?= strtoupper($patient['patientName']); ?></b> <br />
                      <?= $patient['patient_icNo']; ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Content Row -->
            <div class="row justify-content-center">

              <!-- Content Column -->
              <div class="col-xl-5 col-lg-7">
                <!-- Project Card Example -->
                <div class="card border-info shadow mb-4">
                  <div class="card-body">
                    <div class="table-responsive col-lg-12">
                      <table cellpadding="3" cellspacing="0" width=100%>
                        <tr align="center">
                          <th>No Telefon</th>
                        </tr>
                        <tr align="center">
                          <td>+60 <?= $patient['patient_telNo']; ?></td>
                        </tr>
                        <tr align="center">
                          <th>Email</th>
                        </tr>
                        <tr align="center">
                          <td><?= $patient['patientEmail']; ?></td>
                        </tr>
                        <tr align="center">
                          <th>Alamat</th>
                        </tr>
                        <tr align="center">
                          <td><?= $patient['patient_address']; ?></td>
                        </tr>
                      </table>
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

  <!-- Edit Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Butiran Peribadi</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="patient_id" value="<?= $patient['patient_id']; ?>">
          <div class="modal-body">
            <div class="form-group style">
              <div class="image-upload text-center">
                <div class="container">
                  <label for="file-input">
                    <input type="hidden" name="old_profileImg" value="<?= $patient['patient_profileImg']; ?>">
                    <img class="img-thumbnail img-profile rounded-circle border border-info" src="img/<?= $patient['patient_profileImg']; ?>" style="width: 8rem; height: 8rem;" width=100 id="output" draggable="false">
                  </label>
                  <p>Click Image to change profile picture</p>
                  <input type="file" class="form-control form-control-sm" name="patient_profileImg" id="file-input" onchange="loadFile(event)" style="display: none;">
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Nama Penuh mengikut KP / Passport</label>
                <input type="text" class="form-control form-control-sm" name="patientName" id="patientName" value="<?= strtoupper($patient['patientName']); ?>" autocomplete="off" disabled required>
              </div>
              <div class="form-group">
                <label class="form-label">NO KP / Passport</label>
                <input type="text" class="form-control form-control-sm" name="patient_icNo" id="patient_icNo" value="<?= $patient['patient_icNo']; ?>" autocomplete="off" disabled required>
              </div>
              <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea type="text" class="form-control form-control-sm" name="patient_address" id="patient_address" style="resize: none;" rows="4" required><?= strtoupper($patient['patient_address']); ?></textarea>
              </div>
              <div class="form-group">
                <label class="form-label">No Telefon</label>
                <input type="text" class="form-control form-control-sm" name="patient_telNo" id="patient_telNo" value="+60 <?= $patient['patient_telNo']; ?>" autocomplete="off" disabled required>
              </div>
              <div class="form-group">
                <label class="form-label">Email</label>
                <input type="text" class="form-control form-control-sm" name="patientEmail" id="patientEmail" value="<?= $patient['patientEmail']; ?>" autocomplete="off" disabled required>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Batal</button>
              <button class="btn btn-sm btn-primary" type="submit" name="update">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end of edit modal -->

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script>
    var loadFile = function(event) {
      var output = document.getElementById('output');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
      }
    };
  </script>

</body>

</html>