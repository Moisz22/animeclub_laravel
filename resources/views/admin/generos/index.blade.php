@extends('adminlte::page')

@section('title', 'Generos')

@section('content_header')
    <h1 class="text-center">Generos</h1>
@stop

@section('content')

    <br>
    <br>
    {{-- tabla con generos --}}
    <livewire:tabla-generos/>

@stop

@section('js')
    @livewireScripts
@stop