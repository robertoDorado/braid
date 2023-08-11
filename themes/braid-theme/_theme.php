<!DOCTYPE html>
<html lang="en">

<head>
    <title>Braid.</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="<?= theme("assets/img/favicon.ico") ?>" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= theme("assets/style.css") ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navbar -->
    <div class="top-nav">
        <div class="w3-bar w3-card w3-white w3-left-align w3-large menu-bar">
            <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
            <a href="#" class="w3-bar-item w3-padding-large"><img class="logo-braid" style="width:100px" src="<?= theme("assets/img/logo-rbg.png") ?>" alt="logo"></a>
            <div class="container-home">
                <a href="#" class="w3-hide-small">Home</a>
                <div class="underline-home"></div>
            </div>
            <div class="container-about">
                <a href="#" class="w3-hide-small">Sobre</a>
                <div class="underline-about"></div>
            </div>
            <div class="container-register">
                <a href="#" class="w3-hide-small">Cadastre-se</a>
                <div class="underline-register"></div>
            </div>
            <div class="container-login">
                <a href="#" class="w3-hide-small">Login</a>
                <div class="underline-login"></div>
            </div>
        </div>

        <!-- Navbar on small screens -->
        <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Home</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Sobre</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Cadastre-se</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Login</a>
        </div>
    </div>

    <?= $v->section("content") ?>

    <!-- Footer -->
    <footer class="w3-container w3-padding-64 w3-center w3-opacity">
        <div class="w3-xlarge w3-padding-32">
            <i class="fa fa-facebook-official w3-hover-opacity"></i>
            <i class="fa fa-instagram w3-hover-opacity"></i>
            <i class="fa fa-snapchat w3-hover-opacity"></i>
            <i class="fa fa-pinterest-p w3-hover-opacity"></i>
            <i class="fa fa-twitter w3-hover-opacity"></i>
            <i class="fa fa-linkedin w3-hover-opacity"></i>
        </div>
        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </footer>

    <script>
        // Used to toggle the menu on small screens when clicking on the menu button
        function myFunction() {
            var x = document.getElementById("navDemo");
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
        }
    </script>

</body>

</html>