<?php $v->layout("admin/_theme") ?>
<div class="login-box">
  <div class="login-logo">
    <a href="<?= url("/") ?>"><img src="<?= theme("assets/img/logo-2-rbg.png") ?>" alt="logo"></a>
  </div>
  <!-- /.recover-password-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Redefinição de senha para o usuário: <?= $nickName ?> na Braid.pro</p>

      <form method="post" id="formRecoverPassword">
        <div class="input-field">
          <input type="password" name="password" id="passwordData" data-error="Senha" class="validate" data-required="true">
          <label for="password">Nova senha</label>
          <i class="fas fa-eye-slash eye-icon" eye-icon="eyeIconPassword"></i>
        </div>
        <div class="input-field">
          <input type="password" name="confirmPassword" id="confirmPassword" data-error="Confirme a Senha" class="validate" data-required="true">
          <input type="hidden" name="csrfToken" data-error="Token" value="<?= !empty($csrfToken) ? $csrfToken : '' ?>" data-required="true">
          <input type="hidden" name="nickName" data-error="Nome de usuário" value="<?= $nickName ?>" data-required="true">
          <input type="hidden" name="userEmail" data-error="E-mail" value="<?= $userEmail ?>" data-required="true">
          <input type="hidden" name="hash" data-error="Hash" value="<?= $hash ?>" data-required="true">
          <label for="confirmPassword">Confirme a senha</label>
          <i class="fas fa-eye-slash eye-icon" eye-icon="eyeIconConfirmPassword"></i>
        </div>
        <div style="display:none" class="alert alert-danger" id="errorMessage"></div>
        <div class="row">
          <button type="submit" class="btn btn-block red">
            <img style="width:20px;display:none;margin:0 auto;" src="<?= theme("assets/img/loading.gif") ?>" alt="loader">
            <span>Redefinir senha</span>
          </button>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.recover-password-card-body -->
  </div>
</div>
<!-- /.recover-password-box -->