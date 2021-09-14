@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    <h1 class="text-center">Permisos</h1>
@stop

@section('content')

    <br>
    <livewire:lista-permisos>

@stop

@section('js')
    @livewireScripts
@stop