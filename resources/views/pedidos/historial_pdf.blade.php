<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>PEDIDOS</title>
  <style>
    body {
      color: rgb(49, 51, 49);
      font-size: 16px;
      font-weight: bold;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    h1 {
      color: black;
      font-size: 30px;
      font-weight: bold;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
      text-align: center;
      margin-bottom: 20px;
    }

    h2 {
      color: black;
      font-size: 25px;
      font-weight: bold;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
      text-align: center;
      margin-bottom: 15px;
    }

    img {
      border-radius: 25px;
    }

    .logo img {
      width: 150px;
      height: auto;
      float: left;
    }

    .table-wrapper {
      display: grid;
      place-content: center;
    }

    table {
      border: 1px solid black;
      margin-left: auto;
      margin-right: auto;
      border-collapse: collapse;
    }

    tr {
      text-align: center;
      border: 1px solid black;
    }

    th {
      color: black;
      font-weight: bold;
      font-size: 18px;
      text-align: center;
      border: 1px solid black;
      padding: 5px;
    }

    td {
      text-align: center;
      padding: 5px;
      border: 1px solid black;
    }
  </style>
</head>

<body>
  <header>
    <div class="logo">
      <img src="logo sil.png" alt="Logo">
    </div>
    <div class="slogan">
      <h1>ENDULZA TUS MOMENTOS</h1>
    </div>
  </header>
  <section>
    </BR></BR>
    <h1>HISTORIA DE VENTAS</h1>
    @if ($fechaInicio!='' && $fechaFin !='')
    FECHA INICIO: {{ $fechaInicio }}</BR></BR>
    FECHA FIN: {{ $fechaFin }}
    </BR></BR>
    @endif
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>CLIENTE</th>
            <th>FECHA DE PEDIDO</th>
            <th>FECHA DE ENTREGA</th>
            <th>DIRECCION</th>
            <th>MONTO</th>
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
          </tr>
          @endforeach
        </tbody>
      </table>
      </BR>
      <div style="text-align: center; font-size:20px;"></BR> TOTAL: {{number_format($totalMonto, 2)}} Bs</div>
      </BR>
    </div>
  </section>
  </BR></BR>
  <footer class="footer">
    <div class="contact-info">
      <p>Contactos: 72577740</p>
    </div>
    <div class="qr-code">
      <img src="wp_sil.png" alt="Código QR" style="width: 100px;">
    </div>
  </footer>
</body>

</html>