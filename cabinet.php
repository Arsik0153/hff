<?php
session_start();
include("connect.php");

$str = "SELECT balance FROM users WHERE email = '". $_SESSION["email"]."'";
$result = $link->query($str) or die(mysqli_error());
$arr = mysqli_fetch_array($result);
$balance = $arr["balance"];
?>

<!DOCTYPE html>
<!--[if lt IE 9 ]><html class="no-js oldie" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>HFF - Корзина</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/vendor.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

    <style type="text/css" media="screen">
        .s-styles { 
            background: white;
            padding-top: 15rem;
            padding-bottom: 12rem;
        }

        .basket-wrap{
          display: flex;
          justify-content: space-around;
          flex-wrap: wrap;
          width: 94%;
          margin: 0 auto;
        }

        .basket-block{
          width: 300px;
          background-color: rgb(245, 245, 245);
          display: flex;
          flex-direction: column;
          align-content: center;
          height: 200px;
          text-align: center;
          margin-top: 25px;
        }

        .balance{
            float: right;
            margin: -20px 30px;
        }
        .pay{
            padding: 0;
            padding: 5px 10px;
            border: 1px solid #39b54a;
            color: #39b54a;
            cursor: pointer;
        }
     </style> 

    <!-- script
    ================================================== -->
    <script src="js/modernizr.js"></script>
    <script src="js/pace.min.js"></script>

    <!-- favicons
    ================================================== -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

</head>

<body id="top">
        

    <!-- header
    ================================================== -->
    <header class="s-header">

        <div class="header-logo">
            <a class="site-logo" href="index.html">
                <img src="images/logo.png" alt="Homepage">
            </a>
        </div>
        <div class="balance">
            <h4>
                Баланс: <span id="balance"><?=$balance?></span> тенге
                <span class="pay">
                    <a href="#ex1" rel="modal:open">+</a>
                </span>
            </h4>
        </div>

    </header> <!-- end s-header -->


    <!-- styles
    ================================================== -->
    <section id="styles" class="s-styles">
        
        <div class="row narrow section-intro add-bottom text-center">

            <div class="col-twelve tab-full">

                <h1 class="display-2">Корзина</h1>

                <p class="lead">Берите любой товар, и они автоматически будут добавлены в корзину</p>

            </div>

        </div>

        <div class="basket-wrap">

            <p style="text-align: center">Загрузка...</p>

        </div> <!-- end basket-wrap -->

        

      </section>



    <!-- footer
    ================================================== -->
    <footer>

                <div class="copyright">
                    <span>© Copyright HFF 2019</span>
                </div>

                <div class="go-top">
                    <a class="smoothscroll" title="Back to Top" href="#top"><i class="icon-arrow-up" aria-hidden="true"></i></a>
                </div>

    </footer> <!-- end footer -->

    <!-- Modal HTML embedded directly into document -->
    <div id="ex1" class="modal">
    <h3>Пополнить баланс</h3>
    <label for="sampleInput">Сумма:</label>
    <input class="full-width" type="email" placeholder="Сумма в тенге" id="newBalance">
    <input id="submitform" class="btn--primary" type="submit" value="Отправить">
    </div>


    <!-- preloader
    ================================================== -->
    <div id="preloader">
        <div id="loader">
            <div class="line-scale-pulse-out">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>


    <!-- Java Script
    ================================================== -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script>

        let form = document.querySelector("#submitform");

        form.addEventListener("click", addBalance);

        function addBalance(e){
            let balance = parseInt(document.querySelector("#balance").innerHTML);
            let newBalance = parseInt(document.querySelector("#newBalance").value);

            e.preventDefault();
            const options = {
                method: 'POST',
                mode: "same-origin",
                credentials: "same-origin",
                headers: {
                "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "payload": balance + newBalance
                })
            };

            fetch('updateBalance.php', options)
                .then((response) => {
                    return response.text();
                })
                .then((res) => {
                    document.querySelector("#balance").innerHTML = balance + newBalance;
                    document.querySelector(".close-modal").click();
                })
                .catch((error) => {
                    console.log(error);
            });

        }

        //Get cart items
        setInterval(function() {
            
            fetch('getNewItems.php')
                .then((response) => {
                    return response.json();
                })
                .then((res) => {

                    let container = document.querySelector(".basket-wrap");

                    container.innerHTML = "";

                    res.forEach(function(data, index) {
                        var newDiv = document.createElement('div');
                        newDiv.className = "basket-block";
                        newDiv.innerHTML = '<h3>' + data.name + '</h3> <p>' + data.price + ' тенге</p>';

                        var child = container.appendChild(newDiv);
                    });
                })
                .catch((error) => {
                    console.log(error);
            });

        }, 2000);

    </script>

</body>

</html>
