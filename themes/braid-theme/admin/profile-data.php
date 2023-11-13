<?php $v->layout("admin/_admin")  ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">Nina Mcintire</h3>
                        <p class="text-muted text-center">Software Engineer</p>
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
                        <strong><i class="fas fa-book mr-1"></i> Education</strong>
                        <p class="text-muted">
                            B.S. in Computer Science from the University of Tennessee at Knoxville
                        </p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                        <p class="text-muted">Malibu, California</p>
                        <hr>
                        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                        <p class="text-muted">
                            <span class="tag tag-danger">UI Design</span>
                            <span class="tag tag-success">Coding</span>
                            <span class="tag tag-info">Javascript</span>
                            <span class="tag tag-warning">PHP</span>
                            <span class="tag tag-primary">Node.js</span>
                        </p>
                        <hr>
                        <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div id="containerCandidates">
                    <div class="callout callout-danger container-designer">
                        <div class="designer-data">
                            <img src="<?= theme("assets/img/user/default.png") ?>" class="photo-designer" alt="photo-designer">
                            <p>Nome do usuário</p>
                        </div>
                        <div class="description-data-designer">
                            <form id="evaluationProfile" class="stars-container-evaluete">
                                <b>Avalie o perfil desse usuário</b>
                                <div class="stars">
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
                                <button type="submit" class="btn btn-primary">Enviar avaliação</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>