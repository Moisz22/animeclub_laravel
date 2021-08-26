@extends('adminlte::page')

@section('title', 'Animes')

@section('content_header')
    <h1>Animes</h1>
@stop

@section('content')
    
    @foreach ($animes as $anime)
        {{$anime->nombre}}
    @endforeach

@stop

@section('css')
    
@stop

@section('js')
    
@stop