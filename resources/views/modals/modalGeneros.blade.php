<div>   
  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="modalGeneros" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Genero</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <x-adminlte-input id="genero_id" name="genero_id" label="id"
              fgroup-class="col-md-12 d-none" disable-feedback/>
              <div class="row">
                <x-adminlte-input name="nombre_genero" label="Nombre" minlength="3" placeholder=""
                fgroup-class="col-md-12" disable-feedback/>
                @error('nombre') <span class="error text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="modal-footer"> 
              <button type="button" edicion="false" class="btn btn-success" id="guardar_genero" data-dismiss="modal">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>