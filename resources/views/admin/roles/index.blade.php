@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1 class="text-center">Roles</h1>
@stop

@section('content')

    <br>
    <br>
    {{-- tabla con roles --}}
    <livewire:tabla-roles/>

@stop

@section('js')
    @livewireScripts
@stop