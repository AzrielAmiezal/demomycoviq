<?php

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

$_SESSION['admin_login'] = false;
header("Location: admin_login.php");
exit();
