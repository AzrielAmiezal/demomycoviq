<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
require '../functions.php';

$conn = connection();
$patient_id = $_GET['patient'];

$patient = query("SELECT * FROM patient WHERE patient_id = '$patient_id' ")[0];

$quarantine = query("SELECT * FROM deklarasi_harian WHERE patient_id = '$patient_id' ");

$patientData = mysqli_query($conn, "SELECT health_status.*, spo2.*, temperature.*,sesi_kemaskini_kesihatan.*,deklarasi_harian.* 
                        FROM health_status 
                          JOIN spo2 
                            ON health_status.spo2_id = spo2.spo2_id 
                            AND health_status.tarikh_kemaskini = spo2.tarikh_kemaskini 
                            AND health_status.masa_kemaskini = spo2.masa_kemaskini
                          JOIN temperature 
                            ON health_status.temperature_id = temperature.temperature_id 
                            AND health_status.tarikh_kemaskini = temperature.tarikh_kemaskini
                            AND health_status.masa_kemaskini = temperature.masa_kemaskini
                          JOIN sesi_kemaskini_kesihatan 
                            ON health_status.sesi_id = sesi_kemaskini_kesihatan.sesi_id
                          JOIN deklarasi_harian
                            ON health_status.patient_id = deklarasi_harian.patient_id
                          WHERE health_status.patient_id = '$patient_id'");
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

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="#">
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
            <h4>Maklumat Pesakit</h4>
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
                  <div class="card-header py-3 text-center">
                    <h6 class="m-0 font-weight-bold text-primary">MAKLUMAT PESAKIT</h6>
                  </div>
                  <div class="card-body">

                    <div class="text-center">
                      <img class="img-thumbnail img-profile rounded-circle border border-dark" src="../img/<?= $patient['patient_profileImg']; ?>" width="25%" style="width: 10rem; height: 10rem;" draggable="false">
                      <br /><br />
                    </div>

                    <div class="table-responsive col-lg-12">
                      <!-- Table Patient Info -->
                      <table class="table">
                        <tr>
                          <td rowspan="4" align="center"></td>
                        </tr>
                        <tr>
                          <th>Nama Pengguna</th>
                          <td><?= $patient['patientName']; ?></td>
                          <th>No Kad Pengenalan / Passport</th>
                          <td><?= $patient['patient_icNo']; ?></td>
                        </tr>
                        <tr>
                          <th>No H/P</th>
                          <td>+60 <?= $patient['patient_telNo']; ?></td>
                          <th>Email</th>
                          <td><?= $patient['patientEmail']; ?></td>
                        </tr>
                        <tr>
                          <th>Alamat</th>
                          <td colspan="4"><?= $patient['patient_address']; ?></td>
                        </tr>
                      </table>
                      <!-- End of table patient info -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Content Row -->
            <div class="row">

              <!-- Content Column -->
              <div class="col mb-2">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3 text-center">
                    <h6 class="m-0 font-weight-bold text-primary">MAKLUMAT KUARANTIN DAN STATUS KESIHATAN</h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive col-lg-12">
                      <!-- Quarantine Information -->
                      <table class="table">
                        <tr align="center">
                          <th>Tahap Jangkitan COVID-19</th>
                          <th>Tempoh Kuarantin</th>
                          <th>Tarikh Mula</th>
                          <th>Tarikh Tamat</th>
                          <th>Status</th>
                        </tr>

                        <?php if (empty($quarantine)) : ?>
                          <tr>
                            <td colspan="5">
                              <p style="color: red; text-align:center;">Tiada Maklumat</p>
                            </td>
                          </tr>
                        <?php endif; ?>

                        <?php

                        foreach ($quarantine as $q) :
                          //Calculate total days between start and end date
                          $diff = strtotime($q['tarikh_tamat']) - strtotime($q['tarikh_mula']);
                        ?>
                          <tr align="center">
                            <td><?= $q['covidStage']; ?></td>
                            <td><?= round($diff / 86400) + 1; ?> Hari</td>
                            <td><?= date('d M Y', strtotime($q['tarikh_mula'])); ?></td>
                            <td><?= date('d M Y', strtotime($q['tarikh_tamat'])); ?></td>
                            <td><?= $q['status_kuarantin']; ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </table>
                      <!-- End of quarantine info table -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
              <!-- Area Chart 1 -->
              <?php
              //echo mysqli_num_rows($health_status);
              foreach ($patientData as $s) {
                if (mysqli_num_rows($patientData) > 0) {
                  $tarikh[] = $s['tarikh_kemaskini'];
                  $spo2[] = $s['spo2_level'];
                } else {
                  $tarikh[] = [["0"]];
                  $spo2[] = [["0"]];
                }
              }
              ?>
              <div class="col-xl-6 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Kadar Oksigen SPO2</h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="chart-area">
                      <?php
                      if (mysqli_num_rows($patientData) < 1) {
                        echo '<p class="d-flex justify-content-center pt-5" style="color: red; text-align:center;">Tiada Maklumat</p>';
                      } else { ?>
                        <canvas id="spo2_chart"></canvas>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of Area Chart -->

              <!-- Area Chart 2 -->
              <?php
              foreach ($patientData as $t) {
                $tarikh2[] = $t['tarikh_kemaskini'];
                $temperature[] = $t['temperature_level'];
              }
              ?>
              <div class="col-xl-6 col-lg-7">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Kadar Suhu Badan °C</h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="chart-area">
                      <?php
                      if (mysqli_num_rows($patientData) < 1) {
                        echo '<p class="d-flex justify-content-center pt-5" style="color: red; text-align:center;">Tiada Maklumat</p>';
                      } else { ?>
                        <canvas id="temperature_chart"></canvas>
                      <?php } ?>

                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- End of charts row -->

            <!-- Content Row -->
            <div class="row">
              <!-- Content Column -->
              <div class="col mb-2">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> Paparan Deklarasi Harian Kendiri</h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive col-lg-12">
                      <table class="table table-striped">
                        <thead class="table-dark" align="center">
                          <tr>
                            <th scope="col">Tarikh/Masa Kemaskini</th>
                            <th scope="col">Sesi Kemaskini</th>
                            <th scope="col">Sakit Tekak</th>
                            <th scope="col">Selesema</th>
                            <th scope="col">Batuk</th>
                            <th scope="col">Demam</th>
                            <th scope="col">Loya / Muntah</th>
                            <th scope="col">Kesukaran Bernafas</th>
                            <th scope="col">Hilang Deria Rasa</th>
                            <th scope="col">Hilang Deria Bau</th>
                          </tr>
                        </thead>
                        <?php if (mysqli_num_rows($patientData) < 1) : ?>
                          <tr>
                            <td colspan="10">
                              <p style="color: red; text-align:center;">Tiada Maklumat</p>
                            </td>
                          </tr>
                        <?php endif; ?>
                        <tbody align="center">
                          <?php $i = 1;
                          foreach ($patientData as $hs) : ?>
                            <tr>
                              <td><?= $hs['hari_kemaskini']; ?> <?= $hs['tarikh_kemaskini']; ?> <?= $hs['masa_kemaskini']; ?></td>
                              <td><?= $hs['sesi_No']; ?></td>
                              <td><?= $hs['sakit_tekak']; ?></td>
                              <td><?= $hs['selesema']; ?></td>
                              <td><?= $hs['batuk']; ?></td>
                              <td><?= $hs['demam']; ?></td>
                              <td><?= $hs['loya_muntah']; ?></td>
                              <td><?= $hs['kesukaran_bernafas']; ?></td>
                              <td><?= $hs['deria_rasa']; ?></td>
                              <td><?= $hs['deria_bau']; ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <!-- End of health info -->
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

  <!-- Page level plugins -->
  <script src="../vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <!-- <script src="../js/demo/chart-area-demo.js"></script>
  <script src="../js/demo/chart-pie-demo.js"></script> -->

  <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
      // *     example: number_format(1234.56, 2, ',', ' ');
      // *     return: '1 234,56'
      number = (number + '').replace(',', '').replace(' ', '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }
    // Area Chart for spo2
    var ctx = document.getElementById("spo2_chart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?= json_encode($tarikh) ?>,
        datasets: [{
          label: "sPo2",
          lineTension: 0.3,
          backgroundColor: "rgba(234, 60, 60, 0.05)",
          borderColor: "rgba(234, 60, 60, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: <?= json_encode($spo2) ?>,
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
            }
          }
        }
      }
    });

    // Area Chart for temperature
    var ctx = document.getElementById("temperature_chart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?= json_encode($tarikh2); ?>,
        datasets: [{
          label: "Suhu Badan",
          lineTension: 0.3,
          backgroundColor: "rgba(60, 143, 234, 0.05)",
          borderColor: "rgba(60, 143, 234, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(234, 60, 60, 1)",
          pointBorderColor: "rgba(234, 60, 60, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(234, 60, 60, 1)",
          pointHoverBorderColor: "rgba(234, 60, 60, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: <?= json_encode($temperature); ?>,
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + '°C';
            }
          }
        }
      }
    });
  </script>

</body>

</html>