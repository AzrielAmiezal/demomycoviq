<?php
session_start();
require '../functions.php';
// require '../PHPMailer/PHPMailer.php';
// require '../PHPMailer/Exception.php';
// require '../PHPMailer/SMTP.php';


$id = $_GET['patient'];

//check whether the submit button is click or not
if (isset($_POST['submit'])) {

  //check whether data has been added or not
  if (editIsolation($_POST) > 0) {
    echo "<script>
            alert('Maklumat berjaya dikemaskini. Email notifikasi telah dihantar kepada pesakit');
            document.location.href = 'view_patient.php?patient=$id';
          </script>";
  } else {
    echo "<script>
            alert('Failed to submit! Maybe occur some error');
              document.location.href = 'view_patient.php?patient=" . $id .
      "</script>";
  }
}

$conn = connection();

$patient = query("SELECT patient.*,deklarasi_harian.* FROM patient
                                JOIN deklarasi_harian
                                ON deklarasi_harian.patient_id = patient.patient_id
                                WHERE patient.patient_id = '$id'")[0];
//$rows = mysqli_fetch_assoc($result);

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
            <h4>Kemaskini Tetapan Kuarantin</h4>
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
                $id = $_SESSION['admin_id'];
                $admin = mysqli_query($conn, "SELECT * FROM `admin` WHERE admin_id = '$id'");
                $rows = mysqli_fetch_array($admin);

                ?>
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= strtoupper($rows['admin_name']);  ?></span>
                <img class="img-profile rounded-circle" src="../img/<?= $rows['admin_profileImg'] ?>">
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

            <!-- Content Row -->
            <div class="row">
              <!-- Content Column -->
              <div class="col mb-2">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">TETAPAN STATUS DAN TARIKH KUARANTIN</h6>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <form method="POST" action="">
                        <input type="hidden" name="patient_id" id="patient_id" value="<?= $patient['patient_id']; ?>">
                        <!-- For email -->
                        <input type="hidden" name="patientName" id="patientName" value="<?= $patient['patientName']; ?>">
                        <input type="hidden" name="patient_icNo" id="patient_icNo" value="<?= $patient['patient_icNo']; ?>">
                        <input type="hidden" name="patientEmail" id="patientEmail" value="<?= $patient['patientEmail']; ?>">
                        <div class="table-responsive">
                          <table class="table">
                            <tr>
                              <th scope="col">NAMA PESAKIT</th>
                              <td><?= $patient['patientName']; ?></td>
                            </tr>
                            <tr>
                              <th scope="col">NO K/P</th>
                              <td><?= $patient['patient_icNo']; ?></td>
                            </tr>
                            <tr>
                              <th scope="col">TAHAP JANGKITAN COVID-19</th>
                              <td>
                                <select class="custom-select custom-select-sm" name="covidStage" id="covidStage" required>
                                  <option value="">Sila Pilih</option>
                                  <option value="1 - Tidak menunjukkan sebarang gejala" <?php if ($patient['covidStage'] == '1 - Tidak menunjukkan sebarang gejala') {
                                                                                          echo 'selected';
                                                                                        } ?>>1 - Tidak menunjukkan sebarang gejala</option>
                                  <option value="2 - Bergejala ringan, tiada radang paru-paru" <?php if ($patient['covidStage'] == '2 - Bergejala ringan, tiada radang paru-paru') {
                                                                                                  echo 'selected';
                                                                                                } ?>>2 - Bergejala ringan, tiada radang paru-paru</option>
                                  <!-- <option value="3 - Bergejala, mengalami radang paru-paru">3 - Bergejala, mengalami radang paru-paru</option> -->
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <th scope="col">TARIKH PESAKIT MULA KUARANTIN</th>
                              <td>
                                <input class="form-control form-control-sm" type="date" name="tarikh_mula" id="tarikh_mula" value="<?= $patient['tarikh_mula']; ?>" required>
                              </td>
                            </tr>
                            <tr>
                              <th scope="col">TARIKH PESAKIT TAMAT KUARANTIN</th>
                              <td>
                                <input class="form-control form-control-sm" type="date" name="tarikh_tamat" id="tarikh_tamat" value="<?= $patient['tarikh_tamat']; ?>" required>
                              </td>
                            </tr>
                            <tr>
                              <th scope="col">STATUS</th>
                              <td>
                                <select class="custom-select custom-select-sm" name="status_kuarantin" id="status_kuarantin" required>
                                  <option value="">Sila Pilih</option>
                                  <option value="Sedang dalam pemantauan" <?php if ($patient['status_kuarantin'] == 'Sedang dalam pemantauan') {
                                                                            echo 'selected';
                                                                          } ?>>Sedang dalam pemantauan</option>
                                  <option value="Tamat Kuarantin" <?php if ($patient['status_kuarantin'] == 'Tamat Kuarantin') {
                                                                    echo 'selected';
                                                                  } ?>>Tamat Kuarantin</option>
                                </select>
                              </td>
                            </tr>
                          </table>
                          <div class="text-center">
                            <button class="btn btn-light" type="submit" name="submit" onclick="return confirm('Adakah anda pasti tentang maklumat yang dimasukkan?')"><b>Simpan</b></button>
                          </div>
                        </div>
                      </form>
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

</body>

</html>