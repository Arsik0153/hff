<?php
  include("connect.php");

  header('Content-Type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Origin: *');

  $str = "SELECT cart FROM users WHERE id = 2";
  $result = $link->query($str) or die(mysqli_error());
  $arr = mysqli_fetch_array($result);
  $cart = $arr["cart"];
  $cart = unserialize($cart);

  echo json_encode($cart, JSON_UNESCAPED_UNICODE);