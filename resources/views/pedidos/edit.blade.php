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
    </div>
</div>
</BR>
<form action="{{ route('pedidos.update', $pedidos->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div style="text-align: center;">
        <label for="estado">Estado del pedido:</label>
        <select id="estado" name="estado">
            @if ($pedidos->estado == 'Pendiente')
            <option class="form-control" value="{{$pedidos->estado}}">{{$pedidos->estado}}</option>
            <option class="form-control" value="Procesando">Procesando</option>
            <option class="form-control" value="Entregado">Entregado</option>
            <option class="form-control" value="Cancelado">Cancelado</option>
            @elseif($pedidos->estado == 'Procesando')
            <option class="form-control" value="{{$pedidos->estado}}">{{$pedidos->estado}}</option>
            <option class="form-control" value="Entregado">Entregado</option>
            <option class="form-control" value="Cancelado">Cancelado</option>
            @elseif($pedidos->estado == 'Entregado')
            <option class="form-control" value="{{$pedidos->estado}}">{{$pedidos->estado}}</option>
            <option class="form-control" value="Cancelado">Cancelado</option>
            @else
            <option class="form-control" value="{{$pedidos->estado}}">{{$pedidos->estado}}</option>
            @endif
        </select>
        <br><br>
        <label for="pago">Estado de pago:</label>
        <select id="pago" name="pago">
            @if ($pedidos->pago == 'Pendiente')
            <option class="form-control" value="{{$pedidos->pago}}">{{$pedidos->pago}}</option>
            <option class="form-control" value="Pagado">Pagado</option>
            @else
            <option class="form-control" value="{{$pedidos->pago}}">{{$pedidos->pago}}</option>
            @endif
        </select>
        <br><br>
    </div>
    <center><button type="submit" class="boton"><i class="fa-solid fa-file-arrow-down"></i></br>GUARDAR</button></center>
</form>
@endsection