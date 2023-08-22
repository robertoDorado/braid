<?php $v->layout("admin/_theme") ?>
<div id="registerType" style="display:none" data-register="<?= $registerType ?>"></div>
<?php $v->insert("utils/modal-form-register") ?>
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center rigister-header">
      <a href="<?= url("/") ?>" class="h1"><img src="<?= theme("assets/img/logo-2-rbg.png") ?>" alt="logo"></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg" id="titleNewMembership"></p>


      <?php if ($registerType == 'businessman') : ?>
        <?= $v->insert("utils/businessman-form")  ?>
      <?php elseif ($registerType == 'designer') : ?>
          <?= $v->insert("utils/designer-form")  ?>
      <?php endif ?>
      
      <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="login.html" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->