@extends('adminlte::page')

@section('title', 'Generos')

@section('content_header')
    <h1 class="text-center"><b>Generos</b></h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-body">
            <button type="button" id="crear_genero" class="btn btn-default" data-toggle="modal" data-target="#modalGeneros" data-toggle1="tooltip" data-placement="top" title="Agregar Generos"><img style="width: 30px; height:30px;" src="{{asset('iconos/agregar.png')}}"></button>
            <button type="button" id="check_all" checked="false" class="btn btn-default" data-toggle1="tooltip" data-placement="top" title="Seleccionar todos"><img style="width: 30px; height:30px;" src="{{asset('iconos/checkall.png')}}"></button>
            <button type="button" id="eliminar_lotes" class="btn btn-default" data-toggle1="tooltip" data-placement="top" title="Eliminar"><img style="width: 30px; height:30px;" src="{{asset('iconos/delete.png')}}"></button>
            <br>
            <br>
            {{-- tabla con generos --}}
            <table id="datatable_generos" class="table table-bordered table-striped no-wrap" style="width: 100%">
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
@include('modals.modalGeneros')
@section('js')
    <script>

        addEventListener('load', ()=>{
            document.getElementById('crear_genero').focus();
        })  

        document.getElementById('crear_genero').addEventListener('click', ()=>{

            $('#crear_genero').tooltip('hide');
            document.getElementById('guardar_genero').classList.remove('btn-warning');
            document.getElementById('guardar_genero').classList.add('btn-success');
            document.getElementById('guardar_genero').setAttribute('edicion', 'false');
            document.getElementById('guardar_genero').textContent = "Guardar";

            document.getElementById('nombre_genero').value = ""; 
            document.getElementById('genero_id').selectedIndex = 0; 
            setTimeout(() => {
                document.getElementById('nombre_genero').focus();
            }, 700);
        })

        document.getElementById('check_all').addEventListener('click', ()=>{
            
            let total_columnas = $('#datatable_generos').DataTable().rows().data().length;

            if(document.getElementById('check_all').getAttribute('checked') == "false")
            {
                for(let i=0; i< total_columnas; i++)
                {
                    $('#datatable_generos').DataTable().cell(i,0).nodes()[0].children[0].checked = true;
                }
                document.getElementById('check_all').setAttribute('checked', "true");
            }
            else
            {
                for(let i=0; i< total_columnas; i++)
                {
                    $('#datatable_generos').DataTable().cell(i,0).nodes()[0].children[0].checked = false;
                }
                document.getElementById('check_all').setAttribute('checked', "false");
            }
            
        })


        document.getElementById('eliminar_lotes').addEventListener('click', ()=>{

            let total_columnas = $('#datatable_generos').DataTable().rows().data().length;
            let array_enviar = [];
            let array_posiciones = [];
            let datos = new FormData();
            for(let i=0; i< total_columnas; i++)
            {
                if($('#datatable_generos').DataTable().cell(i,0).nodes()[0].children[0].checked == true)
                {
                    array_enviar.push($('#datatable_generos').DataTable().cell(i,0).nodes()[0].children[0].getAttribute('value'));
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
                    fetch(`generos/eliminar_mas`, {
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
                                'Borrado!',
                                'Los generos han sido eliminados con éxito.',
                                'success'
                            )
                            $('#datatable_generos').DataTable().ajax.reload();
                        }
                        else
                        {
                            Swal.fire({
                                title:'Error!',
                                text: res.sms,
                                icon: 'error'
                            })
                            $('#datatable_generos').DataTable().ajax.reload();
                        }
                    })
                    
                }
            })
        })


        document.getElementById('guardar_genero').addEventListener('click', ()=>{

            let datos = new FormData();
            let id = document.getElementById('genero_id').value;
            datos.append('nombre', document.getElementById('nombre_genero').value); 
            datos.append('genero_id', document.getElementById('genero_id').value); 

            if(document.getElementById('guardar_genero').getAttribute('edicion') == "true")
            {
                fetch(`generos/update/${id}`, 
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
                            'Actualizaste con éxito el genero.',
                            'success'
                        )
                        $('#datatable_generos').DataTable().ajax.reload();
                        document.getElementById('genero_id').value = ""
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

            fetch('generos', {
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
                        'Agregaste con exito el genero.',
                        'success'
                    )
                    $('#datatable_generos').DataTable().ajax.reload();
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
            document.getElementById('guardar_genero').classList.remove('btn-success');
            document.getElementById('guardar_genero').classList.add('btn-warning');
            document.getElementById('guardar_genero').setAttribute('edicion', 'true');
            document.getElementById('guardar_genero').textContent = "Actualizar";
            fetch(`generos/${id}`, 
            {
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')}
            })
            .then(res => res.json())
            .then(res => { 

                document.getElementById('nombre_genero').value = res.data.name; 
                document.getElementById('genero_id').value = res.data.id; 

            })

            setTimeout(() => {
                document.getElementById('nombre_genero').focus();
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
                    fetch(`generos/${id}`, {
                        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(res => {
                        if(res.sms == 'ok')
                        {
                            Swal.fire(
                                'Borrado!',
                                'El genero ha sido eliminado con éxito.',
                                'success'
                            )
                            $('#datatable_generos').DataTable().ajax.reload();
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
            $('#datatable_generos').DataTable({ 
                language: 
                { 
                    url: '/json/datatables_spanish.json' 
                },
                responsive:true,
                ajax: 'generos/consultar'
            });
        })
    </script>
@stop