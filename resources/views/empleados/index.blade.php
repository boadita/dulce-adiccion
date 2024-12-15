@extends('layouts.app')

@section('title', 'EMPLEADOS')

@section('content')
<script type="text/javascript">
    function registar() {
        regcaracter = /^[A-Za-z\s]+$/;
        regexcel = /[0-9]{5,8}/;
        regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        nombre = document.getElementById('nombre').value;
        nickname = document.getElementById('nickname').value;
        telefono = document.getElementById('telefono').value;
        email = document.getElementById('email').value;
        password = document.getElementById('password').value;
        password2 = document.getElementById('password2').value;
        if (regcaracter.test(nombre) && nickname != '' && regexcel.test(telefono) && regexCorreo.test(email) && password == password2 && password != '' && password2 != '') {
            Swal.fire({
                title: "OK",
                text: "Datos correctos",
                icon: "success"
            });
            f1 = document.getElementById('f1')
            f1.submit();
        } else {
            if (nombre == '' || nickname == '' || telefono == '' || email == '' || password == '' || password2 == '') {
                Swal.fire({
                    title: "Oops...",
                    text: "No se aceptan campos vacios",
                    icon: "error"
                });
            }
            if (!regcaracter.test(nombre)) {
                Swal.fire({
                    title: "Oops...",
                    text: "Introduzca correctamente el nombre",
                    icon: "error"
                });
            }

            if (!regexcel.test(telefono)) {
                Swal.fire({
                    title: "Oops...",
                    text: "Introduzca correctamente el numero de celular",
                    icon: "error"
                });
            }

            if (!regexCorreo.test(email)) {
                Swal.fire({
                    title: "Oops...",
                    text: "Introduzca correctamente el email",
                    icon: "error"
                });
            }

            if (password != password2) {
                Swal.fire({
                    title: "Oops...",
                    text: "Escriba la misma contraseña",
                    icon: "error"
                });
            }
        }

    }
</script>

<script>
    $(document).ready(function() {
        // Cuando el formulario es enviado
        $('#editForm').submit(function(e) {
            e.preventDefault();

            let empleadoId = $('#empleadoId').val();
            let formData = new FormData(this); // Usamos FormData para manejar correctamente datos de formularios con archivos

            $.ajax({
                url: '/empleados/' + empleadoId,
                type: 'POST', // Cambia a 'POST' debido al _method hidden PUT
                data: formData,
                contentType: false, // Necesario para enviar archivos
                processData: false, // Deshabilita el procesamiento de datos
                success: function(response) {
                    // Mostrar un mensaje de éxito
                    Swal.fire({
                        title: "OK",
                        text: "Empleado actualizado correctamente",
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
        $('.editBtn').click(function() {
            let empleadoId = $(this).data('id');

            // Obtener los datos del empleado por AJAX
            $.get('/empleados/' + empleadoId + '/edit', function(data) {
                // Poner los datos en el modal
                $('#empleadoId').val(data.id);
                $('#mnombre').val(data.nombre);
                $('#mnickname').val(data.nickname);
                $('#mtelefono').val(data.telefono); // Agrega el campo teléfono
                $('#memail').val(data.email); // Agrega el campo email

                // Mostrar el modal
                $('#editModal').modal('show');
            });
        });
    });
</script>

<h1>Lista de Empleados</h1>

@if ($message = Session::get('success'))
<p style="text-align: center;">{{ $message }}</p>
@endif
<div class="table-wrapper">
    <table>
        <tr>
            <th>NOMBRE</th>
            <th>NICKNAME</th>
            <th>TELEFONO</th>
            <th>EMAIL</th>
            <th>IMAGEN</th>
            <th>ACCIONES</th>
        </tr>
        @foreach ($empleados as $emp)
        <tr>
            <td>{{ $emp->nombre }}</td>
            <td>{{ $emp->nickname }}</td>
            <td>{{ $emp->telefono }}</td>
            <td>{{ $emp->email }}</td>
            <td><img src="{{ asset('imagenes/empleados/'.$emp->imagen) }}" alt="imagen" style="width: 100px;"></td>
            <td class="actions">
                <a href="{{ route('empleados.show', $emp->id) }}" class="boton"><i class="fa fa-eye"></i></BR>Ver</a>
                <button type="button" class="boton editBtn" data-id="{{ $emp->id }}"><i class="fa fa-pencil-square"></i></BR>Editar</button>
                @if ($emp->id!=Auth::guard('web')->user()->id)
                <form action="{{ route('empleados.destroy', $emp->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="boton"><i class="fa fa-trash"></i></BR>Eliminar</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
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
                <h4 class="modal-title" id="myModalLabel">NUEVO USUARIO</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="{{ route('empleados.store') }}" method="POST" enctype="multipart/form-data" id="f1" name="f1">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" required>
                        <br><br>
                    </div>
                    <div class="form-group">
                        <label for="nickname">Usuario:</label>
                        <input type="text" name="nickname" id="nickname" required>
                        <br><br>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Telefono:</label>
                        <input type="tel" name="telefono" id="telefono" required>
                        <br><br>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required>
                        <br><br>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>
                        <br><br>
                    </div>
                    <div class="form-group">
                        <label for="password2">Repetir Password:</label>
                        <input type="password" name="password2" id="password2" required>
                        <br><br>
                    </div>
                    <div class="form-group">
                        <!-- Campo para subir la imagen -->
                        <label for="image">Imagen:</label>
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
                <h4 class="modal-title" id="myModalLabel">MODIFICAR USUARIO</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Formulario de edición -->
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="empleadoId" name="empleadoId">

                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="mnombre" name="nombre" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="nickname">Usuario:</label>
                        <input type="text" id="mnickname" name="nickname" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Telefono:</label>
                        <input type="tel" name="telefono" id="mtelefono" required>
                        <br><br>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="memail" required>
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
@endsection