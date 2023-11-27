<?php $v->layout("admin/_admin") ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-header bg-danger">
                        <h3 class="card-title">Dados adicionais</h3>
                    </div>
                    <form id="clientReportForm">
                        <div class="card-body">
                            <?php if ($userType == "designer") : ?>
                                <?= $v->insert("utils/designer-additionaldata-form") ?>
                            <?php else : ?>
                                <?= $v->insert("utils/businessman-additionaldata-form") ?>
                            <?php endif ?>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn bg-danger">
                                <img style="width:20px;display:none;margin:0 auto;" src="<?= theme("assets/img/loading.gif") ?>" alt="loader">
                                <span>Atualizar</span>
                            </button>
                        </div>
                        <div style="text-align:center;display:none;" class="alert alert-danger" id="errorMessage"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>