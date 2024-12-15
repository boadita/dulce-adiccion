<footer class="footer">
    <!-- Sección de imágenes -->
    <div class="icons">
        <div class="footer-item">
            <a href="{{ route('empleados.index') }}"><img src="{{ asset('imagenes/EMPLEADOS.png') }}" alt="EMPLEADOS" style="width: 100px;"></a>
            EMPLEADOS
        </div>
        <div class="footer-item">
            <a href="{{ route('clientes.index') }}"><img src="{{ asset('imagenes/CLIENTES.png') }}" alt="CLIENTES" style="width: 180px;"></a>
            CLIENTES
        </div>
        <div class="footer-item">
            <a href="{{ route('productos.index') }}"><img src="{{ asset('imagenes/PRODUCTOS.png') }}" alt="PRODUCTOS" style="width: 100px;"></a>
            PRODUCTOS
        </div>
        <div class="footer-item">
            <a href="{{ route('pedidos.index') }}"><img src="{{ asset('imagenes/PEDIDOS.png') }}" alt="PEDIDOS" style="width: 180px;"></a>
            PEDIDOS
        </div>
        <div class="footer-item">
            <a href="{{ route('pedidos.hoy') }}"><img src="{{ asset('imagenes/REPORTES.png') }}" alt="HOY" style="width: 100px;"></a>
            REPORTES
        </div>
        <div class="footer-item">
            <a href="{{ route('pedidos.historial') }}"><img src="{{ asset('imagenes/HISTORIAL.png') }}" alt="HISTORIAL" style="width: 120px;"></a>
            HISTORIAL
        </div>
    </div>
    <div class="contact-info">
        <p>Contactos:</p>
        <p><i class="fab fa-whatsapp"></i> 72577740</p>
        <br>
        <div class="social-media">
            <a href="https://facebook.com" target="_blank">
                <img src="{{ asset('imagenes/social-media/fb.png') }}" alt="Facebook">
            </a>
            <a href="https://instagram.com" target="_blank">
                <img src="{{ asset('imagenes/social-media/insta.png') }}" alt="Instagram">
            </a>
            <a href="https://tiktok.com" target="_blank">
                <img src="{{ asset('imagenes/social-media/tk.png') }}" alt="TikTok">
            </a>
        </div>
    </div>
    <div class="qr-code">
        <img src="{{ asset('wp_sil.png') }}" alt="Código QR">
    </div>
</footer>