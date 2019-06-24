<?php

    include("connect.php");
    
    if (isset($_GET["sum"])){
        
        $sum = $_GET["sum"];
        
        $str = "SELECT balance FROM users WHERE id = 2 LIMIT 1";
        $result = $link->query($str) or die(mysqli_error());
        $arr = mysqli_fetch_array($result);
        
        $newBalance = $arr["balance"] - $sum;
        
        $str = "UPDATE users SET balance = $newBalance WHERE id = 2";
        $result = $link->query($str) or die(mysqli_error());

        if ($sum == 500){
            $item = "Фитнесс салат";
        } elseif($sum == 650){
            $item = "Классический салат";
        } elseif ($sum == 800) {
            $item = "Греческий салат";
        } elseif ($sum == 950) {
            $item = "Салат цезарь";
        } elseif ($sum == 1100) {
            $item = "Салат";
        } elseif ($sum == 1250) {
            $item = "Салат Мимоза";
        } else {
            $item = "Товар";
        }

        $str = "SELECT cart FROM users WHERE id = 2 LIMIT 1";
        $result = $link->query($str) or die(mysqli_error());
        $arr = mysqli_fetch_array($result);
        
        if($arr["cart"] == ""){
            $items = array(
                0 => array(
                    "name" => $item,
                    "price" => $sum
                )
            );

            $newArr = serialize($items);


        } else {
            $newArr = unserialize($arr["cart"]);

            $newArr[] = array("name" => $item, "price" => $sum);
            $newArr = serialize($newArr);
        }

        $query = "UPDATE users SET cart = '$newArr' WHERE id = 2";

        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    
    }