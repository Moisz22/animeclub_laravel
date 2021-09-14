<div>   
  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <x-adminlte-input name="user_id" wire:model="user_id"
              fgroup-class="col-md-12 d-none" disable-feedback/>
              <div class="row">
                <x-adminlte-input name="nombre" wire:model="nombre" label="Nombre" minlength="3"
                fgroup-class="col-md-12" disable-feedback/>
                @error('nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                <x-adminlte-input name="email" label="email" wire:model="email" fgroup-class="col-md-12" disable-feedback/>
                @error('email') <span class="error text-danger">{{$message}}</span> @enderror
                <label for="rol">Rol</label><select class="col-md-12 form-control" name="rol_id" id="rol_id" wire:model="rol_id">
                  <option>Seleccione un rol</option>
                  @foreach ($roles as $rol)
                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="modal-footer"> 
                @if($user_id)
                  <button type="button" class="btn btn-success" wire:click.prevent="actualizar" data-dismiss="modal">Actualizar</button>
                @else
                  <button type="button" class="btn btn-success" wire:click.prevent="guardar" data-dismiss="modal">Guardar</button>
                @endif
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>