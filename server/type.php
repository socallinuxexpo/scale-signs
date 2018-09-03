<?php
  include 'ChromePhp.php';
  include('room_map.php');
  $client = $_SERVER["REMOTE_ADDR"];

  if (in_array($client, array_keys($room_map))) {
      echo $room_map[$client]['type'];
  } else {
      echo "";
  }
?>
