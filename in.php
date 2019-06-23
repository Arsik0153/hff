<?php

  session_start(); 

  require_once "connect.php"; 
  
  $email = $_POST["email"];
  $pass = $_POST["pass"];


  $query = "SELECT * FROM users WHERE email = '$email' AND pass = '$pass' order by id limit 1;";
  $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
  $rows = mysqli_num_rows($result);
  if($rows > 0){
    while($row = $result->fetch_assoc()) {
      $_SESSION["name"] = $row["name"];
      $_SESSION["email"] = $row["email"];
      $_SESSION["tel"] = $row["tel"];
      $_SESSION["balance"] = $row["balance"];
      header("Location: cabinet.php");
    }
  }else {
      header("Location: in.html");
  }