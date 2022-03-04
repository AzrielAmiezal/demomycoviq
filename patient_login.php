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
$client->setRedirectUri('http://localhost/testmycoviq/patient_login.php');

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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
  </head>

  <body>
    <h3>MYCOVIQ LOGIN</h3>
    <?php if (isset($login['error'])) : ?>
      <p style="color:red; font-style:italic;"><?= $login['message']; ?></p>
    <?php endif; ?>
    <form action="" method="POST">
      <ul>
        <li>
          <label>
            Email/IC No:
            <input type="text" name="patientEmail" id="patientEmail" autocomplete="off" required>
          </label>
        </li>
        <li>
          <label>
            Password:
            <input type="password" name="patientPassword" id="myInput" required>
          </label>
        </li>
        <br />
        <input type="checkbox" onclick="myFunction()">Show Password
        <br /><br />
        <button type="submit" name="login">Log in with Password</button>

      </ul>

    </form>
    <!-- Google login button -->
    <ul>
      <button onclick="window.location.href='<?= $client->createAuthUrl(); ?>'">Log in with Google</button>
      <!-- <button> <a class="button" href="" style="text-decoration: none; color: black;">Log in with Google</a></button> -->

      <br /><br />
      <!-- Register button -->
      <button><a href="patient_register.php" style="text-decoration: none; color: black;">Create account</a></button>
    </ul>

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