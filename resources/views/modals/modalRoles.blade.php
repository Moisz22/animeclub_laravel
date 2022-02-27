<div>   
  <!-- Modal -->
  <div class="modal fade" id="ModalRoles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Roles</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <x-adminlte-input name="rol_id" label="id"
              fgroup-class="col-md-12 d-none" disable-feedback/>
              <div class="row">
                <x-adminlte-input name="nombre_rol"  label="Nombre" minlength="3"
                fgroup-class="col-md-12" disable-feedback/>
              </div>
            </div>
            <div class="modal-footer"> 
              <button type="button" edicion="false" class="btn btn-success" id="guardar_rol" data-dismiss="modal">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>