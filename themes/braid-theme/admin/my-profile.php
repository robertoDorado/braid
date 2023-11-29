<?php $v->layout("admin/_admin")  ?>

<section class="content" data-hash="<?= base64_encode($profileData->id) ?>">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?= empty($profileData->path_photo) ? theme("assets/img/user/default.png") : theme("assets/img/user/" . $profileData->path_photo . "") ?>" alt="photo-designer">
                        </div>
                        <h3 class="profile-username text-center"><?= $profileData->full_name ?></h3>
                        <strong><p class="text-muted text-center"><?= empty($positionData) ? "Não especificado" : $positionData ?></p></strong>
                        <?php if ($profileType->user_type == "designer") : ?>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <div class="stars-container">
                                        <b>Avaliação</b>
                                        <div class="stars">
                                            <input type="radio" id="cm_star-empty-data" name="fbData" value="" <?= empty($meanEvaluation) ? "checked" : "" ?> checked disabled />
                                            <label for="cm_star-1-data"><i class="fa"></i></label>
                                            <input type="radio" id="cm_star-1-data" name="fbData" value="1" <?= $meanEvaluation == 1 ? "checked" : "" ?> disabled />
                                            <label for="cm_star-2-data"><i class="fa"></i></label>
                                            <input type="radio" id="cm_star-2-data" name="fbData" value="2" <?= $meanEvaluation == 2 ? "checked" : "" ?> disabled />
                                            <label for="cm_star-3-data"><i class="fa"></i></label>
                                            <input type="radio" id="cm_star-3-data" name="fbData" value="3" <?= $meanEvaluation == 3 ? "checked" : "" ?> disabled />
                                            <label for="cm_star-4-data"><i class="fa"></i></label>
                                            <input type="radio" id="cm_star-4-data" name="fbData" value="4" <?= $meanEvaluation == 4 ? "checked" : "" ?> disabled />
                                            <label for="cm_star-5-data"><i class="fa"></i></label>
                                            <input type="radio" id="cm_star-5-data" name="fbData" value="5" <?= $meanEvaluation == 5 ? "checked" : "" ?> disabled />
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Perfil</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($profileType->user_type == "designer") : ?>
                            <?php $v->insert("utils/designer-profile") ?>
                        <?php else : ?>
                            <?php $v->insert("utils/businessman-profile") ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($profileType->user_type == "designer") : ?>
            <div class="row">
                <div class="col" id="containerEvaluation">
                    <?php if (!empty($evaluationDesignerData)) : ?>
                        <?php foreach ($evaluationDesignerData as $dataEvaluate) : ?>
                            <div class="callout callout-danger container-designer">
                                <div class="description-data-designer">
                                    <div class="stars">
                                        <input type="radio" value="" <?= empty($dataEvaluate->rating_data) ? "checked" : "" ?> />
                                        <label><i class="fa"></i></label>
                                        <input type="radio" value="1" <?= $dataEvaluate->rating_data == 1 ? "checked" : "" ?> />
                                        <label><i class="fa"></i></label>
                                        <input type="radio" value="2" <?= $dataEvaluate->rating_data == 2 ? "checked" : "" ?> />
                                        <label><i class="fa"></i></label>
                                        <input type="radio" value="3" <?= $dataEvaluate->rating_data == 3 ? "checked" : "" ?> />
                                        <label><i class="fa"></i></label>
                                        <input type="radio" value="4" <?= $dataEvaluate->rating_data == 4 ? "checked" : "" ?> />
                                        <label><i class="fa"></i></label>
                                        <input type="radio" value="5" <?= $dataEvaluate->rating_data == 5 ? "checked" : "" ?> />
                                    </div>
                                    <p><?= $dataEvaluate->evaluation_description ?></p>
                                </div>
                            </div>
                        <?php endforeach ?>
                </div>
            </div>
            <?php if ($totalEvaluationDesigner > 3) : ?>
                <div class="row">
                    <div class="col load-evaluation">
                        <a href="#" id="loadEvaluate" class="btn btn-danger">
                            <img style="width:20px;display:none;margin:0 auto;" src="<?= theme("assets/img/loading.gif") ?>" alt="loader">
                            <span>Carregar mais avaliações</span>
                        </a>
                    </div>
                </div>
            <?php endif ?>
        <?php endif ?>
    <?php endif ?>
    </div>
</section>