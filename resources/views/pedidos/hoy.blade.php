@extends('layouts.app')

@section('title', 'PEDIDOS')

@section('content')
<h1>PEDIDOS DE HOY</h1>
<div class="table-wrapper">
    @if ($count_hoy == 0)
    NO HAY PEDIDOS DE HOY 
    @else
    <table>
        <tr>
            <th>CLIENTE</th>
            <th>FECHA DE ENTREGA</th>
            <th>DIRECCION</th>
            <th>MONTO</th>
            <th>ESTADO DEL PEDIDO</th>
            <th>ESTADO DE PAGO</th>
            <th>VER</th>
        </tr>
        @foreach ($pedidos_hoy as $pd)
        <tr>
            <td>{{ $pd->clientes->nombre }}</td>
            <td>{{ $pd->fecha_entrega }}</td>
            <td>{{ $pd->direccion }}</td>
            <td>{{ $pd->monto_total }} Bs</td>
            <td>{{ $pd->estado }}</td>
            <td>{{ $pd->pago }}</td>
            <td class="actions">
                <a href="{{ route('pedidos.edit', $pd->id) }}" class="boton"><i class="fa fa-eye"></i></BR>Ver</a>
            </td>
        </tr>
        @endforeach
    </table>
    @endif
    </BR>
</div>
</BR></BR>
<h1>PEDIDOS PARA HOY</h1>
<div class="table-wrapper">
@if ($count_para_hoy == 0)
    NO HAY PEDIDOS DE HOY 
    @else
    <table>
        <tr>
            <th>CLIENTE</th>
            <th>FECHA DE PEDIDO</th>
            <th>DIRECCION</th>
            <th>MONTO</th>
            <th>ESTADO DEL PEDIDO</th>
            <th>ESTADO DE PAGO</th>
            <th>VER</th>
        </tr>
        @foreach ($pedidos_para_hoy as $pd)
        <tr>
            <td>{{ $pd->clientes->nombre }}</td>
            <td>{{ $pd->fecha_pedido }}</td>
            <td>{{ $pd->direccion }}</td>
            <td>{{ $pd->monto_total }} Bs</td>
            <td>{{ $pd->estado }}</td>
            <td>{{ $pd->pago }}</td>
            <td class="actions">
                <a href="{{ route('pedidos.edit', $pd->id) }}" class="boton"><i class="fa fa-eye"></i></BR>Ver</a>
            </td>
        </tr>
        @endforeach
    </table>
    @endif
    </BR>
</div>
@endsection