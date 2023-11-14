<?php $v->layout("admin/_admin")  ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?= empty($profileData->path_photo) ? theme("assets/img/user/default.png") : theme("assets/img/user/" . $profileData->path_photo . "") ?>" alt="photo-designer">
                        </div>
                        <h3 class="profile-username text-center"><?= $profileData->full_name ?></h3>
                        <p class="text-muted text-center"><?= empty($profileData->position_data) ? "Não especificado" : $profileData->position_data ?></p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <div class="stars-container">
                                    <b>Avaliação</b>
                                    <div class="stars">
                                        <input type="radio" id="cm_star-empty-data" name="fbData" value="" checked disabled />
                                        <label for="cm_star-1-data"><i class="fa"></i></label>
                                        <input type="radio" id="cm_star-1-data" name="fbData" value="1" disabled />
                                        <label for="cm_star-2-data"><i class="fa"></i></label>
                                        <input type="radio" id="cm_star-2-data" name="fbData" value="2" disabled />
                                        <label for="cm_star-3-data"><i class="fa"></i></label>
                                        <input type="radio" id="cm_star-3-data" name="fbData" value="3" disabled />
                                        <label for="cm_star-4-data"><i class="fa"></i></label>
                                        <input type="radio" id="cm_star-4-data" name="fbData" value="4" disabled />
                                        <label for="cm_star-5-data"><i class="fa"></i></label>
                                        <input type="radio" id="cm_star-5-data" name="fbData" value="5" disabled />
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-primary btn-block"><b>Chat</b></a>
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
                            <strong><i class="fas fa-book mr-1"></i> Descrição do perfil</strong>
                            <p class="text-muted">
                                <?= empty($profileData->biography_data) ? "Não especificado" : $profileData->biography_data ?>
                            </p>
                            <hr>
                            <strong><i class="fa fa-bullseye mr-1"></i> Objetivos profissionais</strong>
                            <p class="text-muted">
                                <?= empty($profileData->goals_data) ? "Não especificado" : $profileData->goals_data ?>
                            </p>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Qualificações</strong>
                            <p class="text-muted">
                                <?= empty($profileData->qualifications_data) ? "Não específicado" : $profileData->qualifications_data ?>
                            </p>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Experiências anteriores</strong>
                            <p class="text-muted">
                                <?= empty($profileData->experience_data) ? "Não específicado" : $profileData->experience_data ?>
                            </p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div id="containerCandidates">
                    <div class="callout callout-danger container-designer">
                        <div class="designer-data">
                            <img src="<?= empty($profileData->path_photo) ? theme("assets/img/user/default.png") : theme("assets/img/user/" . $profileData->path_photo . "") ?>" class="photo-designer" alt="photo-designer">
                            <p><?= $profileData->full_name ?></p>
                        </div>
                        <div class="description-data-designer">
                            <form id="evaluationProfile" class="stars-container-evaluate">
                                <b>Avalie o perfil desse usuário</b>
                                <div class="stars pointer">
                                    <input type="radio" id="cm_star-empty" name="fb" value="" checked />
                                    <label for="cm_star-1"><i class="fa"></i></label>
                                    <input type="radio" id="cm_star-1" name="fb" value="1" />
                                    <label for="cm_star-2"><i class="fa"></i></label>
                                    <input type="radio" id="cm_star-2" name="fb" value="2" />
                                    <label for="cm_star-3"><i class="fa"></i></label>
                                    <input type="radio" id="cm_star-3" name="fb" value="3" />
                                    <label for="cm_star-4"><i class="fa"></i></label>
                                    <input type="radio" id="cm_star-4" name="fb" value="4" />
                                    <label for="cm_star-5"><i class="fa"></i></label>
                                    <input type="radio" id="cm_star-5" name="fb" value="5" />
                                </div>
                                <div class="form-group">
                                    <textarea name="evaluateDescription" id="evaluateDescription" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar avaliação</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>