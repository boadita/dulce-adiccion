@extends('layouts.app')

@section('title', 'EMPLEADOS')

@section('content')
<h1>{{$empleados->nombre }}</h1>
<h1>{{ $empleados->nickname }}</h1>
<div class="show-center">
    <p>Celular: {{ $empleados->telefono }}</p>
    <p>Email: {{ $empleados->email }}</p>
    <p><img src="{{ asset('imagenes/empleados/'.$empleados->imagen) }}" alt="imagen" style="width: 500px;"></p>
    <a href="{{ route('empleados.index') }}" class="boton"><i class="fa fa-reply"></i></BR>Volver</a>
</div>
@endsection