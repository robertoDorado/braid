<!-- Button trigger modal -->
<button type="button" id="launchSureDeleteModal" style="display:none;margin-left:1rem;" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
  Launch sure delete modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="font-weight:bold">Atenção!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="font-weight:bold">Você está prestes a deletar o projeto:</p>
        <div class="callout callout-info" id="calloutModalDeleteProject">
            <h5 id="titleProject"></h5>
            <p id="descriptionProject"></p>
            <p id="remunerationData"></p>
            <p id="deliveryTime"></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="deleteBtnModal">Excluir</button>
      </div>
    </div>
  </div>
</div>