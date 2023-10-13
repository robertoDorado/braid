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

          <form>
            <div class="card-body">
              <div class="form-group">
                <label for="fullName">Nome Compeleto</label>
                <input type="text" class="form-control" value="<?= $fullName ?>" id="fullName" placeholder="Nome completo">
              </div>
              <div class="form-group">
                <label for="nickName">Nome de Usuário</label>
                <input type="text" class="form-control" value="<?= $nickName ?>" id="nickName" placeholder="Nome de usuário">
              </div>
              <div class="form-group">
                <label for="emailData">Endereço de E-mail</label>
                <input type="email" class="form-control" value="<?= $fullEmail ?>" id="emailData" placeholder="Endereço de e-mail">
              </div>
              <div class="form-group">
                <div class="photo-preview" id="photoPreview">
                  <img src="<?= !empty($pathPhoto) ? theme("assets/img/user/" . $pathPhoto . "") : theme("assets/img/user/default.png") ?>" alt="foto">
                </div>
                <label for="fotoDePerfil">Foto de Perfil</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="fotoDePerfil">
                    <label class="custom-file-label" for="fotoDePerfil">Foto de perfil</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-danger">Alterar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->