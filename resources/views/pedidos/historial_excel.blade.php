<table style="font-family: Verdana, Geneva, Tahoma, sans-serif;">
    <thead>
        <tr>
            <th colspan="6" style="color: red; text-align: center; font-weight: bold;">Historial de Pedidos</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; font-weight: bold;">Desde: {{ $fechaInicio ?? 'N/A' }} Hasta: {{ $fechaFin ?? 'N/A' }}</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid black;">Pedido ID</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid black;">CLIENTE</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid black;">FECHA DE PEDIDO</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid black;">FECHA DE ENTREGA</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid black;">DIRECCION</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid black;">MONTO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pedidos as $pd)
        <tr>
            <td style="border: 1px solid black;">{{ $pd->id }}</td>
            <td style="border: 1px solid black;">{{ $pd->clientes->nombre }}</td>
            <td style="border: 1px solid black;">{{ $pd->fecha_pedido }}</td>
            <td style="border: 1px solid black;">{{ $pd->fecha_entrega }}</td>
            <td style="border: 1px solid black;">{{ $pd->direccion }}</td>
            <td style="border: 1px solid black;">{{ $pd->monto_total }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align: center; border: 1px solid black;"><strong>TOTAL:</strong></td>
            <td style="color: red; font-weight: bold; border: 1px solid black;">{{ $totalMonto }}</td>
        </tr>
    </tbody>
</table>