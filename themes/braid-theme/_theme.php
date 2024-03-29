<!DOCTYPE html>
<html lang="en">

<head>
    <title>Braid.pro</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="<?= theme("assets/img/favicon.ico") ?>" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= theme("assets/style.css") ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/6427a64d8f.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navbar -->
    <div class="top-nav w3-top">
        <div class="w3-bar w3-card w3-white w3-left-align w3-large menu-bar">
            <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
            <a href="<?= url("/") ?>" class="w3-bar-item w3-padding-large"><img class="logo-braid" style="width:100px" src="<?= theme("assets/img/logo-rbg.png") ?>" alt="logo"></a>
            <div class="container-home">
                <a href="<?= url("/") ?>" class="w3-hide-small">Home</a>
                <div class="underline-home"></div>
            </div>
            <div class="container-about">
                <a href="#about-us" class="w3-hide-small">Sobre</a>
                <div class="underline-about"></div>
            </div>
            <div class="container-register">
                <a href="<?= url("user/register?userType=generic") ?>" class="w3-hide-small">Cadastre-se</a>
                <div class="underline-register"></div>
            </div>
            <div class="container-login">
                <a href="<?= url("user/login") ?>" class="w3-hide-small">Login</a>
                <div class="underline-login"></div>
            </div>
        </div>

        <!-- Navbar on small screens -->
        <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
            <a href="<?= url("/") ?>" class="w3-bar-item w3-button w3-padding-large">Home</a>
            <a href="#about-us" class="w3-bar-item w3-button w3-padding-large">Sobre</a>
            <a href="<?= url("user/register?userType=generic") ?>" class="w3-bar-item w3-button w3-padding-large">Cadastre-se</a>
            <a href="<?= url("user/login") ?>" class="w3-bar-item w3-button w3-padding-large">Login</a>
        </div>
    </div>

    <?= $v->section("content") ?>

    <!-- Footer -->
    <footer class="w3-container">
        <div class="content-wrap">
            <div class="contact-info">
                <a href="#"><img src="<?= theme("assets/img/logo-2-rbg.png") ?>" alt="logo-footer"></a>
                <span>E-mail: braid@gmail.com</span>
                <span>Telefone: (11) 98032-2264</span>
            </div>
            <div class="important-links">
                <h3>Links importantes</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#about-us">Sobre</a></li>
                    <li><a href="<?= url("user/register?userType=generic") ?>">Cadatre-se</a></li>
                    <li><a href="<?= url("user/login") ?>">Login</a></li>
                </ul>
            </div>
            <div class="call-to-action-footer">
                <p>Você é um freelancer?
                    Nós conectamos milhares de profissionais a empresas todos os dias.</p>
                <a href="<?= url("user/register?userType=generic") ?>" class="w3-button w3-black">Cadastre-se</a>
            </div>
        </div>
        <p class="rights-reserved">Todos os direitos reservados por <a href="#">Braid.pro</a></p>
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
    <?php if (!isset($_COOKIE["privacy-policy"])) : ?>
        <div class="popop-cookies">
            <p>
                <strong>Aviso:</strong>
                Este site utiliza cookies para melhorar a sua experiência de navegação.
                Ao continuar a usar este site, você concorda com o uso de cookies de acordo com nossa Política de Privacidade.
            </p>
            <div class="container-popop-buttons">
                <a href="<?= url("/cookies/privacy-policy") ?>" class="w3-button w3-red w3-medium">Política de privacidade</a>
                <a href="#" data-agree="true" id="skipPopop" class="w3-button w3-green w3-medium">Continuar</a>
            </div>
        </div>
    <?php endif ?>
    <script src="<?= theme("assets/scripts.js") ?>"></script>

</body>

</html>