@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    <h1 class="text-center">Permisos</h1>
@stop

@section('plugins.Select2', true)

@section('content')

<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="row mb-2">
            <button type="button" id="check_all" checked="false" class="btn btn-default mr-1" data-toggle1="tooltip" data-placement="top" title="Seleccionar todos"><img style="width: 30px; height:30px;" src="{{asset('iconos/checkall.png')}}" alt=""></button>
            <button type="button" id="guardar_permisos" class="btn btn-default" data-toggle1="tooltip" data-placement="top" title="Guardar Permisos"><img style="width: 30px; height:30px;" src="{{asset('iconos/guardar.png')}}" alt=""></button>
        </div>
        <div class="row">
            <button type="button" id="crear_rol" class="btn btn-primary col-sm-1 col-2" data-toggle="modal" data-target="#ModalRoles" data-toggle1="tooltip" data-placement="top" title="Agregar Roles"><i class="fas fa-user-tag">+</i></button>
            <div class="col-sm-11 col-10">
                <select class="form-input" onchange="cambio_rol();" name="rol" id="rol">
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
                    <th>Opcion</th>
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

        setTimeout(() => {
                document.getElementById('rol').focus();
        }, 700);

        document.getElementById('crear_rol').addEventListener('click', ()=>{

            $('#crear_rol').tooltip('hide');
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

        document.getElementById('check_all').addEventListener('click', ()=>{
            
            let total_columnas = $('#datatable_permisos').DataTable().rows().data().length;

            if(document.getElementById('check_all').getAttribute('checked') == "false")
            {
                for(let i=0; i< total_columnas; i++)
                {
                    $('#datatable_permisos').DataTable().cell(i,1).nodes()[0].children[0].checked = true;
                }
                document.getElementById('check_all').setAttribute('checked', "true");
            }
            else
            {
                for(let i=0; i< total_columnas; i++)
                {
                    $('#datatable_permisos').DataTable().cell(i,1).nodes()[0].children[0].checked = false;
                }
                document.getElementById('check_all').setAttribute('checked', "false");
            }
            
        })

        document.getElementById('guardar_permisos').addEventListener('click', ()=>{

            let total_columnas = $('#datatable_permisos').DataTable().rows().data().length;
            let array_enviar = [];
            let datos = new FormData();
            for(let i=0; i< total_columnas; i++)
            {
                if($('#datatable_permisos').DataTable().cell(i,1).nodes()[0].children[0].checked == true)
                {
                    array_enviar.push($('#datatable_permisos').DataTable().cell(i,0).data());
                }
            }

            datos.append('permisos', JSON.stringify(array_enviar))
            datos.append('rol_id', document.getElementById('rol').value)

            fetch('permisos/update', {
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                method: 'post',
                body: datos
            }).then(res => res.json())
            .then(res => {

                Swal.fire({
                    title: 'Guardado',
                    text: 'Permisos sincronizados con éxito',
                    icon: 'success'
                })
                cambio_rol()
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

    
        addEventListener('load', ()=>{
            $('#datatable_permisos').DataTable({ 
                language: 
                { 
                    url: '/json/datatables_spanish.json' 
                },
                responsive:true,
            }); 
        })    
        


    function cambio_rol()
    {
        let buscar_id = (document.getElementById('rol').value == "") ? 1 : document.getElementById('rol').value;
        $('#datatable_permisos').DataTable().destroy();

        $('#datatable_permisos').DataTable({ 
            language: 
            { 
                url: '/json/datatables_spanish.json' 
            },
            responsive:true,
            ajax: `permisos/${buscar_id}`
        });
    }
    </script>
@stop