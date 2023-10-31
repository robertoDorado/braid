<?php $v->layout("admin/_admin") ?>
<?= $v->insert("utils/modal-sure-delete") ?>
<h2 class="text-center display-4">Pesquisa</h2>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <form action="#" id="formSearchProject" class="form-search-project">
            <div class="input-group">
                <input type="search" name="searchProject" class="form-control form-control-lg" placeholder="Pesquise o projeto por título ou descrição">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-lg btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col">
        <?php if (!empty($jobs)) : ?>
            <?php foreach ($jobs as $job) : ?>
                <div class="card-body" id="cardBody" data-user="<?= $userType ?>">
                    <div class="callout callout-info">
                        <h5><?= $job->job_name ?></h5>
                        <p><?= $job->job_description ?></p>
                        <p><?= "Valor do acordo: R$ " . number_format($job->remuneration_data, 2, ",", ".") ?></p>
                        <p><?= "Prazo de entrega: " . date("d/m/Y H:i", strtotime($job->delivery_time)) ?></p>
                        <?php if ($userType == "businessman") : ?>
                            <a href="<?= url("/braid-system/edit-project/{$job->id}") ?>" class="btn btn-primary sample-format-link">Editar dados do projeto</a>
                            <a href="#" data-hash="<?= $job->id ?>" class="btn btn-danger sample-format-link delete-project">Excluir projeto</a>
                            <a href="#" class="btn btn-primary project-detail">Ver detalhes do projeto</a>
                        <?php else: ?>
                            <a href="#" class="btn btn-primary project-detail">Ver detalhes do projeto</a>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <div class="warning-empty-registers">
                <p style="padding: 1rem 0">Não há projetos para exibir</p>
            </div>
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