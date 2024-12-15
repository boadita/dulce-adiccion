<header>
    <div class="logo">
        <img src="{{ asset('logo sil.png') }}" alt="Logo">
    </div>
    <div class="slogan">
        <h1>ENDULZA TUS MOMENTOS</h1>
    </div>
    @if(Auth::guard('web')->check())
    <div class="user-info">
        <img src="{{ asset('imagenes/empleados/' . Auth::guard('web')->user()->imagen) }}" alt="Imagen de usuario">
        <span style="color: black; font-size: 18px;">{{ Auth::guard('web')->user()->nickname }}</span>
        <input type="hidden" name="empleado_id" id="empleado_id" value="{{ Auth::guard('web')->user()->id }}"></BR>
        <form action="{{ route('logout') }}" method="POST" style="margin-left: 10px;">
            @csrf
            <button type="submit" class="boton"><i class="fa fa-sign-out"></i> CERRAR SESIÓN</button>
        </form>
    </div>
@endif
</header>