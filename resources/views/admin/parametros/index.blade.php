@extends('adminlte::page')

@section('title', 'Parametros')

@section('content_header')
    <h1 class="text-center">Parametros</h1>
@stop

@section('content')

    <br>
    <br>
    {{-- Parametros --}}
    <livewire:parametros/>

@stop

@section('js')
    @livewireScripts
@stop