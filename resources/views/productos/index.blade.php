@extends('layouts.app')

@section('title', 'PRODUCTOS')

@section('content')
<script type="text/javascript">
    function regcat() {
        regcaracter = /^[A-Za-z\s]+$/;
        nombre = document.getElementById('nombre').value;
        if (regcaracter.test(nombre) && nombre != '') {
            Swal.fire({
                title: "OK",
                text: "Datos correctos",
                icon: "success"
            });
            nomcat = document.getElementById('nomcat')
            nomcat.submit();
        } else {
            Swal.fire({
                title: "Oops...",
                text: "Introduzca correctamente la categoria",
                icon: "error"
            });
        }
    }

    function registar() {
        regcaracter = /^[A-Za-z\s]+$/;
        regprecio = /^\d+(\.\d{1,2})?$/;

        descripcion = document.getElementById('descripcion').value;
        precio = document.getElementById('precio').value;
        categoria_id = document.getElementById('categoria_id').value;

        if (regcaracter.test(descripcion) && regprecio.test(precio) && categoria_id != 0) {
            Swal.fire({
                title: "OK",
                text: "Datos correctos",
                icon: "success"
            });
            f1 = document.getElementById('f1')
            f1.submit();
        } else {
            if (descripcion == '' || precio == '') {
                Swal.fire({
                    title: "Oops...",
                    text: "No se aceptan campos vacios",
                    icon: "error"
                });
            }
            if (!regcaracter.test(descripcion)) {
                Swal.fire({
                    title: "Oops...",
                    text: "Introduzca correctamente la descripcion",
                    icon: "error"
                });
            }

            if (!regprecio.test(precio)) {
                Swal.fire({
                    title: "Oops...",
                    text: "Introduzca correctamente el precio",
                    icon: "error"
                });
            }

            if (categoria_id == 0) {
                Swal.fire({
                    title: "Oops...",
                    text: "Introduzca categoria",
                    icon: "error"
                });
            }

        }

    }

    function select_cero() {
        document.getElementById('categoria').value = 0;
    }

    function cambio_catego() {
        cat = document.getElementById('categoria').value;

        if (cat == 0) {
            document.getElementById('nueva_cat').style.display = 'block';
        } else {
            document.getElementById('nueva_cat').style.display = 'none';
        }
    }
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let token = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        // Cuando el formulario es enviado
        $('#editForm').submit(function(e) {
            e.preventDefault();

            let productoId = $('#productoId').val();
            let formData = new FormData(this); // Usamos FormData para manejar correctamente datos de formularios con archivos
            formData.append('_method', 'PUT'); // Sobrescribimos el método PUT
            formData.append('_token', token); // Añadimos el token CSRF

            $.ajax({
                url: '/productos/' + productoId,
                type: 'POST', // Cambia a 'POST' debido al _method hidden PUT
                data: formData,
                contentType: false, // Necesario para enviar archivos
                processData: false, // Deshabilita el procesamiento de datos
                success: function(response) {
                    // Mostrar un mensaje de éxito
                    Swal.fire({
                        title: "OK",
                        text: "Producto actualizado correctamente",
                        icon: "success"
                    });
                    // Actualizar la tabla sin recargar la página
                    location.reload(); // O actualizar elementos específicos de la vista
                },
                error: function(response) {
                    // Mostrar errores
                    Swal.fire({
                        title: "Oops...",
                        text: "Ocurrió un error, intenta nuevamente",
                        icon: "error"
                    });
                }
            });
        });

        // Función para abrir el modal con datos del empleado seleccionado
        $(document).on('click', '.editBtn', function() {
            let productoId = $(this).data('id');
            let categoria_id = $(this).data('categoria_id');
            let descripcion = $(this).data('descripcion');
            let precio = $(this).data('precio');
            let disponible = $(this).data('disponible');

            // Obtener los datos del empleado por AJAX
            $.get('/productos/' + productoId + '/edit', function(data) {
                // Poner los datos en el modal
                $('#productoId').val(data.id);
                $('#mdescripcion').val(data.descripcion);
                $('#mcategoria_id').val(data.categoria_id);
                $('#mprecio').val(data.precio); // Agrega el campo teléfono
                $('#mdisponible').val(data.disponible); // Agrega el campo email
                $('#mimagen').val(null); // Limpiar el campo de imagen

                // Mostrar el modal
                $('#editModal').modal('show');
            });
        });
    });
</script>

