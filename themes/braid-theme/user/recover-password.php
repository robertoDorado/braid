<?php $v->layout("admin/_theme") ?>
<div class="login-box">
  <div class="login-logo">
    <a href="<?= url("/") ?>"><img src="<?= theme("assets/img/logo-2-rbg.png") ?>" alt="logo"></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Recupere a sua senha</p>

      <form method="post" id="recoverPassword">
        <div class="input-field">
          <input type="text" name="userEmail" id="userEmail" data-error="E-mail" class="validate" data-required="true">
          <label for="userEmail">Digite o seu e-mail</label>
          <input type="hidden" name="csrfToken" data-error="Token" value="<?= !empty($csrfToken) ? $csrfToken : '' ?>" data-required="true">
        </div>
        <div style="display:none" class="alert alert-danger" id="errorMessage"></div>
        <div class="row">
          <!-- /.col -->
          <button type="submit" class="btn btn-block red">
            <img style="width:20px;display:none;margin:0 auto;" src="<?= theme("assets/img/loading.gif") ?>" alt="loader">
            <span>Recuperar senha</span>
          </button>
          <!-- /.col -->
        </div>
      </form>
      <p class="mb-0">
        <a href="<?= url("user/login") ?>" class="text-center">Fazer login</a>
      </p>
    </div>
    <!-- /.recover-card-body -->
  </div>
</div>
<!-- /.recover-box -->