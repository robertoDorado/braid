<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Braid.pro</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= theme("assets/img/favicon.ico") ?>" type="image/x-icon">
  <!-- jQuery -->
  <script src="<?= url("/vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js") ?>"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= url("/vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css") ?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= url("/vendor/almasaeed2010/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css") ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= url("/vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css") ?>">
  <!-- Braid Theme -->
  <link rel="stylesheet" href="<?= theme("assets/style.css") ?>">
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/6427a64d8f.js" crossorigin="anonymous"></script>
  <?php if (empty($menuSelected)) : ?>
    <!-- Compiled Materialize and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
  <?php endif ?>
</head>

<body class="hold-transition register-page">
  <?= $v->section("content") ?>
  
  <!-- Braid js -->
  <script src="<?= theme("assets/scripts.js") ?>"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= url("/vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?= url("/vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js") ?>"></script>
  <?php if (empty($menuSelected)) : ?>
    <!-- Compiled Materialize and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
  <?php endif ?>
</body>

</html>