<?php $v->layout("admin/_admin") ?>
<div class="row">
    <div class="col">
        <?php if (!empty($jobs)) : ?>
            <?php foreach ($jobs as $job) : ?>
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
            <p style="padding: 0 1rem;">Não há projetos para exibir</p>
        <?php endif ?>
    </div>
</div>
<?php if ($totalJobs > 3) : ?>
    <div class="row" style="padding:1rem 0;">
        <div class="col">
            <div class="card-body">
                <a href="#" id="loadNewProjects" class="btn btn-danger load-new-projects">
                    <img style="width:20px;display:none;margin:0 auto;" src="<?= theme("assets/img/loading.gif") ?>" alt="loader">
                    <span>Carregar mais projetos</span>
                </a>
            </div>
        </div>
    </div>
<?php endif ?>
<?php if ($userType == "businessman") : ?>
    <div class="row">
        <div class="col">
            <div class="card-body">
                <a href="<?= url("/braid-system/client-report-form") ?>" class="btn btn-danger">Novo projeto</a>
            </div>
        </div>
    </div>
<?php endif ?>