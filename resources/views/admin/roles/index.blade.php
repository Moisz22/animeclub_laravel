@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1 class="text-center">Roles</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-body">
            <button type="button" id="crear_rol" class="btn btn-default" data-toggle="modal" data-target="#modalRoles" data-toggle1="tooltip" data-placement="top" title="Agregar Roles"><img style="width: 30px; height:30px;" src="{{asset('iconos/agregar.png')}}" alt=""></button>
            <button type="button" id="check_all" checked="false" class="btn btn-default" data-toggle1="tooltip" data-placement="top" title="Seleccionar todos"><img style="width: 30px; height:30px;" src="{{asset('iconos/checkall.png')}}" alt=""></button>
            <button type="button" id="eliminar_lotes" class="btn btn-default" data-toggle1="tooltip" data-placement="top" title="Eliminar"><img style="width: 30px; height:30px;" src="{{asset('iconos/delete.png')}}" alt=""></button>
            <br>
            <br>
            {{-- tabla con roles --}}
            {{-- <livewire:tabla-roles/> --}}
            <table id="datatable_roles" class="table table-bordered table-striped no-wrap" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width:2%"></th>
                        <th>Acciones</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@stop
@include('modals.modalRoles')
@section('js')
    <script>

        addEventListener('load', ()=>{
            document.getElementById('crear_rol').focus();
        })  

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

        document.getElementById('check_all').addEventListener('click', ()=>{
            
            let total_columnas = $('#datatable_roles').DataTable().rows().data().length;

            if(document.getElementById('check_all').getAttribute('checked') == "false")
            {
                for(let i=0; i< total_columnas; i++)
                {
                    $('#datatable_roles').DataTable().cell(i,0).nodes()[0].children[0].checked = true;
                }
                document.getElementById('check_all').setAttribute('checked', "true");
            }
            else
            {
                for(let i=0; i< total_columnas; i++)
                {
                    $('#datatable_roles').DataTable().cell(i,0).nodes()[0].children[0].checked = false;
                }
                document.getElementById('check_all').setAttribute('checked', "false");
            }
            
        })


        document.getElementById('eliminar_lotes').addEventListener('click', ()=>{

            let total_columnas = $('#datatable_roles').DataTable().rows().data().length;
            let array_enviar = [];
            let array_posiciones = [];
            let datos = new FormData();
            for(let i=0; i< total_columnas; i++)
            {
                if($('#datatable_roles').DataTable().cell(i,0).nodes()[0].children[0].checked == true)
                {
                    array_enviar.push($('#datatable_roles').DataTable().cell(i,0).nodes()[0].children[0].getAttribute('value'));
                    array_posiciones.push(i+1);
                }
            }

            if(array_enviar.length == 0)
            {
                Swal.fire
                ({
                    title: 'Error!',
                    text: 'No haz seleccionado ningun registro.',
                    icon: 'error',
                    timer: 800,
                    showConfirmButton: false
                })
                return;
            }

            datos.append('ids', JSON.stringify(array_enviar))
            Swal.fire({
                title: 'Está seguro?',
                text: "Eliminar registros: "+ array_posiciones,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, borrar!',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                if (result.isConfirmed)
                {
                    fetch(`roles/eliminar_mas`, {
                        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                        method: 'post', 
                        body: datos  
                    })
                    .then(res => res.json())
                    .then(res => {
                        if(res.sms == 'ok')
                        {
                            Swal.fire
                            (
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            $('#datatable_roles').DataTable().ajax.reload();
                        }
                        else
                        {
                            Swal.fire({
                                title:'Error!',
                                text: res.sms,
                                icon: 'error'
                            })
                            $('#datatable_roles').DataTable().ajax.reload();
                        }
                    })
                    
                }
            })
        })


        document.getElementById('guardar_rol').addEventListener('click', ()=>{

            let datos = new FormData();
            let id = document.getElementById('rol_id').value;
            datos.append('nombre', document.getElementById('nombre_rol').value); 
            datos.append('rol_id', document.getElementById('rol_id').value); 

            if(document.getElementById('guardar_rol').getAttribute('edicion') == "true")
            {
                fetch(`roles/update/${id}`, 
                {
                    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                    method: 'post',
                    body: datos
                }).then(res => res.json())
                .then(res => {
                    if(res.sms=='ok')
                    {
                        Swal.fire
                        (
                            'Actualizado!',
                            'Actualizaste con exito el rol.',
                            'success'
                        )
                        $('#datatable_roles').DataTable().ajax.reload();
                        document.getElementById('rol_id').value = ""
                    }
                    else
                    {
                        Swal.fire({
                            title:'Error!',
                            text: res.sms,
                            icon: 'error'
                        })
                    }
                })
                return;
            }

            fetch('roles', {
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                method: 'post', 
                body: datos
            }).then(res => res.json())
            .then(res => {

                if(res.sms=='ok')
                {
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

        function mostrar(id)
        {
            document.getElementById('guardar_rol').classList.remove('btn-success');
            document.getElementById('guardar_rol').classList.add('btn-warning');
            document.getElementById('guardar_rol').setAttribute('edicion', 'true');
            document.getElementById('guardar_rol').textContent = "Actualizar";
            fetch(`roles/${id}`, 
            {
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')}
            })
            .then(res => res.json())
            .then(res => { 

                document.getElementById('nombre_rol').value = res.data.name; 
                document.getElementById('rol_id').value = res.data.id; 

            })

            setTimeout(() => {
                document.getElementById('nombre_rol').focus();
            }, 700);
        }

        function eliminar(nombre)
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
                    fetch(`roles/${nombre}`, {
                        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(res => {
                        if(res.sms == 'ok')
                        {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            $('#datatable_roles').DataTable().ajax.reload();
                        }
                        else
                        {
                            Swal.fire(
                                'Error!',
                                res.sms,
                                'error'
                            )
                        }
                    })
                    
                }
            })
        }


        $(document).ready( function(){
            $('#datatable_roles').DataTable({ 
                language: 
                { 
                    url: '/json/datatables_spanish.json' 
                },
                responsive:true,
                ajax: 'roles/consultar'
            });
        })
    </script>
@stop