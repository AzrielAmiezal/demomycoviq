<?php

// session_start();
// header("Location: login.php");
// exit;


//session_destroy();
// session_start();
// $_SESSION = array();

// if (ini_get("session.use_cookies")) {
//   $params = session_get_cookie_params();
//   setcookie(
//     session_name(),
//     '',
//     time() - 42000,

//     $params['path'],
//     $params['domains'],
//     $params['secure'],
//     $params['httponly']
//   );
// }

// unset($_SESSION['admin']);
//$_SESSION['admin_login'] = false;
// header("Location: login.php");
// exit();

session_start();
session_destroy();
// unset($_SESSION["admin_id"]);
// unset($_SESSION["admin_name"]);

header("Location:login.php");
