<?php $v->layout("admin/_admin") ?>
<section class="content">
    <div class="container-fluid" id="containerProjectDescription">
        <div class="row">
            <div class="col">
                <div class="card">
                    <?php if (!empty($contractData)) : ?>
                        <img class="check-mark-candidate" src="<?= theme("assets/img/green-double-circle-check-mark.png") ?>" alt="check-mark">
                    <?php endif ?>
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-project-diagram"></i>
                            Descrição do projeto
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl>
                            <dt>Título do projeto</dt>
                            <dd><?= $jobData->job_name ?></dd>
                            <dt>Descrição do projeto</dt>
                            <dd><?= $jobData->job_description ?></dd>
                            <dt>Remuneração pelo projeto concluído</dt>
                            <dd><?= "R$ " . number_format($jobData->remuneration_data, 2, ",", ".") ?></dd>
                            <dt>Prazo de entrega</dt>
                            <dd><?= date("d/m/Y H:i", strtotime($jobData->delivery_time)) ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($userType == "designer") : ?>
            <div class="row">
                <div class="col">
                    <?php if (empty($contractData)) : ?>
                        <a href="#" id="makeProposal" class="btn btn-success w3-large w3-padding-large make-a-proposal">Fazer uma proposta</a>
                    <?php else : ?>
                        <div class="alert alert-warning alert-already-make-proposal">você já se candidatou para este projeto</div>
                    <?php endif ?>
                </div>
            </div>
        <?php else : ?>
            <div class="callout callout-danger container-designer">
                <div class="designer-data">
                    <img src="<?= theme("assets/img/user/default.png") ?>" class="photo-designer" alt="photo-designer">
                    <p>Teste</p>
                </div>
                <div class="description-data-designer">
                    <p>teste teste</p>
                </div>
            </div>
        <?php endif ?>
    </div>
</section>