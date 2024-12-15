@extends('layouts.app')

@section('title', 'CLIENTES')

@section('content')
<script type="text/javascript">
    function registar() {
        regcaracter = /^[A-Za-z\s]+$/;
        regexcel = /[0-9]{5,8}/;
        regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        nombre = document.getElementById('nombre').value;
        telefono = document.getElementById('telefono').value;
        email = document.getElementById('email').value;
        if (regcaracter.test(nombre) && regexcel.test(telefono) && regexCorreo.test(email)) {
            Swal.fire({
                title: "OK",
                text: "Datos correctos",
                icon: "success"
            });
            f1 = document.getElementById('f1')
            f1.submit();
        } else {
            if (nombre == '' || telefono == '' || email == '') {
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

        }

    }
</script>
<h1>REGISTRAR CLIENTE</h1>
<div class="container-categoria">
    <form action="{{ route('clientes.store') }}" id="f1" name="f1" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required></BR>
            <br><br>
        </div>
        <div class="form-group">
            <label for="celular">Celular:</label>
            <input type="tel" name="telefono" id="telefono" required></BR>
            <br><br>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required></BR>
            <br><br>
        </div>
        <div class="form-group">
            <label for="NIT">NIT:</label>
            <input type="hidden" name="NIT" id="NIT" value="{{ $ci_nit }}">
            <input type="text" id="ci_nit" value="{{ $ci_nit }}" style="background-color:gainsboro;" disabled></BR>
            <br><br>
        </div>
        <center><button type="button" name="registrar" id="registrar" class="boton" onclick='registar()'>REGISTRAR</button></center>
    </form>
</div>
@endsection