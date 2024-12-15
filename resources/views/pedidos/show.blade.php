@extends('layouts.app')

@section('title', 'PEDIDOS')

@section('content')
<h1>COMPROBANTE</h1></br>
<div style="text-align: center;">
    <p>NOMBRE: {{ $pedido->clientes->nombre }}</p>
    <p>DIRECCION: {{ $pedido->direccion }}</p>
    <p>NIT: {{ $pedido->clientes->NIT }}</p>
    <p>FECHA DE PEDIDO: {{ $pedido->fecha_pedido }}</p>
    <p>FECHA DE ENTREGA: {{ $pedido->fecha_entrega }}</p>
</div>
</br>
<h2>DETALLE:</h2>
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
    <div style="text-align: center; font-size:20px;"></BR> TOTAL: {{$pedido->monto_total}} Bs</div>
    <div class="boton-container">
        <a href="{{ route('pedidos.pdf', $pedido->id) }}" class="boton"><i class="fas fa-file-pdf"></i></br>PDF</a>
    </div>
</div>
@endsection