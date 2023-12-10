<?php $v->layout("admin/_admin") ?>
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
                        <strong>
                            <p class="text-muted text-center"><?= empty($positionData) ? "Não especificado" : $positionData ?></p>
                        </strong>
                        <a href="#" id="btnOpenChat" data-csrf="<?= empty($csrfToken) ? "" : $csrfToken ?>" class="btn btn-primary btn-block"><b>Chat</b></a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Perfil</h3>
                    </div>
                    <div class="card-body">
                        <?php $v->insert("utils/businessman-profile") ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>