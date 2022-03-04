<?php
//session
session_start();

//import require files
require 'google-api/vendor/autoload.php';
require 'functions.php';

//database connection
$conn = connection();
global $conn;

if (isset($_SESSION['login'])) {

    header("Location: index.php");
    exit;
}

//when usual login button is clicked
if (isset($_POST['login'])) {

    $login = patientLogin($_POST);
}

// ****************************************************************************************** //

// Creating new google client instance
$client = new Google_Client();

// Enter your Client ID
$client->setClientId('592618045940-hs0cv3dje56ucconuakc6lhm7f7vghme.apps.googleusercontent.com');
// Enter your Client Secrect
$client->setClientSecret('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');
// Enter the Redirect URL
$client->setRedirectUri('http://localhost/demomycoviq/patient_login.php');

// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");


if (isset($_GET['code'])) :

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token["error"])) {

        $client->setAccessToken($token['access_token']);

        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        // Storing data into database
        $id = mysqli_real_escape_string($conn, $google_account_info->id);
        $patientName = mysqli_real_escape_string($conn, ucwords(strtolower(trim($google_account_info->name))));
        $patientEmail = mysqli_real_escape_string($conn, $google_account_info->email);
        $patient_profileImg = mysqli_real_escape_string($conn, $google_account_info->picture);

        // checking user already exists or not
        // $get_user = mysqli_query($conn, "SELECT `patientEmail` FROM `patient` WHERE `patientEmail`='$patientEmail'");
        $get_user = mysqli_query($conn, "SELECT * FROM `patient` WHERE `patientEmail`='$patientEmail'");
        if (mysqli_num_rows($get_user) > 0) {
            //Set session
            $row = mysqli_fetch_assoc($get_user);
            $_SESSION['login'] = true;
            $_SESSION['login_id'] = $row['patient_id'];
            $_SESSION['patientName'] = $row['patientName'];
            $_SESSION['patient_icNo'] = $row['patient_icNo'];
            $_SESSION['patient_address'] = $row['patient_address'];
            $_SESSION['patient_telNo'] = $row['patient_telNo'];
            $_SESSION['patientEmail'] = $row['patientEmail'];
            //for graph
            $_SESSION['patient_id'] = $row['patient_id'];
            $_SESSION['google_id'] = $row['google_id'];
            header('Location: index.php?id=' . $_SESSION['login_id']);
            exit;
        } else {

            // if user not exists we will insert the user
            $insert = mysqli_query($conn, "INSERT INTO `patient`(`google_id`,`patientName`,`patient_icNo`,`patient_address`,`patient_telNo`,`patientEmail`,`patientPassword`,`verification_code`,`is_verified`,`patient_profileImg`) VALUES('$id','$patientName','','','0','$patientEmail','',0,1,'$patient_profileImg')");

            if ($insert) {
                $_SESSION['login'] = true;
                $_SESSION['login_id'] = mysqli_insert_id($conn);
                $_SESSION['patientName'] = $patientName;
                //for graph
                $_SESSION['patient_id'] = mysqli_insert_id($conn);
                $_SESSION['google_id'] = $row['google_id'];
                header('Location: patient_details.php?id=' . $_SESSION["login_id"]);
                exit;
            } else {
                echo "Sign up failed!(Something went wrong).";
            }
        }
    } else {
        header('Location: login.php');
        exit;
    }

else :
    // Google Login Url = $client->createAuthUrl();
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
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">

    </head>

    <body>
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4"><b>MYCOVIQ</b></h1>
                                        </div>
                                        <form class="user" action="" method="POST">
                                            <!-- <form class="user"> -->
                                            <?php if (isset($login['error'])) : ?>
                                                <p style="color:red; font-style:italic;"><?= $login['message']; ?></p>
                                            <?php endif; ?>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="patientEmail" id="patientEmail" autocomplete="off" placeholder="Masukkan Emel" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" name="patientPassword" id="myInput" placeholder="Masukkan Kata Laluan">
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck" onclick="myFunction()">
                                                    <label class="custom-control-label" for="customCheck">Show Password</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block" name="login">Login with Password</button>
                                        </form>
                                        <hr>

                                        <button class="btn btn-light btn-outline-dark btn-user btn-block rounded-pill" onclick="window.location.href='<?= $client->createAuthUrl(); ?>'"> <i class="fab fa-fw fa-google"></i> <b>Login with Google</b></button>
                                        <!-- <a href="index.html" class="btn btn-google btn-user btn-block rounded">
                                                <i class="fab fa-google fa-fw"></i> Login with Google
                                            </a> -->

                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="forgot-password.html">Lupa Kata Laluan?</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="patient_register.php">Daftar Akaun!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<?php endif; ?>