<div>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <button wire:click="nuevo" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Crear usuario</button>
        </div>
        <div class="col-sm-12 col-sm-6 table-responsive">
            <table class="table table-striped table-bordered nowrap" width="100%">
                <thead class="bg-blue">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->id}}</td>
                        <td>{{$usuario->name}}</td>
                        <td>{{$usuario->email}}</td>
                        <td><a wire:click="mostrar({{$usuario->id}})" data-toggle="modal" data-target="#exampleModal" class="btn btn-success"><i class="fas fa-edit"></i></a></td>
                        <td>
                            @if($usuario->id != 1)
                                <button wire:click="$emit('confirm',{{$usuario->id}})" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            @else
                                <button class="disabled btn btn-danger"><i class="fas fa-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                {{$usuarios->links()}}
        </div>
        <br>
    </div>
    @include('livewire.modals.modalUsuarios')

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
                    text: "No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.emit('eliminar', id);
                        }
                    })

            })
            
        })

    </script>
</div>
