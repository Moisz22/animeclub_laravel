@extends('adminlte::page')

@section('title', 'Notificaciones')

@section('css')
    <style>
        tbody>tr:hover
        {
            cursor: pointer;
            background: rgb(206, 223, 228);
        }

        .eye
        {
            position:absolute;
            height:20px;
            width:20px;
            margin-top: 60px;
            margin-right: 10px;
            top: -15px;
            left : 40px;
            z-index: 1;
        }

        .heaven
        {
            /* position:absolute; */
            height:60px;
            width:60px;
            z-index: -1;
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
                        <div class="clearfix">
                            <div id="marcar_todas" class="float-right"><button class="btn btn-outline-secondary">Marcar todas como leídas</button></div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-3 col-sm-7"></div>
                            <div id="marcar_todas" class="col-9 col-sm-5"><button class="btn btn-outline-secondary">Marcar todas como leídas</button></div>
                        </div> --}}
                        <br>
                        {{-- tabla con notificaciones --}}
                        <button id="mostrar_todas" class="btn btn-primary">Todas</button>
                        <button id="mostrar_pendientes" class="btn btn-outline-primary">No leídas</button>
                        <table id="datatable_notificaciones" class="table no-wrap" style="width: 100%">
                            <thead class="d-none">
                                <tr>
                                    <th>ID</th>
                                    <th>Método</th>
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

    <div class="modal fade" id="modalNotificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Notificación</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tabla_notificacion_completa" class="table table-bordered table-striped no-wrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Método</th>
                                        <th>User</th>
                                        <th>Accion</th>
                                        <th>tabla</th>
                                        <th>creada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
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
                    targets: [4],
                    visible: false,
                },
                {
                    targets: [5],
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

        $('#tabla_notificacion_completa').DataTable({
            searching: false,
            paging: false,
            ordering: false,
            responsive: true,
            info: false,
            language: 
            { 
                url: '/json/datatables_spanish.json' 
            },
            columnDefs: [
                {
                    targets: [5],
                    visible: false,
                },
            ]
        })
        
        document.getElementById('marcar_todas').addEventListener('click', ()=>{
            
            document.getElementById('mostrar_pendientes').classList.add('btn-outline-primary');
            document.getElementById('mostrar_pendientes').classList.remove('btn-primary');
            document.getElementById('mostrar_todas').classList.add('btn-primary');
            document.getElementById('mostrar_todas').classList.remove('btn-outline-primary');

            eliminarcampana();

            fetch('../notifications/marcar_todas')
            .then(res => res.json())
            .then(res => {

                if(res.sms == 'ok')
                {
                    $('#datatable_notificaciones').DataTable().ajax.reload();
                    
                }

            })

        })

        document.getElementById('mostrar_pendientes').addEventListener('click', ()=>{

            eliminarcampana();

            document.getElementById('mostrar_pendientes').classList.remove('btn-outline-primary');
            document.getElementById('mostrar_pendientes').classList.add('btn-primary');
            document.getElementById('mostrar_todas').classList.add('btn-outline-primary');
            document.getElementById('mostrar_todas').classList.remove('btn-primary');

            let registros = $('#datatable_notificaciones').DataTable().data().length
            let pendientes = false;
            for (let i = 0; i < registros ; i++)
            {
                if($('#datatable_notificaciones').DataTable().cell(i, 6).node().children.length == 0)
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

        })

        function eliminarcampana()
        {
            if(document.getElementById('campana').children.length > 0)
            {
                [...document.getElementById('campana').children].map( e => e.remove());
            }    
        }

        document.getElementById('mostrar_todas').addEventListener('click', ()=>{

            document.getElementById('mostrar_pendientes').classList.add('btn-outline-primary');
            document.getElementById('mostrar_pendientes').classList.remove('btn-primary');
            document.getElementById('mostrar_todas').classList.add('btn-primary');
            document.getElementById('mostrar_todas').classList.remove('btn-outline-primary');

            eliminarcampana();
            $('#datatable_notificaciones').DataTable().ajax.reload();

        })

        $('#datatable_notificaciones tbody').on('click','tr', async function (e)
        {
            document.body.style.cursor = 'progress';
            let id_tabla = $('#datatable_notificaciones').DataTable().row( this ).data()[0];

            $('#tabla_notificacion_completa').DataTable().clear().draw();
            await fetch(`../notifications/marcarnotificacion/${id_tabla}`)
            .then(res => res.json() )
            .then(res => {
                if(res.sms == 'ok')
                {
                    $('#datatable_notificaciones').DataTable().ajax.reload();
                    $('#tabla_notificacion_completa').DataTable().row.add($('#datatable_notificaciones').DataTable().row( this ).data()).draw();
                    $('#modalNotificacion').modal('show');
                }
            })

            document.body.style.cursor = 'default';
            
        })

    </script>
    
@stop