<body onload="select_cero()">
    <h1>Lista de Productos</h1>

    @if ($message = Session::get('success'))
    <p style="text-align: center;">{{ $message }}</p>
    @endif
    <div class="container-categoria">
        <label for="tipo">Seleccione una categoria</label>
        <select id="categoria" name="categoria" onchange="cambio_catego()">
            <option class="form-control" value="0">Todas las categorias</option>
            @foreach ($categorias as $cat)
            <option class="form-control" value="{{$cat->id}}">{{$cat->nombre}}</option>
            @endforeach
        </select>
        <button type="button" class="boton" data-toggle="modal" data-target="#NewCat" id="nueva_cat">Nueva categoria</button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="NewCat" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">NUEVA CATEGORIA</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="{{ route('categorias.store') }}" name="nomcat" id="nomcat" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" required>
                            <br><br>
                        </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" name="ingrcat" id="ingrcat" class="boton" onclick='regcat()'><i class="fa fa-plus-square"></i></br>NUEVA</button>
                    <button type="button" class="boton" data-dismiss="modal"><i class="fas fa-window-close"></i></br>CERRAR</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="table-wrapper">
        <table id="tabla-productos">
            <thead>
                <tr>
                    <th>DESCRIPCION</th>
                    <th>CATEGORIA</th>
                    <th>PRECIO</th>
                    <th>IMAGEN</th>
                    <th>DISPONIBLE</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $pr)
                <tr>
                    <td>{{ $pr->descripcion }}</td>
                    <td>{{ $pr->categorias->nombre }}</td>
                    <td>{{ $pr->precio }} Bs</td>
                    <td><img src="{{ asset('imagenes/productos/'.$pr->imagen) }}" alt="imagen" style="width: 100px;"></td>
                    @if ($pr->disponible == 0)
                    <td><i class="fa fa-times"></i></td>
                    @else
                    <td><i class="fa fa-check"></i></td>
                    @endif
                    <td class="actions">
                        <a href="{{ route('productos.show', $pr->id) }}" class="boton"><i class="fa fa-eye"></i></BR>Ver</a>
                        <button type="button" class="boton editBtn" data-id="{{ $pr->id }}"><i class="fa fa-pencil-square"></i></BR>Editar</button>
                        <form action="{{ route('productos.destroy', $pr->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="boton"><i class="fa fa-trash"></i></BR>Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </BR>
        <div class="boton-container">
            <button type="button" class="boton" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-user-plus"></i></BR>Nuevo</button>
        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="modalNuevo" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">NUEVO PRODUCTO</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" id="f1" name="f1">
                        @csrf
                        <div class="form-group">
                            <label for="descripcion">Descripcion:</label>
                            <input type="text" name="descripcion" id="descripcion" required>
                            <br><br>
                        </div>
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
                            <label for="precio">Precio:</label>
                            <input type="number" name="precio" id="precio" step="0.01" required>
                            <br><br>
                        </div>
                        <div class="form-group">
                            <!-- Campo para subir la imagen -->
                            <label for="imagen">Imagen:</label>
                            <div class="custom-file-wrapper">
                                <input type="file" id="imagen" name="imagen" class="custom-file-input">
                                <br><br>
                            </div>
                        </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" name="ingresar" id="ingresar" class="boton" onclick='registar()'><i class="fa fa-plus-square"></i></br>NUEVO</button>
                    <button type="button" class="boton" data-dismiss="modal"><i class="fas fa-window-close"></i></br>CERRAR</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">MODIFICAR PRODUCTO</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Formulario de edición -->
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="productoId" name="productoId">

                        <div class="form-group">
                            <label for="descripcion">Descripcion:</label>
                            <input type="text" id="mdescripcion" name="descripcion" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="categoria_id">Categoria:</label>
                            <select id="mcategoria_id" name="categoria_id">
                                <option class="form-control" value="0">Seleccione categoria</option>
                                @foreach ($categorias as $cat)
                                <option class="form-control" value="{{$cat->id}}">{{$cat->nombre}}</option>
                                @endforeach
                            </select>
                            <br><br>
                        </div>

                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="number" name="precio" id="mprecio" step="0.01" required>
                            <br><br>
                        </div>
                        <div class="form-group">
                            <!-- Campo para subir la imagen -->
                            <label for="imagen">Imagen:</label>
                            <div class="custom-file-wrapper">
                                <input type="file" id="mimagen" name="imagen" class="custom-file-input">
                                <br><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="disponible">Disponible:</label>
                            <select id="mdisponible" name="disponible">
                                <option class="form-control" value="1">Si</option>
                                <option class="form-control" value="0">No</option>
                            </select>
                            <br><br>
                        </div>


                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" name="modificar" id="modificar" class="boton"><i class="fa fa-sign-in"></i></br>MODIFICAR</button>
                            <button type="button" class="boton" data-dismiss="modal"><i class="fas fa-window-close"></i></br>CERRAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#categoria').on('change', function() {
            let categoria_id = $(this).val();

            $.ajax({
                url: '/filtrarProductos', // Asegúrate de que la URL sea correcta
                method: 'POST',
                data: {
                    categoria_id: categoria_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    let tabla_productos = $('#tabla-productos tbody');
                    tabla_productos.empty(); // Limpiar tabla

                    if (response.length > 0) {
                        response.forEach(function(productos) {
                            let disponibilidadIcono = productos.disponible ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>';
                            // Generamos la celda de acciones
                            let acciones = `
                            <td class="actions">
                                <a href="${productos.show_route}" class="boton">
                                    <i class="fas fa-eye"></i><br>Ver
                                </a>
                                <button type="button" class="boton editBtn" data-id="${productos.id}" data-categoria_id="${productos.categoria_id}" data-descripcion="${productos.descripcion}" data-precio="${productos.precio}" data-disponible="${productos.disponible}">
                                    <i class="fas fa-pencil-square"></i><br>Modificar
                                </button>
                                <form action="${productos.destroy_route}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="boton">
                                        <i class="fas fa-trash"></i><br>Eliminar
                                    </button>
                                </form>
                            </td>
                        `;

                            let row = `<tr>
                            <td>${productos.descripcion}</td>
                            <td>${productos.categorias.nombre}</td>
                            <td>${productos.precio} Bs</td>
                            <td><img src="imagenes/productos/${productos.imagen}" alt="${productos.descripcion}" width="100"></td>
                            <td>${disponibilidadIcono}</td>
                            ${acciones}  <!-- Aquí se agrega la celda de acciones -->
                        </tr>`;
                            tabla_productos.append(row); // Corrigiendo "tableBody" por "tabla_productos"
                        });
                    } else {
                        tabla_productos.append('<tr><td colspan="6">No hay productos en esta categoría</td></tr>'); // Corrige el número de columnas
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });


    });
</script>
@endsection