<div>   
  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <x-adminlte-input name="genero_id" wire:model="genero_id" label="id" id="genero_id"
              fgroup-class="col-md-12 d-none" value="{{old('genero_nombre')}}" disable-feedback/>
              <div class="row">
                <x-adminlte-input name="genero_nombre" wire:model="nombre" label="Nombre" id="genero_nombre" minlength="3" placeholder=""
                fgroup-class="col-md-12" value="{{old('genero_nombre')}}" disable-feedback/>
                @error('nombre') <span class="error text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="modal-footer"> 
                @if($genero_id)
                  <button type="button" class="btn btn-success" wire:click.prevent="guardar" data-dismiss="modal">Actualizar</button>
                @else
                  <button type="button" class="btn btn-success" wire:click.prevent="guardar" data-dismiss="modal">Guardar</button>
                @endif
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>