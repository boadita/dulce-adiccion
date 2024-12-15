<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEDIDOS</title>
    <style>
body {
  color:rgb(49, 51, 49);
  font-size: 16px;
  font-weight: bold;
   font-family:Verdana, Geneva, Tahoma, sans-serif;  
}

h1
{
  color: black;
  font-size: 30px;
  font-weight: bold;
  font-family:Verdana, Geneva, Tahoma, sans-serif;
  text-align: center;
  margin-bottom: 20px;
}

h2
{
  color: black;
  font-size: 25px;
  font-weight: bold;
  font-family:Verdana, Geneva, Tahoma, sans-serif;
  text-align: center;
  margin-bottom: 15px;
}

img
{
  border-radius: 25px;
}

.logo img {
  width: 150px;
  height: auto;
  float: left;
}

.table-wrapper {
  display:grid;
  place-content: center;
}

table
{
  border: 1px solid black;
  margin-left: auto;
  margin-right: auto;
  border-collapse: collapse;
}
tr
{
  text-align: center;
  border: 1px solid black;
}

th
{
  color: black;
  font-weight: bold;
  font-size: 18px;
  text-align: center;
  border: 1px solid black;
  padding: 5px;
}

td
{
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
    </br></br>
    <section>
        <h1 style="text-align: center;">COMPROBANTE</h1>
            <div style="text-align: center;">
                <p>NOMBRE: {{ $pedido->clientes->nombre }}</p>
                <p>DIRECCION: {{ $pedido->direccion }}</p>
                <p>NIT: {{ $pedido->clientes->NIT }}</p>
                <p>FECHA DE PEDIDO: {{ $pedido->fecha_pedido }}</p>
                <p>FECHA DE ENTREGA: {{ $pedido->fecha_entrega }}</p>
            </div>
            </br>
            <h2>DETALLE:</h2>
            <div class="table-wrapper" style="text-align: center;">
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