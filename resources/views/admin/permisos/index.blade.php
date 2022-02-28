@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    <h1 class="text-center">Permisos</h1>
@stop

@section('plugins.Select2', true)

@section('content')

<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="row">
            {{-- <x-adminlte-button id="crear_rol" label="+" data-toggle="modal" data-target="#modalRoles" class="col-sm-2" theme="primary" icon="fas fa-user-tag"/> --}}
            <button type="button" id="crear_rol" class="btn btn-primary col-sm-1 col-2" data-toggle="modal" data-target="#ModalRoles" data-toggle1="tooltip" data-placement="top" title="Agregar Roles"><i class="fas fa-user-tag">+</i></button>
            {{-- <x-adminlte-select name="rol" label-class="text-lightblue col-sm-2"
                igroup-size="lg" id="rol">
                <x-slot name="prependSlot">
                    <div class="input-group-text col-sm-6 bg-gradient-info">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </x-slot>
                <option>Seleccione rol</option>
                @foreach ($roles as $rol)
                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                @endforeach
            </x-adminlte-select> --}}
            <div class="col-sm-11 col-10">
                <select class="form-input" name="rol" id="rol">
                    <option>Seleccione rol</option>
                    @foreach ($roles as $rol)
                        <option value="{{$rol->id}}">{{$rol->name}}</option>
                    @endforeach
                </select>
            </div>
            
        </div>
        
    </div>
    <br>
</div>

<div class="card card-primary card-outline">
    <div class="card-body">
        <table  id="datatable_permisos" class="table table-bordered table-striped no-wrap" style="width: 100%">
            <thead>
                <tr>
                    <th>Nombre Permiso</th>
                    <th>Permiso</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
    {{-- <livewire:lista-permisos> --}}
    @include('modals.modalRoles')

@stop

@section('js')
    <script>
        $(document).ready( function(){
            $('#rol').select2({
                width: '100%'
            });
        })

        document.getElementById('crear_rol').addEventListener('click', ()=>{

            document.getElementById('guardar_rol').classList.remove('btn-warning');
            document.getElementById('guardar_rol').classList.add('btn-success');
            document.getElementById('guardar_rol').setAttribute('edicion', 'false');
            document.getElementById('guardar_rol').textContent = "Guardar";

            document.getElementById('nombre_rol').value = ""; 
            document.getElementById('rol_id').selectedIndex = 0; 
            setTimeout(() => {
                document.getElementById('nombre_rol').focus();
            }, 700);
        })

        document.getElementById('guardar_rol').addEventListener('click', ()=>{

            let datos = new FormData();
            let id = document.getElementById('rol_id').value;
            datos.append('nombre', document.getElementById('nombre_rol').value); 
            datos.append('rol_id', document.getElementById('rol_id').value); 

            fetch('roles', {
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                method: 'post', 
                body: datos
            }).then(res => res.json())
            .then(res => {

                if(res.sms=='ok')
                {

                    recargar_roles()

                    Swal.fire
                    (
                        'Agregado!',
                        'Agregaste con exito el rol.',
                        'success'
                    )
                    $('#datatable_roles').DataTable().ajax.reload();
                }
                else
                {
                    Swal.fire
                    ({
                        title:'Error!',
                        text: res.sms,
                        icon: 'error'
                    })
                }

            })
        })

    function recargar_roles()
    {
        [...document.getElementById('rol').children].map( e => e.remove())

        fetch('roles/consultadata', {
            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')}
        })
        .then(res => res.json())
        .then(res => {
            
            console.log(res.data);
        })
    }

    var buscar_id = 1;

    $(document).ready( function(){
            $('#datatable_permisos').DataTable({ 
                language: 
                { 
                    url: '/json/datatables_spanish.json' 
                },
                responsive:true,
                ajax: `permisos/${buscar_id}`
            });
        })
    </script>
@stop