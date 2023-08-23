<?php $v->layout("admin/_theme") ?>
<div id="registerType" style="display:none" data-register="<?= $registerType ?>"></div>
<?php $v->insert("utils/modal-form-register") ?>
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center rigister-header">
      <a href="<?= url("/") ?>" class="h1"><img src="<?= theme("assets/img/logo-2-rbg.png") ?>" alt="logo"></a>
    </div>
    <div class="card-body">
      <?php if ($registerType != 'generic') : ?>
        <p class="login-box-msg" id="titleNewMembership"></p>

        <div class="form-container">
          <form id="registerForm" class="material-form">
            <div class="input-container">
              <input type="text" name="fullName" required>
              <label>Nome Completo</label>
            </div>
            <div class="input-container">
              <input type="text" name="userName" required>
              <label>Nome de usuário</label>
            </div>
            <div class="input-container">
              <input type="text" name="email" id="email" required>
              <label>Email</label>
            </div>
            <div class="input-container">
              <input type="password" name="password" id="password" required>
              <label>Senha</label>
              <i class="fas fa-eye-slash eye-icon" id="eyeIconPassword"></i>
            </div>
            <div class="input-container">
              <input type="password" name="confirmPassword" id="confirmPassword" required>
              <label>Confirme a senha</label>
              <i class="fas fa-eye-slash eye-icon" id="eyeIconConfirmPassword"></i>
            </div>
            <ul class="conditions" id="conditions">
              <li><span class="cross">&#x2718;</span>Pelo menos 8 caracteres de comprimento.</li>
              <li><span class="cross">&#x2718;</span>Pelo menos uma letra maiúscula.</li>
              <li><span class="cross">&#x2718;</span>Pelo menos um caractere numérico.</li>
              <li><span class="cross">&#x2718;</span>Um caractere especial (@, #, $, %, ^, &, +, =, ou !).</li>
            </ul>
            <div class="file-input-container">
              <span class="file-input-icon"></span>
              <span class="file-input-text">Selecione uma foto de perfil</span>
              <input type="file" name="photoImage">
            </div>
            <input type="hidden" name="userType" value="<?= $registerType ?>" disabled>
            <button type="submit" class="custom-button">Cadastrar</button>
          </form>
        </div>

        <div class="social-auth-links text-center">
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i>
            Sign up using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger-braid">
            <i class="fab fa-google-plus mr-2"></i>
            Sign up using Google+
          </a>
        </div>
        <span class="text-center">Já possui uma conta? <a href="<?= url("user/login") ?>" style="text-decoration:underline">Faça login</a></span>
      <?php endif ?>

    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->