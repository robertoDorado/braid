<?php $v->layout("_theme") ?>
<div class="confirm-email-container">
    <?php if ($isValidUser) : ?>
        <h1>O seu e-mail foi confirmado com sucesso, 
            <a href="<?= url("/user/login") ?>">Faça login agora mesmo!</a></h1>
    <?php else : ?>
        <h1>Houve algum problema ao confirmar o seu e-mail.</h1>
    <?php endif ?>
</div>