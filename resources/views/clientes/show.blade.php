@extends('layouts.app')

@section('title', 'CLIENTES')

@section('content')
<script>
    function cambio_dir() {
        dir = document.getElementById('direccion').value;

        if (dir == 0) {
            document.getElementById('nueva_dir').style.display = 'block';
        } else {
            document.getElementById('nueva_dir').style.display = 'none';
        }
    }

    function agregar() {
        var table = document.getElementById("tabla");
        var row = table.insertRow(-1);
        var row_producto = row.insertCell(0);
        var row_precio_unitario = row.insertCell(1);
        var row_cantidad = row.insertCell(2);
        var row_precio_total = row.insertCell(3);

        var prid = document.createElement("input");
        prid.type = "hidden";
        prid.value = document.getElementById("nompro").value;
        prid.className = "nompro";

        pr = document.getElementById("nompro");
        pr_select = pr.options[pr.selectedIndex].text;
        var producto = document.createElement("p");
        producto.innerHTML = pr_select;
        producto.className = "producto";

        var cantidad = document.createElement("p");
        cantidad.innerHTML = document.getElementById("cantidad").value;
        cantidad.className = "cantidad";

        var precio_unitario = document.createElement("p");
        precio_unitario.innerHTML = document.getElementById("pu").innerHTML + ' ' + 'Bs';
        precio_unitario.className = "precio_unitario";

        pu = document.getElementById("pu").innerHTML;
        cant = document.getElementById("cantidad").value;
        total_price = (parseFloat(pu) * parseFloat(cant)).toFixed(2);
        var precio_total = document.createElement("p");
        precio_total.innerHTML = total_price + ' ' + 'Bs';
        precio_total.className = "precio_total";

        var ptot = document.createElement("input");
        ptot.type = "hidden";
        ptot.value = total_price;
        ptot.className = "ptot";

        total = parseFloat(document.getElementById("total").innerHTML);
        total += parseFloat(precio_total.innerHTML);
        document.getElementById("total").innerHTML = total.toFixed(2);

        row_producto.appendChild(prid);
        row_producto.appendChild(producto);
        row_precio_unitario.appendChild(precio_unitario);
        row_cantidad.appendChild(cantidad);
        row_precio_total.appendChild(precio_total);
        row_precio_total.appendChild(ptot);

        document.getElementById('f1').reset();
        document.getElementById("pu").innerHTML = 0;
    }

    function select_cero() {
        document.getElementById('direccion').value = 0;
    }

    function registrar() {
        regexnum = /[0-9]/;
        cantidad = document.getElementById('cantidad').value;
        categoria_id = document.getElementById('categoria_id').value;
        nompro = document.getElementById('nompro').value;


        if (regexnum.test(cantidad) && categoria_id != 0 && nompro != 0) {
            Swal.fire({
                title: "OK",
                text: "Datos correctos",
                icon: "success"
            });
            $('#modalProd').modal('hide')
            agregar();
        } else {
            if (cantidad == '') {
                Swal.fire({
                    title: "Oops...",
                    text: "No se aceptan campos vacios",
                    icon: "error"
                });
            }
            if (!regexnum.test(cantidad)) {
                Swal.fire({
                    title: "Oops...",
                    text: "Introduzca correctamente la cantidad",
                    icon: "error"
                });
            }
            if (categoria_id == 0) {
                Swal.fire({
                    title: "Oops...",
                    text: "Introduzca una categoria",
                    icon: "error"
                });
            }

            if (nompro == 0) {
                Swal.fire({
                    title: "Oops...",
                    text: "Introduzca un producto",
                    icon: "error"
                });
            }
        }

    }

    function tojson() {
        if (document.getElementById("direccion").value == 0) {
            Swal.fire({
                title: "Oops...",
                text: "Seleccione una direccion",
                icon: "error"
            });
        } else {
            direccion = document.getElementById("direccion");
            dir_lugar = direccion.options[direccion.selectedIndex].text;
            const pedidos = {
                empleado_id: document.getElementById('empleado_id').value,
                cliente_id: document.getElementById('cliente_id').value,
                monto_total: document.getElementById('total').innerHTML,
                fecha_pedido: document.getElementById('hoy').value,
                fecha_entrega: document.getElementById('fecha_entrega').value,
                direccion: dir_lugar
            };

            const tabla = document.getElementById('tabla');
            const items = [];

            // Iterar sobre las filas de la tabla
            for (let i = 1; i < tabla.rows.length; i++) { // Comenzar desde 1 para omitir el encabezado
                const fila = tabla.rows[i];

                // Obtener el valor del input oculto "sp"
                const sp_value = fila.cells[0].querySelector('input.nompro').value;
                const ptot = fila.cells[3].querySelector('input.ptot').value;

                const objeto = {
                    producto_id: sp_value,
                    cantidad: fila.cells[2].innerText,
                    precio_cant: ptot
                };
                items.push(objeto);
            }

            //console.log(jsonItems);
            fetch('/pedidos/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        pedidos,
                        items
                    })
                })
                .then(response => {
                    // Verifica si la respuesta es ok
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.redirect_url) {
                        // Redirigir a la URL proporcionada por el backend
                        window.location.href = data.redirect_url;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }
</script>

<script>
    // Función para obtener la fecha de hoy en formato YYYY-MM-DD
    function bloquearFechasAnteriores() {
        const hoy = new Date();
        const dia = String(hoy.getDate()).padStart(2, '0');
        const mes = String(hoy.getMonth() + 1).padStart(2, '0'); // Los meses van de 0 a 11
        const anio = hoy.getFullYear();
        const fechaActual = `${anio}-${mes}-${dia}`;

        const inputFecha = document.getElementById("fecha_entrega");
        inputFecha.min = fechaActual;

        // Deshabilitar la edición manual
        inputFecha.addEventListener('keydown', function(e) {
            e.preventDefault();
        });

    }

    window.onload = bloquearFechasAnteriores;
</script>

<body onload="select_cero()">
<h1>DETALLE DE VENTA</h1>
<div class="row">
    <div class="column-left">
        <input type="hidden" id="cliente_id" name="cliente_id" value="{{$cliente->id}}">
        <input type="hidden" id="hoy" name="hoy" value="{{now()->toDateString()}}">
        <p>NOMBRE: {{ $cliente->nombre }}</p>
        <p>FECHA DE PEDIDO: {{ now()->toDateString() }}</p>
        <p><label for="fecha">FECHA DE ENTREGA:</label>
            <input type="date" id="fecha_entrega" name="fecha_entrega" value="{{ now()->toDateString() }}">
    </div>
    <div class="column-right">
        <p>NIT: {{ $cliente->NIT }}</p>
        <p>DIRECCION: <select id="direccion" name="direccion" onchange="cambio_dir()">
                <option class="form-control" value="0">Seleccione Direccion</option>
                @foreach ($direccion as $dir)
                <option class="form-control" value="{{$dir->id}}">{{$dir->lugar}}</option>
                @endforeach
            </select>
            <button type="button" class="boton" data-toggle="modal" data-target="#NewDir" id="nueva_dir">Agregar Direccion</button>
        </p>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="NewDir" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">NUEVA DIRECCION</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="{{ route('direccion.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="lugar">Lugar:</label>
                            <input type="text" name="lugar" id="lugar" required>
                            <input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->id }}" required>
                            <br><br>
                        </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="submit" class="boton"><i class="fa fa-plus-square"></i></br>NUEVA</button>
                    <button type="button" class="boton" data-dismiss="modal"><i class="fas fa-window-close"></i></br>CERRAR</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</br></br>
<div class="table-wrapper">
    <table class="table-condensed" id='tabla'>
        <tr>
            <th>PRODUCTO</th>
            <th>PRECIO UNITARIO</th>
            <th>CANTIDAD</th>
            <th>PRECIO TOTAL</th>
        </tr>
    </table>
    <div style="text-align: center;">TOTAL: <span id="total" style="color: red; font-size: 18px;">0</span> <span style="color: red; font-size: 18px;"> Bs</span> </div>
    </br></br>
    <div class="botones-contenedor">
        <button class="boton" data-toggle="modal" data-target="#modalProd">AGREGAR</button>
        <button class="boton" onclick="tojson()">FINALIZAR</button>
    </div>
    </br></br>
</div>
<!-- Modal -->
<div class="modal fade" id="modalProd" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel">AGREGAR PRODUCTO</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" id="f1" name="f1">
                    @csrf
                    <div class="form-group">
                        <label for="categoria_id">Categoria:</label>
                        <select id="categoria_id" name="categoria_id">
                            <option class="form-control" value="0">Seleccione categoria</option>
                            @foreach ($categorias as $cat)
                            <option class="form-control" value="{{$cat->id}}">{{$cat->nombre}}</option>
                            @endforeach
                        </select>
                        <br><br>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Nombre:</label>
                        <select id="nompro" name="nompro">
                            <option class="form-control" value="0">Seleccione producto</option>
                        </select>
                        <br><br>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad" id="cantidad" required>
                        <br><br>
                    </div>
                    <div class="form-group">
                        <label for="pu">Precio unitario:</label>
                        <span id="pu" style="color: black; font-size: 18px;">0</span>
                        <span style="color: black; font-size: 18px;"> Bs</span>
                        <br><br>
                    </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" name="ingresar" id="ingresar" class="boton" onclick='registrar()'><i class="fa fa-plus-square"></i></br>NUEVO</button>
                <button type="button" class="boton" data-dismiss="modal"><i class="fas fa-window-close"></i></br>CERRAR</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#categoria_id').on('change', function() {
            let categoria_id = $(this).val();
            if (categoria_id) {
                $.ajax({
                    url: '/filtrarProductos',
                    type: "GET",
                    dataType: "json",
                    data: {
                        categoria_id: categoria_id
                    },
                    success: function(data) {
                        $('#nompro').empty();
                        $('#nompro').append('<option value=0>Seleccione producto</option>');
                        $.each(data, function(key, producto) {
                            $('#nompro').append(`<option value="${producto.id}" data-precio="${producto.precio}">${producto.descripcion}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la petición:", error);
                    }
                });
            } else {
                $('#nompro').empty();
                $('#nompro').append('<option value=0>Seleccione producto</option>');
                $('#pu').text(0); // Resetear el precio
            }
        });

        $('#nompro').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const precio = selectedOption.data('precio'); // Obtener el precio del atributo data
            $('#pu').text(precio ? precio : 0); // Mostrar el precio o 0 si no hay precio
        });
    });
</script>
</body>
@endsection