@extends('adminlte::page')

@section('title', 'Crear Generos')

@section('content_header')
    <h1 class="text-center">Generos</h1>
@stop

@section('content')
    @error('genero_nombre')
    <x-adminlte-alert theme="danger" title="Error" dismissable>{{$message}}</x-adminlte-alert>
    @enderror
    
    <div class="card card-primary card-outline">
        <div class="card-body">
            <form action="{{route('generos.update', $genero->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <x-adminlte-input name="genero_nombre" label="Nombre" id="genero_nombre" minlength="3"
                        fgroup-class="col-md-6" value="{{$genero->nombre}}" disable-feedback/>
                </div>
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>
        </div>
    </div>
    

@stop

@section('css')
    
@stop

@section('js')
    
@stop