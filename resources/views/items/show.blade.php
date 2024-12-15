@extends('layouts.app')

@section('title', 'PEDIDOS')

@section('content')
<h1>DETALLE DE PEDIDO:</h1>
<div style="text-align: center;">
    <p>CLIENTE: {{ $pedidos->clientes->nombre }}</p>
    <p>FECHA DE PEDIDO: {{ $pedidos->fecha_pedido }}</p>
    <p>FECHA DE ENTREGA: {{ $pedidos->fecha_entrega }}</p>
    <p>DIRECCION: {{ $pedidos->direccion }}</p>
    </BR>
    <div class="table-wrapper">
        <table class="table-condensed" id='tabla'>
            <tr>
                <th>PRODUCTO</th>
                <th>PRECIO UNITARIO</th>
                <th>CANTIDAD</th>
                <th>PRECIO TOTAL</th>
            </tr>
            @foreach ($items as $it)
            <tr>
                <td>{{ $it->productos->descripcion }}</td>
                <td>{{ $it->productos->precio }} Bs</td>
                <td>{{ $it->cantidad }}</td>
                <td>{{ $it->precio_cant }} Bs</td>
            </tr>
            @endforeach
        </table>
        </BR>
        <div style="text-align: center; font-size:20px;"></BR>MONTO TOTAL: {{$pedidos->monto_total}} Bs</div>
        <div class="boton-container">
        <a href="{{ route('pedidos.historial') }}" class="boton"><i class="fa fa-reply"></i></BR>Volver</a>
        </div>
    </div>
</div>
@endsection