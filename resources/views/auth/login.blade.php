<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('icono.png') }}" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('estilos.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>LOGIN</title>
    <style>
        .form-group {
            position: relative;
        }

        .form-group input {
            padding-right: 40px;
            /* Aumentar el espacio para el icono */
        }

        .form-control {
            padding-right: 40px;
            /* Espacio para el icono */
            width: 100%;
            /* Asegura que el input sea del ancho completo */
        }

        .is-invalid {
            border: 2px solid red;
            background-color: #fff5f5;
            padding-right: 40px;
            /* Espacio para el icono */
        }

        .invalid-feedback {
            display: block;

            left: 0;
            /* Alineación a la izquierda del input */
            top: 100%;
            /* Colocarlo justo debajo del input */
            min-height: 1.2rem;
            /* Espacio reservado para el mensaje */
            color: red;
            font-size: 12px;
            margin-top: 0.5px;
        }

        .form-group i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: gray;
            pointer-events: all;
            /* Evita que el icono interfiera con el input */
        }

        #togglePassword:hover {
    color: #007bff; /* Cambiar a un color de tu elección */
    cursor: pointer; /* Indica que es clicable */
}
    </style>
</head>

<body>
    <h1>BIENVENID@</h1>
    <div class="container-categoria" style="flex-direction: column;">
        <img src="{{ asset('logo sil.png') }}" alt="Logo" style="width: 25%; height:auto;"></br>
        <p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="nickname">USUARIO:</label>
                <input type="text" name="nickname" id="nickname" required class="form-control @error('nickname') is-invalid @enderror" value="{{ old('nickname') }}" placeholder="Usuario">
                <i class="fa fa-user"></i>
            </div>
            @error('nickname')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <div class="form-group" style="position: relative;">
                <label for="password">PASSWORD:</label>
                <input type="password" name="password" id="password" required class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña">
                <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 10px; cursor: pointer;"></i>
            </div>
            @error('password')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <div style="text-align: center;">
                <button type="submit" class="boton" style="text-align: center;"><i class="fa fa-sign-in"></i></BR>
                    LOGIN</button>
            </div>
        </form>
        </p>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        // Alternar entre mostrar y ocultar la contraseña
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // Alternar el icono de ojo
        this.classList.toggle("fa-eye-slash");
    });
});
    </script>
</body>

</html>