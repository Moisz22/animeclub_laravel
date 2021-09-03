<div>
    @if (session()->has('message'))
        <x-adminlte-alert theme="success" title="Exito" dismissable>{{session('message')}}</x-adminlte-alert>
    @endif
     
    <div class="card card-primary card-outline">
        <div class="card-body">
            <button wire:click="nuevo" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Crear genero</button>
        </div>
        <div class="col-sm-12 col-sm-6 table-responsive">
            <table class="table table-striped table-bordered nowrap" width="100%">
                <thead class="bg-blue">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($generos as $genero)
                    <tr>
                        <td>{{$genero->id}}</td>
                        <td>{{$genero->nombre}}</td>
                        <td><a wire:click="mostrar({{$genero->id}})" data-toggle="modal" data-target="#exampleModal" href="#{{-- {{route('generos.edit', $genero->id)}} --}}" class="btn btn-success"><i class="fas fa-edit"></i></a></td>
                        <td>
                            <button wire:click="$emit('confirm',{{$genero->id}})" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
    </div>
    @include('livewire.modal')
    <script>
        document.addEventListener('livewire:load', ()=>{

            Livewire.on('message', mensaje =>{
                Swal.fire(
                    'Buen trabajo!',
                    mensaje,
                    'success'
                )
            })

            Livewire.on('confirm', id=>{

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.emit('eliminar', id);
                            /* Swal.fire(
                            'Borrado!',
                            'Your file has been deleted.',
                            'success'
                            ) */
                        }
                    })

            })
            
        })
    </script>
</div>
