<?php $v->layout("admin/_theme") ?>
<div class="login-box">
  <div class="login-logo">
    <a href="<?= url("/") ?>"><img src="<?= theme("assets/img/logo-2-rbg.png") ?>" alt="logo"></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Faça login na Braid.pro</p>

      <form method="post" id="loginForm">
        <div class="input-field">
          <input type="text" name="email" id="email" data-error="E-mail" class="validate" data-required="true">
          <label for="email">E-mail</label>
        </div>
        <div class="input-field">
          <input type="password" name="password" id="password" data-error="Senha" class="validate" data-required="true">
          <input type="hidden" name="csrfToken" data-error="Token" value="<?= !empty($csrfToken) ? $csrfToken : '' ?>" data-required="true">
          <label for="password">Senha</label>
          <i class="fas fa-eye-slash eye-icon" eye-icon="eyeIconPassword"></i>
        </div>
        <div style="display:none" class="alert alert-danger" id="errorMessage"></div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox-login">
              <input type="checkbox" name="remember" id="remember">
              <label style="padding-left:2rem !important;" for="remember">
                Manter Login
              </label>
            </div>
          </div>
          <!-- /.col -->
          <button type="submit" class="btn btn-block btn-login red">
            <img style="width:20px;display:none;margin:0 auto;" src="<?= theme("assets/img/loading.gif") ?>" alt="loader">
            <span>Login</span>
          </button>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <a href="#" class="btn btn-block red">
          <i class="fab fa-facebook mr-2"></i> Login com Facebook
        </a>
        <a href="#" class="btn btn-block red">
          <i class="fab fa-google-plus mr-2"></i> Login com Google
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">Esqueci a minha senha</a>
      </p>
      <p class="mb-0">
        <a href="<?= url("user/register?userType=generic") ?>" class="text-center">Cadastrar-me</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->