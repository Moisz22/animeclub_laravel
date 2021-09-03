@extends('adminlte::page')

@section('title', 'Animes')

@section('content_header')
    <h1>Animes</h1>
@stop

@section('css')
    <link href="{{asset('css/animes.css')}}" rel="stylesheet">
@stop

@section('content')
    
    <div class="row">
    @foreach($animes as $anime)
        <div class="col-4 col-sm-2">
            <div>	
                <a href="single_anime?id={{$anime->id}}">
                @if(isset($anime->image->url)/*  && file_exists("/img/{{$anime->image->url}}") */)
                    <img class="centrar_imagen animes_lista" src="{{$anime->image->url}}">
                @else
                    <img class="centrar_imagen animes_lista" src="{{asset('img/logo.P86')}}">
                @endif
                    <p class="text-center text-capitalize">{{$anime->nombre}}</p>
                </a>
            </div>
        </div>
    @endforeach
    </div>

@stop

@section('js')
    
@stop