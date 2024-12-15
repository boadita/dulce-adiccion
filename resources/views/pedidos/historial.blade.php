@extends('layouts.app')

@section('title', 'PEDIDOS')

@section('content')
<script>
    function fechas() {
        fecha_inicio = document.getElementById('fecha_inicio').value;
        fecha_fin = document.getElementById('fecha_fin').value;
        document.getElementById('f_inicio').value = fecha_inicio;
        document.getElementById('f_fin').value = fecha_fin;
        document.getElementById('ff_inicio').value = fecha_inicio;
        document.getElementById('ff_fin').value = fecha_fin;

    }
</script>

<body onload="fechas()">

    <h1>HISTORIA DE VENTAS</h1>
    <form method="GET" id="f1" name="f1" action="{{ route('pedidos.filtrar') }}">
        <div class="fechas">
            <p><label for="fecha_inicio">FECHA DE INICIO:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ $fechaInicio }}" required>
                <label for="fecha_fin"> FECHA FIN:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="{{ $fechaFin }}" required>
                <button type="submit" class="boton"><i class="fa fa-search"></i></button>
            </p>
        </div>
    </form>
    <script>
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');

        fechaInicio.addEventListener('change', function() {
            const fechaSeleccionada = this.value;
            fechaFin.min = fechaSeleccionada; // Establece la fecha mínima del segundo input
        });
    </script>
    <div class="table-wrapper">
        <table id="myTable">
            <thead>
                <tr>
                    <th>CLIENTE</th>
                    <th>FECHA DE PEDIDO</th>
                    <th>FECHA DE ENTREGA</th>
                    <th>DIRECCION</th>
                    <th>MONTO</th>
                    <th>VER</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pd)
                <tr>
                    <td>{{ $pd->clientes->nombre }}</td>
                    <td>{{ $pd->fecha_pedido }}</td>
                    <td>{{ $pd->fecha_entrega }}</td>
                    <td>{{ $pd->direccion }}</td>
                    <td>{{ $pd->monto_total }}</td>
                    <td class="actions">
                        <a href="{{ route('items.show', $pd->id) }}" class="boton"><i class="fa fa-eye"></i></BR>Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </BR>
        <div style="text-align: center; font-size:20px;"></BR> TOTAL: {{number_format($totalMonto, 2)}} Bs</div>
        </BR>
        <div class="externos">
            <form method="GET" id="fpdf" name="fpdf" action="{{ route('pedidos.historial_excel') }}">
                <input type="hidden" id="ff_inicio" name="ff_inicio">
                <input type="hidden" id="ff_fin" name="ff_fin">
                <div class="boton-container">
                    <button type="submit" class="boton"><i class="fas fa-file-excel"></i></br>Excel</button>
                </div>
            </form>
            <form method="GET" id="fpdf" name="fpdf" action="{{ route('pedidos.historial_pdf') }}">
                <input type="hidden" id="f_inicio" name="f_inicio">
                <input type="hidden" id="f_fin" name="f_fin">
                <div class="boton-container">
                    <button type="submit" class="boton"><i class="fas fa-file-pdf"></i></br>PDF</button>
                </div>
            </form>
        </div>
    </div>
   
</body>
@endsection