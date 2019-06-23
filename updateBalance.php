<?php

  session_start(); 

  require_once "connect.php"; 

  header('Content-Type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Origin: *');

  $email = $_SESSION["email"];

  $content = trim(file_get_contents("php://input"));

  $json = json_decode($content);

  $balance = $json -> {"payload"};
  $_SESSION["balance"] = $balance;

  $query = "UPDATE users SET balance = $balance WHERE email='$email'";

  $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
  echo $result;