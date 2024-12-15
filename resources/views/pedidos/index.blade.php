@extends('layouts.app')

@section('title', 'PEDIDOS')

@section('content')
<h1>INGRESE NIT O CI</h1>
<div class="container-categoria">
    <form action="{{ route('pedidos.create') }}" method="GET">
        @csrf
        <input type="text" name="ci_nit" id="ci_nit" required></BR>
        <center><button type="submit" class="boton"><i class="fa fa-door-open"></i></BR>INGRESAR</button></center>
    </form>
</div>
@endsection