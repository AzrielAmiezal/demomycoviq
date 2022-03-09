<?php

// session_start();
// $_SESSION = [];
// session_unset();
// session_destroy();

// header("Location: patient_login.php");
// exit;


// session_start();
// header("Location: login.php");
// exit;

session_start();
session_destroy();
$_SESSION = array();

if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(
    session_name(),
    '',
    time() - 42000,

    $params['path'],
    $params['domains'],
    $params['secure'],
    $params['httponly']
  );
}

$_SESSION['patient_login'] = false;
header("Location: patient_login.php");
exit();
