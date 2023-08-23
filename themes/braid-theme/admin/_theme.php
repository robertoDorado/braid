<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Braid.pro</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= theme("assets/img/favicon.ico") ?>" type="image/x-icon">
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
  <script src="https://kit.fontawesome.com/6427a64d8f.js" crossorigin="anonymous"></script>
</head>
<body class="hold-transition register-page">
  <?= $v->section('content') ?>
<script src="<?= theme("assets/scripts.js") ?>"></script>
<!-- jQuery -->
<script src="<?= url("/vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js") ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= url("/vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
<!-- AdminLTE App -->
<script src="<?= url("/vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js") ?>"></script>
</body>
</html>