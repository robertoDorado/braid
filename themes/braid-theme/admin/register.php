<?php $v->layout("admin/_theme") ?>
<div id="registerType" style="display:none" data-register="<?= $registerType ?>"></div>
<?php $v->insert("utils/modal-form-register") ?>
<div class="register-box">
  <div style="border-top: 3px solid #ff2c2c;" class="card card-outline card-primary">
    <div class="card-header text-center rigister-header">
      <a href="<?= url("/") ?>" class="h1"><img src="<?= theme("assets/img/logo-2-rbg.png") ?>" alt="logo"></a>
    </div>
    <div class="card-body">
      <?php if ($registerType != 'generic') : ?>
        <p class="login-box-msg" id="titleNewMembership"></p>

        <div class="form-container">
          <form id="registerForm" action="#">
            <div class="input-field">
              <input type="text" name="fullName" class="validate" data-required="true">
              <label for="fullName">Nome Completo</label>
            </div>
            <div class="input-field">
              <input type="text" name="userName" class="validate" data-required="true">
              <label for="userName">Nome de usuário</label>
            </div>
            <div class="input-field">
              <input type="text" name="email" id="email" class="validate" data-required="true">
              <label for="email">Email</label>
            </div>
            <div class="input-field">
              <input type="password" name="password" id="password" class="validate" data-required="true">
              <label for="password">Senha</label>
              <i class="fas fa-eye-slash eye-icon" eye-icon="eyeIconPassword"></i>
            </div>
            <div class="input-field">
              <input type="password" name="confirmPassword" id="confirmPassword" class="validate" data-required="true">
              <label for="confirmPassword">Confirme a senha</label>
              <input type="hidden" name="csrfToken" value="<?= !empty($csrfToken) ? $csrfToken : '' ?>" data-required="true">
              <i class="fas fa-eye-slash eye-icon" eye-icon="eyeIconConfirmPassword"></i>
              <input type="hidden" name="userType" value="<?= !empty($registerType) ? $registerType : '' ?>" data-required="true">
            </div>
            <ul class="conditions" id="conditions">
              <li><span class="cross">&#x2718;</span>Pelo menos 8 caracteres de comprimento.</li>
              <li><span class="cross">&#x2718;</span>Pelo menos uma letra maiúscula.</li>
              <li><span class="cross">&#x2718;</span>Pelo menos um caractere numérico.</li>
              <li><span class="cross">&#x2718;</span>Um caractere especial (@, #, $, %, ^, &, +, =, ou !).</li>
            </ul>
            <div style="display:none" class="alert alert-danger" id="errorMessage"></div>
            <div class="photo-preview" id="photoPreview" style="display:none;">
              <img src="#" alt="foto">
            </div>
            <div class="file-input-container">
              <span class="file-input-icon"></span>
              <span class="file-input-text">Selecione uma foto de perfil</span>
              <input type="file" name="photoImage" id="photoImage">
            </div>
            <button style="width:150px;" type="submit" class="btn btn-block">
              <img style="width:20px;display:none;margin:0 auto;" src="<?= theme("assets/img/loading.gif") ?>" alt="loader">
              <span>Cadastrar</span>
            </button>
          </form>
        </div>

        <div class="social-auth-links text-center">
          <a href="#" class="btn btn-block">
            <i class="fab fa-facebook mr-2"></i>
            Login com Facebook
          </a>
          <a href="#" class="btn btn-block">
            <i class="fab fa-google-plus mr-2"></i>
            Login com Google
          </a>
        </div>
        <span class="text-center">Já possui uma conta? <a href="<?= url("user/login") ?>" style="text-decoration:underline">Faça login</a></span>
      <?php endif ?>

    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->