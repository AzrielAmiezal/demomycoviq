<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
if (isset($_SESSION['admin_name'])) {
  $text = $_POST['text'];
  $id = $_POST['id'];

  $text_message = "<div class='msgln'><span class='chat-time'>" . date("g:i A") . "</span> <b class='user-name'>(Admin) " . $_SESSION['admin_name'] . "</b> " . stripslashes(htmlspecialchars($text)) . "<br></div>";
  file_put_contents("../chat/log" . $id . ".html", $text_message, FILE_APPEND | LOCK_EX);
}
