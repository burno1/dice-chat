<?php
  session_start();

  if (isset($_SESSION["name"]) && isset($_SESSION["id"])) {
    $login = true;
    $roomName = $_SESSION["name"];
    $roomID = $_SESSION["id"];

  }
  else{
    $login = false;
  }

?>
