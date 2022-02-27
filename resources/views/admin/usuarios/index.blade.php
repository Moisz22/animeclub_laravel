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
            <button type="button" id="crear_usuario" class="btn btn-default" data-toggle="modal" data-target="#modalUsuarios" data-toggle1="tooltip" data-placement="top" title="Agregar Usuarios"><img style="width: 30px; height:30px;" src="{{asset('iconos/adduser.png')}}" alt=""></button>
            <button type="button" id="check_all" checked="false" class="btn btn-default" data-toggle1="tooltip" data-placement="top" title="Seleccionar todos"><img style="width: 30px; height:30px;" src="{{asset('iconos/checkall.png')}}" alt=""></button>
            <button type="button" id="eliminar_lotes" class="btn btn-default" data-toggle1="tooltip" data-placement="top" title="Eliminar"><img style="width: 30px; height:30px;" src="{{asset('iconos/delete.png')}}" alt=""></button>
            <br>
            <br>
            <table id="datatable_usuarios" class="table table-bordered table-striped no-wrap" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width:2%"></th>
                        <th>Acciones</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @include('modals.modalUsuarios')
    
    @section('js')
        <script>
            $(document).ready( function(){
                $('#rol_id').select2({
                    width: "100%",
                    dropdownParent: $('#modalUsuarios')
                });
            })


            document.getElementById('crear_usuario').addEventListener('click', ()=>{

                document.getElementById('guardar_usuario').classList.remove('btn-warning');
                document.getElementById('guardar_usuario').classList.add('btn-success');
                document.getElementById('guardar_usuario').setAttribute('edicion', 'false');
                document.getElementById('guardar_usuario').textContent = "Guardar";

                document.getElementById('nombre_usuario').value = ""; 
                document.getElementById('email_usuario').value = null; 
                document.getElementById('rol_id').selectedIndex = 0;
                $('#rol_id').select2({width: "100%", dropdownParent: $('#modalUsuarios')}) 
                setTimeout(() => {
                    document.getElementById('nombre_usuario').focus();
                }, 700);
            })


            document.getElementById('check_all').addEventListener('click', ()=>{
                
                let total_columnas = $('#datatable_usuarios').DataTable().rows().data().length;

                if(document.getElementById('check_all').getAttribute('checked') == "false")
                {
                    for(let i=0; i< total_columnas; i++)
                    {
                        $('#datatable_usuarios').DataTable().cell(i,0).nodes()[0].children[0].checked = true;
                    }
                    document.getElementById('check_all').setAttribute('checked', "true");
                }
                else
                {
                    for(let i=0; i< total_columnas; i++)
                    {
                        $('#datatable_usuarios').DataTable().cell(i,0).nodes()[0].children[0].checked = false;
                    }
                    document.getElementById('check_all').setAttribute('checked', "false");
                }
                
            })


            document.getElementById('eliminar_lotes').addEventListener('click', ()=>{

                let total_columnas = $('#datatable_usuarios').DataTable().rows().data().length;
                let array_enviar = [];
                let array_posiciones = [];
                let datos = new FormData();
                for(let i=0; i< total_columnas; i++)
                {
                    if($('#datatable_usuarios').DataTable().cell(i,0).nodes()[0].children[0].checked == true)
                    {
                        array_enviar.push($('#datatable_usuarios').DataTable().cell(i,0).nodes()[0].children[0].getAttribute('value'));
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
                        fetch(`usuarios/eliminar_mas`, {
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
            })


            document.getElementById('guardar_usuario').addEventListener('click', ()=>{

                let datos = new FormData();
                let id = document.getElementById('user_id').value;
                datos.append('nombre', document.getElementById('nombre_usuario').value); 
                datos.append('email', document.getElementById('email_usuario').value); 
                datos.append('rol', document.getElementById('rol_id').value); 

                if(document.getElementById('guardar_usuario').getAttribute('edicion') == "true")
                {
                    fetch(`usuarios/update/${id}`, 
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
                                'Actualizaste con exito al usuario.',
                                'success'
                            )
                            $('#datatable_usuarios').DataTable().ajax.reload();
                            document.getElementById('user_id').value = "";
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

                fetch('usuarios', {
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
                            'Agregaste con exito al usuario.',
                            'success'
                        )
                        $('#datatable_usuarios').DataTable().ajax.reload();
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
                document.getElementById('guardar_usuario').classList.remove('btn-success');
                document.getElementById('guardar_usuario').classList.add('btn-warning');
                document.getElementById('guardar_usuario').setAttribute('edicion', 'true');
                document.getElementById('guardar_usuario').textContent = "Actualizar";
                fetch(`usuarios/${id}`, 
                {
                    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')}
                })
                .then(res => res.json())
                .then(res => { 

                    document.getElementById('nombre_usuario').value = res.data.name; 
                    document.getElementById('email_usuario').value = res.data.email; 
                    document.getElementById('user_id').value = id; 
                    document.getElementById('rol_id').value = res.data.rol_id;
                    $('#rol_id').select2() 

                })

                setTimeout(() => {
                    document.getElementById('nombre_usuario').focus();
                }, 700);
            }


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
                        fetch(`usuarios/${id}`, {
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
                    ajax: 'usuarios/consultar'
                });
            })

        </script>
    @stop
@stop
