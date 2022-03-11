<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
require '../functions.php';


//check whether the user is login or not
if (!isset($_SESSION['admin_login'])) {
  header("Location: admin_login.php");
  exit;
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

  <link rel="icon" type="image/x-icon" href="../logo.png">
  <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <!-- CSS Data table -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
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
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <h4>UTAMA</h4>
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
            <!-- Page Heading -->
            <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h4 class="h5 mb-0 text-gray-800">Paparan Deklarasi Kesihatan Harian pada <?= date('d M Y h:i:s A'); ?></h4>
            </div> -->

            <!-- Content Row -->

            <div class="row">

            </div>

            <!-- Content Row -->
            <div class="row">

              <!-- Content Column -->
              <div class="col mb-2">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">SENARAI PESAKIT YANG MENDAFTAR</h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive col-lg-12 pt-1">
                      <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                        <thead class="table-dark" align="center">
                          <tr>
                            <th scope="col">BIL.</th>
                            <th scope="col">NAMA PESAKIT</th>
                            <th scope="col">NO K/P</th>
                            <th scope="col">TELEFON</th>
                            <th scope="col">EMAIL PESAKIT</th>
                            <th scope="col">TINDAKAN</th>
                          </tr>
                        </thead>
                        <?php if (empty($patientList)) : ?>
                          <tr>
                            <td colspan="7">
                              <p style="color: red; font-style:italic; text-align:center;">Tiada Maklumat</p>
                            </td>
                          </tr>
                        <?php endif; ?>
                        <tbody>
                          <?php
                          $i = 1;
                          foreach ($patientList as $p) : ?>

                            <tr>
                              <td><?= $i++; ?></td>
                              <td><?= $p['patientName']; ?></td>
                              <td align="center"><?= $p['patient_icNo']; ?></td>
                              <td align="center">+60<?= $p['patient_telNo']; ?></td>
                              <td><?= $p['patientEmail']; ?></td>
                              <td align="center">
                                <a class="btn btn-primary btn-sm" href="patient_quarantine.php?patient=<?= $p['patient_id']; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Set Status & Tempoh Kuarantin"><i class="fas fa-calendar-plus"></i></a> |
                                <a class="btn btn-warning btn-sm" href="edit_patient_quarantine.php?patient=<?= $p['patient_id']; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kemaskini Tempoh Kuarantin"><i class="fas fa-edit"></i></a> |
                                <a class="btn btn-success btn-sm" href="edit_patient_status.php?patient=<?= $p['patient_id']; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kemaskini Status Kuarantin"><i class="fas fa-house-user"></i></a> |
                                <a class="btn btn-info btn-sm" href="view_patient.php?patient=<?= $p['patient_id']; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Maklumat Pesakit"><i class="fas fa-address-card"></i></a> |
                                <a class="btn btn-secondary btn-sm" href="admin_chat.php?id=<?= $p['patient_id']; ?>&enter=true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chat Pesakit"><i class="fas fa-comment"></i></a>
                              </td>
                            </tr>

                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>

                  </div>
                </div>
              </div>

            </div>

            <!-- Content Row for PIE CHARTS -->
            <div class="row">
              <!-- Pie Chart 1 -->
              <div class="col-xl-6 col-lg-7">
                <!-- <div class="card shadow mb-4"> -->
                <!-- Card Header - Dropdown -->
                <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Jumlah Kes Covid-19 di Malaysia</h6>
                  </div> -->
                <!-- Card Body -->
                <!-- <div class="card-body">

                  </div> -->
                <!-- </div> -->
              </div>

              <!-- Pie Chart 2 -->
              <div class="col-xl-6 col-lg-7">
                <!-- <div class="card shadow mb-4"> -->
                <!-- Card Header - Dropdown -->
                <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Jumlah Vaksinasi Harian di Malaysia</h6>
                  </div> -->
                <!-- Card Body -->
                <!-- <div class="card-body">

                  </div> -->
                <!-- </div> -->
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
  <!-- Data table js -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#myTable').DataTable({
        "ordering": false,
        "info": false,
        search: {
          return: false
        },
        language: {
          searchPlaceholder: "Search patient"
        }
      });
    });
  </script>

</body>

</html>