@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1 class="text-center">Usuarios</h1>
@stop

@section('plugins.Select2', true)
{{-- @section('content')
    <br>
    <br>
    <livewire:tabla-usuarios/>
@stop

@section('js')
    @livewireScripts
@stop --}}

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Crear usuario</button>
            <br>
            <br>
            <table id="datatable_usuarios" class="table table-bordered table-striped no-wrap" style="width: 100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($usuarios as $usuario)
                    <tr>
                        <td><input type="checkbox" name="" id=""></td>
                        <td>{{$usuario->name}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>@foreach($usuario->getRoleNames() as $rol)
                            {{$rol}}
                        @endforeach</td>
                        <td>
                            <a data-toggle="modal" data-target="#exampleModal" class="btn btn-success"><i class="fas fa-edit"></i></a>
                            @if($usuario->id != 1)
                                <button onclick="eliminar();" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            @else
                                <button onclick="eliminar();" class="disabled btn btn-danger"><i class="fas fa-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
    @include('livewire.modals.modalUsuarios')
    
    @section('js')
        <script>
            $(document).ready( function(){
                $('#rol_id').select2({
                    width: "100%"
                });
            })

            
            function eliminar(id)
            {
                Swal.fire({
                    title: 'Está seguro?',
                    text: "Eliminar registro",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar!',
                    cancelButtonText: 'Cancelar',
                    }).then((result) => {
                    if (result.isConfirmed)
                    {
                        fetch(`usuarios/eliminar/${id}`)
                        .then(res => res.json())
                        .then(res => {
                            if(res.sms == 'ok')
                            {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                $('#datatable_usuarios').DataTable().ajax.reload();
                            }
                            else
                            {
                                Swal.fire(
                                    'Error!',
                                    res,
                                    'error'
                                )
                            }
                        })
                        
                    }
                })
            }

            $(document).ready( function(){
                $('#datatable_usuarios').DataTable({ 
                    language: 
                    { 
                        url: '/json/datatables_spanish.json' 
                    },
                    responsive:true,
                    /* processing: true,
                    serverSide: true, */
                    ajax: 'usuarios/consultar'
                });
            })

        </script>
    @stop
@stop
