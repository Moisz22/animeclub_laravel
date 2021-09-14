<div>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <x-adminlte-select wire:change="mostrar($event.target.value)" name="selRol" label="Rol" label-class="text-lightblue"
                igroup-size="lg" id="roles">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                        <i class="fas fa-user-tag"></i>
                    </div>
                </x-slot>
                <option>Seleccione rol</option>
                @foreach ($roles as $rol)
                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                @endforeach
            </x-adminlte-select>
        </div>
        <br>
    </div>

    <div class="card card-primary card-outline {{$casilla_permisos}}">
        <div class="card-body">
            <div class="col-sm-12 col-sm-6 table-responsive">
                <table class="table table-striped table-bordered nowrap" width="100%">
                    <thead class="bg-blue">
                        <tr>
                            <th class="text-center">Nombre Permiso</th>
                            <th class="text-center">Permiso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permisos as $permiso)
                        <tr>
                            <td class="text-center">{{$permiso->name}}</td>
                            <td class="text-center">
                                @if(in_array($permiso->name,$permisos_rol))
                                    <input wire:change="asigna_permiso('checked', {{$permiso->id}})" type="checkbox" name={{$permiso->name}} id="{{$permiso->name}}" checked>
                                @else
                                    <input wire:change="asigna_permiso('no',{{$permiso->id}})" type="checkbox" name={{$permiso->name}} id="{{$permiso->name}}">    
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', ()=>{

            Livewire.on('message', mensaje =>{

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: mensaje,
                    showConfirmButton: false,
                    timer: 800
                })
            })
            
        })
    </script>

</div>
