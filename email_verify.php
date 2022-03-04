<?php

require 'functions.php';

$conn = connection();
global $conn;
//echo "starting part";
if (isset($_GET['email']) && isset($_GET['code'])) {
  // echo "first part";
  $query = "SELECT * FROM patient WHERE patientEmail='" . $_GET['email'] . "' AND verification_code = '" . $_GET['code'] . "'";
  // $query = "SELECT * FROM `demo` WHERE `email` = '$_GET[email]' AND `verification_code` = '$_GET[verification_code]'";
  $result = mysqli_query($conn, $query);
  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      //echo "second part";
      $result_fetch = mysqli_fetch_assoc($result);
      if ($result_fetch['is_verified'] == 0) {
        $update = "UPDATE patient SET is_verified = '1' WHERE patientEmail ='" . $_GET['email'] . "'";
        mysqli_query($conn, $update);
        if (mysqli_affected_rows($conn) == 1) {
          echo "<script>
                alert('You have successfully verified account. Please login!');
                document.location.href = 'patient_login.php';
            </script>";
        } else {
          echo "<script>
                alert('Email verification failed');
                document.location.href = 'patient_login.php';
            </script>";
        }
      } else {
        echo "<script>
                alert('Email already registered');
                document.location.href = 'patient_login.php';
            </script>";
      }
    }
  } else {
    echo "<script>
                alert('Something went wrong. Cannot run query');
                document.location.href = 'patient_login.php';
            </script>";
  }
}
