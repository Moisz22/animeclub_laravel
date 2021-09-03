@extends('adminlte::page')

@section('title', 'Generos')

@section('content_header')
    <h1 class="text-center">Generos</h1>
@stop

@section('content')
    {{-- mensaje de exito al guardar genero --}}
    {{-- @if (session('message'))
        <x-adminlte-alert theme="success" title="Exito" dismissable>{{session('message')}}</x-adminlte-alert>  
    @endif --}}
    {{-- errores de formulario --}}
    @error('genero_nombre')
        <x-adminlte-alert theme="danger" title="Error" dismissable>{{$message}}</x-adminlte-alert>
    @enderror

    <br>
    <br>
    {{-- tabla con generos --}}
    <livewire:tabla-generos/>

@stop


@section('js')
    @livewireScripts
    {{-- <script src="{{asset('js/app.js')}}"></script> --}}
    {{-- <script>Swal.fire(
        'Good job!',
        'You clicked the button!',
        'success'
    )</script> --}}
@stop