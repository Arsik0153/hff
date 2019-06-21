<?php

  session_start(); 

  require_once "connect.php"; 

  $name = $_POST["name"];
  $tel = $_POST["tel"];
  $email = $_POST["email"];
  $pass = $_POST["pass"];


  $query = "INSERT INTO users (email, pass, name, tel) VALUES ('$email', '$pass', '$name', '$tel')";

  $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

  if($result){
    $_SESSION["email"] = $email;
    $_SESSION["name"] = $name;
    $_SESSION["tel"] = $tel;
    header("Location: cabinet.php");
  } else {
    echo "Произошла ошибка, попробуйте позже";
  }