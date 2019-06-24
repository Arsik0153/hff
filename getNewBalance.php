<?php
  include("connect.php");

  header('Content-Type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Origin: *');

  $str = "SELECT balance FROM users WHERE id = 2";
  $result = $link->query($str) or die(mysqli_error());
  $arr = mysqli_fetch_array($result);

  echo json_encode($arr["balance"], JSON_UNESCAPED_UNICODE);