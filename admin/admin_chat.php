<?php

session_start();

if (isset($_GET['logout'])) {

  //Simple exit message
  $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>(Admin) " . $_SESSION['admin_name'] . "</b> has left the chat session.</span><br /></div>";
  file_put_contents("../chat/log" . $_GET["id"] . ".html", $logout_message, FILE_APPEND | LOCK_EX);

  header("Location: admin_index.php"); //Redirect the user
}

if (isset($_GET['enter'])) {
  if ($_SESSION['admin_name'] != "") {
    $_SESSION['admin_name'] = stripslashes(htmlspecialchars($_SESSION['admin_name']));
    $login_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>(Admin) " . $_SESSION['admin_name'] . "</b> has joined the chat session.</span><br /></div>";
    file_put_contents("../chat/log" . $_GET["id"] . ".html", $login_message, FILE_APPEND | LOCK_EX);
  } else {
    echo '<span class="error">Please type in a name</span>';
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
  <link rel="stylesheet" href="../chat.css" />

</head>

<body id="page-top">
  <?php
  if (!isset($_SESSION['admin_name'])) {
  } else {
  ?>
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

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>


          <!-- Begin Page Content -->
          <div class="container-fluid">

            <div class="row justify-content-center">
              <div class="col-xl-5 col-lg-7 mt-5">
                <h3 class="card-title">CHAT KAMI</h3>
                <div class="card text-dark bg-light shadow mb-4">
                  <!-- Card Body -->
                  <div class="card-body">
                    <div id="menu">
                      <p class="welcome">HI, <b><?php echo strtoupper($_SESSION['admin_name']); ?></b></p>
                      <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
                    </div>

                    <div id="chatbox">
                      <?php
                      if (file_exists("../chat/log" . $_GET["id"] . ".html") && filesize("../chat/log" . $_GET["id"] . ".html") > 0) {
                        $contents = file_get_contents("../chat/log" . $_GET["id"] . ".html");
                        echo $contents;
                      }
                      ?>
                    </div>

                    <form name="message" action="">
                      <input name="usermsg" type="text" id="usermsg" />
                      <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->

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

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <script type="text/javascript">
      // jQuery Document
      $(document).ready(function() {
        $("#submitmsg").click(function() {
          var clientmsg = $("#usermsg").val();
          $.post("admin_post.php", {
            text: clientmsg,
            id: <?= $_GET["id"] ?>
          });
          $("#usermsg").val("");
          return false;
        });

        function loadLog() {
          var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request

          $.ajax({
            url: "../chat/log<?php echo $_GET["id"]; ?>.html",
            cache: false,
            success: function(html) {
              $("#chatbox").html(html); //Insert chat log into the #chatbox div

              //Auto-scroll           
              var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
              if (newscrollHeight > oldscrollHeight) {
                $("#chatbox").animate({
                  scrollTop: newscrollHeight
                }, 'normal'); //Autoscroll to bottom of div
              }
            }
          });
        }

        setInterval(loadLog, 500);

        $("#exit").click(function() {
          var exit = confirm("Are you sure you want to end the session?");
          if (exit == true) {
            window.location = "admin_chat.php?id=<?= $_GET["id"]; ?>&logout=true";
          }
        });
      });
    </script>

</body>

</html>
<?php
  }
?>