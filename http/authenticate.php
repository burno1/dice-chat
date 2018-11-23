<?php
  session_start();

  if (isset($_SESSION["roomId"]) && isset($_SESSION["roomName"])) {
    $login = true;
    $roomID = $_SESSION["roomId"];
    $roomName = $_SESSION["roomName"];

  }
  else{
    $login = false;
  }

?>
