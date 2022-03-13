<?php
session_start();
require '../functions.php';

//check whether the user is login or not
if (!isset($_SESSION['admin_login'])) {
  header("Location: admin_login.php");
  exit;
}

$id = $_SESSION['admin_id'];
$admin = query("SELECT * FROM `admin` WHERE admin_id = '$id'")[0];

if (isset($_POST['update'])) {

  if (editAdminProfile($_POST) > 0) {
    echo "<script>
                alert('Akaun anda berjaya dikemaskini');
                document.location.href = 'admin_profile.php?id=$id';
            </script>";
  } else {
    echo "<script>
                alert('Something went wrong. Please try again later.');
                document.location.href = 'admin_profile.php?id=$id';
            </script>";
  }
}


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
      <li class="nav-item active">
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
      <li class="nav-item">
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
                      <a href="#" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-user-edit"></i></a>
                    </div>
                    <div class="image-upload text-center">
                      <div class="container">
                        <img class="img-thumbnail img-profile rounded-circle border border-info" src="../admin/img/<?= $admin['admin_profileImg']; ?>" style="width: 12rem; height: 12rem;" draggable="false"> <br /><br />
                      </div>

                      <b><?= strtoupper($admin['admin_name']); ?></b> <br />
                      <?= $admin['admin_email']; ?> <br />
                      +60 <?= $admin['admin_telNo']; ?>

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
          <input type="hidden" name="admin_id" value="<?= $admin['admin_id']; ?>">
          <div class="modal-body">
            <div class="form-group style">
              <div class="image-upload text-center">
                <div class="container">
                  <label for="file-input">
                    <input type="hidden" name="old_adminprofileImg" value="<?= $admin['admin_profileImg']; ?>">
                    <img class="img-thumbnail img-profile rounded-circle border border-info" src="img/<?= $admin['admin_profileImg']; ?>" style="width: 8rem; height: 8rem;" width=100 id="output" draggable="false">
                  </label>
                  <p>Click Image to change profile picture</p>
                  <input type="file" class="form-control form-control-sm" name="admin_profileImg" id="file-input" onchange="loadFile(event)" style="display: none;">
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Nama Penuh</label>
                <input type="text" class="form-control form-control-sm" name="admin_name" id="admin_name" value="<?= strtoupper($admin['admin_name']); ?>" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label class="form-label">Nama Pengguna (Username)</label>
                <input type="text" class="form-control form-control-sm" name="admin_username" id="admin_username" value="<?= strtoupper($admin['admin_username']); ?>" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-control form-control-sm" name="admin_email" id="admin_email" value="<?= $admin['admin_email']; ?>" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label class="form-label">No Telefon</label>
                <input type="text" class="form-control form-control-sm" name="admin_telNo" id="admin_telNo" value="+60 <?= $admin['admin_telNo']; ?>" autocomplete="off" required>
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

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  <!-- change profile image script -->
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