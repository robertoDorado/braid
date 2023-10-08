<?php $v->layout("_theme") ?>
<div class="container-message">
    <?php if ($isValidUser) : ?>
        <h1>O seu e-mail foi confirmado com sucesso! <br/>
            <a href="<?= url("/user/login") ?>" class="w3-button w3-padding-large w3-large w3-margin-top" style="background-color: #ff2c2c;color:#fff;">Faça login agora mesmo!</a></h1>
    <?php else : ?>
        <h1>Houve algum problema ao confirmar o seu e-mail.</h1>
    <?php endif ?>
</div>