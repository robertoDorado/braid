<?php $v->layout("_theme") ?>
<div class="container-message">
    <h1>Este link está expirado, tente redefinir a senha novamente
        <a href="<?= url("user/recover-password") ?>" 
        class="w3-button w3-padding-large w3-large w3-margin-top" 
        style="background-color: #ff2c2c;color:#fff;">Redefinir a senha</a>
    </h1>
</div>