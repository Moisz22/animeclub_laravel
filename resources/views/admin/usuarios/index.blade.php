@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1 class="text-center">Usuarios</h1>
@stop

@section('content')

    <br>
    <br>
    {{-- tabla con usuarios --}}
    <livewire:tabla-usuarios/>
@stop

@section('js')
    @livewireScripts
@stop