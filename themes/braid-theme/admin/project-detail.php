<?php $v->layout("admin/_admin") ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
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
                    <a href="<?= url("braid-system/contract-form/" . base64_encode($jobData->id) . "") ?>" class="btn btn-success w3-large w3-padding-large make-a-proposal">Fazer uma proposta</a>
                </div>
            </div>
        <?php endif ?>
    </div>
</section>