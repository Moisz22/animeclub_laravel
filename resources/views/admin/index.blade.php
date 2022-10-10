@extends('adminlte::page')

@section('title', 'AnimeClub')

@section('content_header')
    <h1>Dislesoft</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <x-adminlte-small-box title="{{$cantidadUsuarios}}" text="Usuarios Registrados" icon="fas fa-user-plus" theme="warning" url="{{url('admin/usuarios')}}" url-text="Ver todos los usuarios"/>
            </div>
            <div class="col-md-4">
                <x-adminlte-small-box title="{{$cantidadRoles}}" text="Roles Registrados" icon="fas fa-user-tag" theme="primary" url="{{url('admin/roles')}}" url-text="Ver todos los roles"/>
            </div>
            <div class="col-md-4">
                <x-adminlte-small-box title="{{$cantidadPermisos}}" text="Permisos Registrados" icon="fas fa-user-shield" theme="success" url="{{url('admin/permisos')}}" url-text="Ver todos los permisos"/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-adminlte-card title="Cantidad de Usuarios" theme="primary" icon="fas fa-lg fa-users" removable collapsible>
                    <canvas id="grafico_tipos"></canvas>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card title="Usuarios añadidos recientemente" theme="primary" icon="fas fa-lg fa-user" removable collapsible>
                    {{-- <div class="table-responsive"> --}}
                        <table id="usuarios" class="table table-bordered striped">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ultimos_usuarios as $usuario)
                                    <tr>
                                        <td>{{$usuario->name}}</td>
                                        <td>{{$usuario->created_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{-- </div> --}}
                </x-adminlte-card>
            </div>
        </div>
    </div>
    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>

        $('#usuarios').DataTable({ 
                    searching: false,
                    paging: false,
                    info: false,
                    language: 
                    { 
                        url: '/json/datatables_spanish.json' 
                    },
                    responsive:true,
                    "order": []
                });

        let arreglo_roles = @json($arregloRoles);
        const ctx = document.getElementById('grafico_tipos')
        const data = {
            labels: arreglo_roles,
            datasets: [{
                label: 'My First Dataset',
                data: @json($arregloCantidadRoles),
                backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };

        const config = new Chart(ctx,{
            type: 'doughnut',
            data: data,
        });
    </script>
@stop