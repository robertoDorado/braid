<?php $v->layout("admin/_admin") ?>
<div class="row">
    <div class="col">
        <div class="card-body">
            <div class="callout callout-info">
                <h5>I am an info callout!</h5>
                <p>Follow the steps to continue to payment.</p>
            </div>
        </div>
    </div>
</div>
<?php if ($userType == "businessman") : ?>
    <div class="row">
        <div class="col">
            <div class="card-body">
                <a href="<?= url("/braid-system/client-report-form") ?>" class="btn btn-danger">Criar uma tarefa</a>
            </div>
        </div>
    </div>
<?php endif ?>