<button type="button" id="launchGenericModal" style="display:none;" class="btn" data-toggle="modal" data-target="#exampleModal">
  Launch modal
</button>

<div style="background-color:transparent;box-shadow:none;" class="modal fade" data-backdrop="static" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header header-form-register">
        <h5 style="text-align:center;margin:0;" class="modal-title" id="exampleModalLabel">Escolha qual será o seu tipo de usuário?</h5>
      </div>
      <div class="modal-body">
        <div class="logo-title">
          <img src="<?= theme("assets/img/logo-2-rbg.png") ?>" alt="logo">
        </div>
        <form action="#" id="genericForms" method="post">
          <div class="form-choices">
            <div class="form-check">
              <input type="radio" class="with-gap" id="businessman" name="option" value="businessman">
              <label class="form-check-label" for="businessman">Empresa</label>
            </div>
            <div class="form-check">
              <input type="radio" class="with-gap" id="designer" name="option" value="designer">
              <label class="form-check-label" for="designer">Designer</label>
            </div>
            <button type="submit" class="btn btn-danger mt-3 red">Enviar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>