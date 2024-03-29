<?php $v->layout("admin/_admin") ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-header bg-danger">
                        <h3 class="card-title">Novo projeto</h3>
                    </div>
                    <form id="clientReportForm">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="jobName">Título do projeto</label>
                                <input type="text" name="jobName" class="form-control" data-required="true" data-error="Título do projeto" id="jobName" placeholder="Título do projeto">
                            </div>
                            <div class="form-group">
                                <label for="jobDescription">Descrição do projeto</label>
                                <textarea type="text" name="jobDescription" class="form-control" data-required="true" data-error="Descrição do projeto" id="jobDescription" placeholder="Descrição do projeto"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="remunerationData">Valor de remuneração</label>
                                <input type="text" name="remunerationData" class="form-control" data-mask="money" data-required="true" data-error="Valor de remuneração" id="remunerationData" placeholder="Valor de remuneração">
                            </div>
                            <div class="form-group">
                                <label for="deliveryTime">Prazo de entrega</label>
                                <input type="datetime-local" name="deliveryTime" class="form-control" data-required="true" data-error="Prazo de entrega" id="deliveryTime" placeholder="Prazo de entrega">
                                <input type="hidden" class="form-control" name="csrfToken" value="<?= empty($csrfToken) ? "" : $csrfToken ?>" data-required="true" data-error="Token">
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn bg-danger">
                            <img style="width:20px;display:none;margin:0 auto;" src="<?= theme("assets/img/loading.gif") ?>" alt="loader">
                                <span>Cadastrar</span>
                            </button>
                        </div>
                        <div style="text-align:center;display:none;" class="alert alert-danger" id="errorMessage"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>