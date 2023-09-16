<?php $v->layout("_theme") ?>
<div class="error-container">
    <h1><?= $errorCode ?></h1>
    <p>Desculpe, a página que você está procurando não foi encontrada.</p>
    <p>Volte para a <a href="<?= url("/") ?>">página inicial</a>.</p>
</div>