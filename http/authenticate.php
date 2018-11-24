<?php
  session_start();

  if (isset($_SESSION["name"])) {
    $login = true;
    $roomName = $_SESSION["name"];
  }
  else{
    $login = false;
  }

?>
