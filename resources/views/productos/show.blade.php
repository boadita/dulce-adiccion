@extends('layouts.app')

@section('title', 'PRODUCTOS')

@section('content')
<h1>{{$productos->descripcion }}</h1>
<div class="show-center">
    <p>Categoria: {{ $productos->categorias->nombre }}</p>
    <p>Precio: {{ $productos->precio }} Bs</p>
    <p>Disponible: @if ($productos->disponible == 0)
        <i class="fa fa-times"></i>
        @else
        <i class="fa fa-check"></i>
        @endif
    </p>
    <p><img src="{{ asset('imagenes/productos/'.$productos->imagen) }}" alt="imagen" style="width: 500px;"></p>
    <a href="{{ route('productos.index') }}" class="boton"><i class="fa fa-reply"></i></BR>Volver</a>
</div>
@endsection