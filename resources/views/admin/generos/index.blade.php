@extends('adminlte::page')

@section('title', 'Generos')

@section('content_header')
    <h1>Generos</h1>
@stop

@section('content')
    <a class="btn btn-primary" href="{{route('generos.create')}}">Crear</a>
    <br>
    <br>
    <div class="col-sm-12">
    <table id="myTable" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($generos as $genero)
            <tr>
                <td>{{$genero->id}}</td>
                <td>{{$genero->nombre}}</td>
                <td><a href="{{route('generos.edit', $genero->id)}}" class="btn btn-success"><i class="fas fa-edit"></i></a></td>
                <td>
                    <form action="{{route('generos.destroy', $genero->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@stop

@section('css')
    
@stop

@section('js')
    <script>
    $(document).ready(function() {
    let table = $('#myTable').DataTable( {
        responsive: true,
        "language": {
            "url": "/json/datatables_spanish.json"
        }
    } );
 
    new $.fn.dataTable.FixedHeader( table );
} );
    </script>
@stop