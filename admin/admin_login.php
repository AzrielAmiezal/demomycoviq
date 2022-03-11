 <?php
  //session
  session_start();

  require '../functions.php';

  //database connection
  $conn = connection();
  global $conn;

  //when usual login button is clicked
  if (isset($_POST['admin_login'])) {

    $login = adminLogin($_POST);
  }

  ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="theme-color" content="#FFFFFF">
   <link rel="icon" type="image/x-icon" href="../logo.png">
   <link rel="manifest" href="manifest.json">
   <link rel="apple-touch-icon" href="logo192.png">
   <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>

   <!-- Custom fonts for this template-->
   <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

   <!-- Custom styles for this template-->
   <link href="../css/sb-admin-2.min.css" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />

 </head>

 <body>
   <div class="container">
     <!-- Outer Row -->
     <div class="row justify-content-center">

       <!-- <div class="col-xl-10 col-lg-12 col-md-9"> -->
       <div class="col-lg-5 mt-5">

         <div class="card o-hidden border-0 shadow-lg my-5">
           <div class="card-body p-0">
             <!-- Nested Row within Card Body -->
             <div class="row">
               <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
               <!-- <div class="col-lg-6"> -->
               <div class="col-lg">
                 <div class="p-5">
                   <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4"><b>MYCOVIQ (ADMIN)</b></h1>
                   </div>
                   <form class="user" action="" method="POST">
                     <div class="alert alert-warning alert-dismissible fade show" role="alert">
                       Note : First time users are advised to update their temporary password to the password they prefer.
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                     </div>
                     <?php if (isset($login['error'])) : ?>
                       <p class="alert alert-danger" role="alert" style="text-align: center; font-size: small;"><?= $login['message']; ?></p>
                     <?php endif; ?>
                     <div class=" form-group">
                       <input type="text" class="form-control form-control-user" name="admin_username" id="admin_username" autocomplete="off" placeholder="Username" required>
                     </div>
                     <div class="form-group">
                       <input type="password" class="form-control form-control-user" name="admin_password" id="myInput" placeholder="Kata Laluan">
                     </div>
                     <div class="form-group">
                       <div class="custom-control custom-checkbox small">
                         <input type="checkbox" class="custom-control-input" id="customCheck" onclick="myFunction()">
                         <label class="custom-control-label" for="customCheck">Lihat Kata Laluan</label>
                       </div>
                     </div>
                     <button type="submit" class="btn btn-warning btn-user btn-block" name="admin_login">Log Masuk</button>
                   </form>
                 </div>
               </div>
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

   <!-- PWA Service Worker -->
   <script src="../js/pwa/index.js"></script>

   <script>
     function myFunction() {
       var x = document.getElementById("myInput");
       if (x.type === "password") {
         x.type = "text";
       } else {
         x.type = "password";
       }
     }
   </script>

 </body>

 <footer align="center">
   <small>&copy; Copyright 2021 - <?= date('Y'); ?>, All right reserved.</small>
 </footer>

 </html>