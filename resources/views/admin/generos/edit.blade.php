@extends('adminlte::page')

@section('title', 'Crear Generos')

@section('content_header')
    <h1>Generos</h1>
@stop

@section('content')
    
    <form action="{{route('generos.update', $genero->id)}}" method="POST">
        @csrf
        @method('PUT')
        <label for="genero_nombre">Nombre</label>
        <input type="text" name="genero_nombre" id="genero_nombre" value="{{$genero->nombre}}">
        @error('genero_nombre')
            <br>
            <small>{{$message}}</small>
            <br>
        @enderror
        <br>
        <br>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>

@stop

@section('css')
    
@stop

@section('js')
    
@stop