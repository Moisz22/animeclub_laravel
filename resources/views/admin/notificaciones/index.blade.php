@extends('adminlte::page')

@section('title', 'Notificaciones')

@section('css')
    <style>
        tbody>tr:hover
        {
            cursor: pointer;
            background: rgb(206, 223, 228);
        }
    </style>
@stop

@section('content_header')
    
@stop

@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-none col-sm-2"></div>
            <div class="col-12 col-sm-8">
                <br>
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h2 class="text-center"><b>Notificaciones</b></h2>
                        <br>
                        <div class="row">
                            <div class="col-3 col-sm-8"></div>
                            <div id="marcar_todas" class="col-9 col-sm-4"><button class="btn btn-outline-secondary">Marcar todas como leídas</button></div>
                        </div>
                        <br>
                        {{-- tabla con notificaciones --}}
                        <button id="mostrar_todas" class="btn btn-outline-primary">Todas</button>
                        <button id="mostrar_pendientes" class="btn btn-outline-primary">No leídas</button>
                        <table id="datatable_notificaciones" class="table no-wrap" style="width: 100%">
                            <thead class="d-none">
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Accion</th>
                                    <th>tabla</th>
                                    <th>creada</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="container" >
                            <div class="row">
                                <div class="col" id="campana">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-none col-sm-2"></div>
        </div>
    </div>
    
@stop
@section('js')
    <script>

        $('#datatable_notificaciones').DataTable({
            searching: false,
            paging: false,
            ordering: false,
            columnDefs: [
                {
                    targets: [0],
                    visible: false,
                },
                {
                    targets: [1],
                    visible: false,
                },
                {
                    targets: [3],
                    visible: false,
                },
                {
                    targets: [4],
                    visible: false,
                },
            ],  
            info:false,
            language: 
            { 
                url: '/json/datatables_spanish.json' 
            },
            responsive:true,
            ajax: '../notifications/consultadata'
        });
        
        document.getElementById('marcar_todas').addEventListener('click', ()=>{
            
            eliminarcampana();
            /* let registros = $('#datatable_notificaciones').DataTable().data().length */

            fetch('../notifications/marcar_todas')
            .then(res => res.json())
            .then(res => {

                if(res.sms == 'ok')
                {
                    /* for (let i = 0; i < registros ; i++)
                    {
                        $('#datatable_notificaciones').DataTable().cell(i,5).data('');
                    }

                    $('#datatable_notificaciones').DataTable().draw(); */
                    $('#datatable_notificaciones').DataTable().ajax.reload();
                    
                }

            })

        })

        document.getElementById('mostrar_pendientes').addEventListener('click', ()=>{

            eliminarcampana();

            let registros = $('#datatable_notificaciones').DataTable().data().length
            let pendientes = false;
            for (let i = 0; i < registros ; i++)
            {
                if($('#datatable_notificaciones').DataTable().cell(i, 5).node().children.length == 0)
                {
                    $('#datatable_notificaciones').DataTable().row(i).node().classList.add('d-none');
                    
                }
                else
                {
                    pendientes = true;
                }
                
            }

            $('#datatable_notificaciones').DataTable().draw();

            if(!pendientes)
            {
                
                let imagen = document.createElement('img');
                imagen.src = `{{asset('iconos/campana.png')}}`;
                imagen.style.width = "50%";
                imagen.style.height = "70%";
                imagen.style.display = "block";
                imagen.style.margin = "auto";

                let p = document.createElement('p');
                p.textContent = 'No tienes notificaciones nuevas';
                p.classList.add("mt-3","text-center");

                document.getElementById('campana').append(imagen);
                document.getElementById('campana').append(p);
            }
            /* else
            {
                document.getElementById('campana').children.length > 0
            } */

        })

        function eliminarcampana()
        {
            if(document.getElementById('campana').children.length > 0)
            {
                [...document.getElementById('campana').children].map( e => e.remove());
            }    
        }

        document.getElementById('mostrar_todas').addEventListener('click', ()=>{

            $('#datatable_notificaciones').DataTable().ajax.reload();
            /* let registros = $('#datatable_notificaciones').DataTable().data().length

            for (let i = 0; i < registros ; i++)
            {
                $('#datatable_notificaciones').DataTable().row(i).node().classList.remove('d-none');
            }

            $('#datatable_notificaciones').DataTable().draw(); */

        })

    </script>
    
@stop