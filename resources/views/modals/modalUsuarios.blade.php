<div>   
  <!-- Modal -->
  <div class="modal fade" id="modalUsuarios" tabindex="-1" aria-labelledby="modalUsuarios" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
            <div class="modal-header">
            <h5 class="modal-title" id="modalUsuarios">Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <x-adminlte-input name="user_id" label="id"
              fgroup-class="col-md-12 d-none" disable-feedback/>
                <x-adminlte-input id="nombre_usuario" name="nombre" label="Nombre" minlength="3"
                fgroup-class="col-md-12" disable-feedback/>
                <x-adminlte-input id="email_usuario" name="email" label="email" fgroup-class="col-md-12" disable-feedback/>
                <x-adminlte-select2 label="Rol" fgroup-class="col-md-12" class="col-md-12 form-control" name="rol_id">
                  <option value="">Seleccione un rol</option>
                  @foreach ($roles as $rol)
                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                  @endforeach
                </x-adminlte-select2>

              </div>
            </div>
            <div class="modal-footer"> 
              <button id="guardar_usuario" edicion="false" type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>