<?php $v->layout("admin/_admin") ?>
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="card card-primary">
          <div class="card-header bg-danger">
            <h3 class="card-title">Editar Perfil</h3>
          </div>

          <form id="formAlterProfile">
            <div class="card-body">
              <div class="form-group">
                <label for="fullName">Nome Compeleto</label>
                <input type="text" class="form-control" name="fullName" data-required="true" data-error="Nome Completo" value="<?= !empty($fullName) ? $fullName : '' ?>" id="fullName" placeholder="Nome completo">
              </div>
              <div class="form-group">
                <label for="userName">Nome de Usuário</label>
                <input type="text" class="form-control" name="userName" data-required="true" data-error="Nome de Usuário" value="<?= !empty($nickName) ? $nickName : '' ?>" id="userName" placeholder="Nome de usuário">
                <input type="hidden" class="form-control" name="dataKey" data-required="true" data-error="dataKey" id="dataKey" value="<?= !empty($fullEmail) ? base64_encode($fullEmail) : '' ?>">
                <input type="hidden" class="form-control" name="csrfToken" data-error="Token" value="<?= !empty($csrfToken) ? $csrfToken : '' ?>" data-required="true">
              </div>
              <div class="form-group">
                <div class="photo-preview" id="photoPreview">
                  <img src="<?= theme("assets/img/user/default.png") ?>" alt="foto">
                </div>
                <label for="photoImage">Foto de Perfil</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" name="photoImage" class="custom-file-input" id="photoImage">
                    <label class="custom-file-label" for="photoImage">Foto de perfil</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-danger">
                <img style="width:20px;display:none;margin:0 auto;" src="<?= theme("assets/img/loading.gif") ?>" alt="loader">
                <span>Alterar</span>
              </button>
            </div>
            <div style="text-align:center;display:none;" class="alert alert-danger" id="errorMessage"></div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->