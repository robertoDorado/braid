<?php $v->layout("admin/_admin") ?>
<div class="row">
    <div class="col">
        <?php if (!empty($jobs)) : ?>
            <?php foreach($jobs as $job): ?>
                <div class="card-body">
                    <div class="callout callout-info">
                        <h5><?= $job->job_name ?></h5>
                        <p><?= $job->job_description ?></p>
                        <p><?= "Valor do acordo: R$ " . number_format($job->remuneration_data, 2, ",", ".") ?></p>
                        <p><?= "Prazo de entrega: " . date("d/m/Y H:i", strtotime($job->delivery_time)) ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <p style="padding: 0 1rem;">Não há dados para exibir</p>
        <?php endif ?>
    </div>
</div>
<?php if ($userType == "businessman") : ?>
    <div class="row">
        <div class="col">
            <div class="card-body">
                <a href="<?= url("/braid-system/client-report-form") ?>" class="btn btn-danger">Nova tarefa</a>
            </div>
        </div>
    </div>
<?php endif ?>