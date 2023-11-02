<?php $v->layout("admin/_admin") ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-header bg-danger">
                        <h3 class="card-title">Fazer uma proposta</h3>
                    </div>
                    <form id="contractForm">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="additionalDescription">Descrições adicionais</label>
                                <textarea type="text" name="additionalDescription" class="form-control" data-required="true" data-error="Descrições adicionais" id="additionalDescription" placeholder="Descrições adicionais sobre a proposta"></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn bg-danger">
                                <img style="width:20px;display:none;margin:0 auto;" src="<?= theme("assets/img/loading.gif") ?>" alt="loader">
                                <span>Enviar proposta</span>
                            </button>
                        </div>
                        <div style="text-align:center;display:none;" class="alert alert-danger" id="errorMessage"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>