<?php

session_start();

if (isset($_GET['logout'])) {

  //Simple exit message
  $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>" . $_SESSION['patientName'] . "</b> has left the chat session.</span><br /></div>";
  file_put_contents("chat/log" . $_GET["id"] . ".html", $logout_message, FILE_APPEND | LOCK_EX);

  header("Location: index.php"); //Redirect the user
}

if (isset($_GET['enter'])) {
  if ($_SESSION['patientName'] != "") {
    $_SESSION['patientName'] = stripslashes(htmlspecialchars($_SESSION['patientName']));
    $login_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>" . $_SESSION['patientName'] . "</b> has joined the chat session.</span><br /></div>";
    file_put_contents("chat/log" . $_GET["id"] . ".html", $login_message, FILE_APPEND | LOCK_EX);
  } else {
    echo '<span class="error">Please type in a name</span>';
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/x-icon" href="logo.png">
  <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>
  <meta name="description" content="Tuts+ Chat Application" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <?php
  if (!isset($_SESSION['patientName'])) {
  } else {
  ?>
    <div id="wrapper">
      <div id="menu">
        <p class="welcome">Welcome, <b><?php echo $_SESSION['patientName']; ?></b></p>
        <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
      </div>

      <div id="chatbox">
        <?php
        if (file_exists("chat/log" . $_GET["id"] . ".html") && filesize("chat/log" . $_GET["id"] . ".html") > 0) {
          $contents = file_get_contents("chat/log" . $_GET["id"] . ".html");
          echo $contents;
        }
        ?>
      </div>

      <form name="message" action="">
        <input name="usermsg" type="text" id="usermsg" />
        <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
      </form>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
      // jQuery Document
      $(document).ready(function() {
        $("#submitmsg").click(function() {
          var clientmsg = $("#usermsg").val();
          $.post("post.php", {
            text: clientmsg,
            id: <?= $_GET["id"] ?>
          });
          $("#usermsg").val("");
          return false;
        });

        function loadLog() {
          var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request

          $.ajax({
            url: "chat/log<?php echo $_GET["id"]; ?>.html",
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

        setInterval(loadLog, 2500);

        $("#exit").click(function() {
          var exit = confirm("Are you sure you want to end the session?");
          if (exit == true) {
            window.location = "patient_chat.php?id=<?= $_GET["id"]; ?>&logout=true";
          }
        });
      });
    </script>
</body>

</html>
<?php
  }
?>