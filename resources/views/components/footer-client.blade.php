<a class="btn btn-primary position-fixed bottom-0 end-0 m-4 d-flex align-items-center shadow-lg"
    style="z-index: 1050; padding: 0.75rem 1.25rem; border-radius: 2rem;" data-bs-toggle="modal"
    data-bs-target="#cotizadorModal">
    <i class="bi bi-calculator me-2 fs-5 text-white"></i>
    <span class="text-white">Cotizador de productos</span>
    <span id="cotizador-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
        style="font-size: 0.6rem; display: none;">
        0
    </span>
</a>

<!-- Modal -->
<div class="modal fade" id="cotizadorModal" tabindex="-1" aria-labelledby="cotizadorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="cotizadorModalLabel">Cotizador de compras</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Contenedor con scroll interno -->
            <div class="modal-body" id="cotizador-contenido" style="max-height: 400px; overflow-y: auto;">
                <!-- Aquí se cargará el cotizador -->
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="mostrarModalCotizacion()">
                    <i class="bi bi-calculator"></i> Realizar cotización
                </button>
            </div>
            <!-- Modal con Bootstrap 5 y SweetAlert2 -->
            <script>
                function mostrarModalCotizacion() {
                    const carrito_cotizacion_productos = JSON.parse(localStorage.getItem("carrito")) || [];
                    if (carrito_cotizacion_productos.length === 0) {
                        Swal.fire({
                            icon: "warning",
                            title: "Cotización vacía",
                            text: "Agrega productos antes de continuar.",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        return;
                    }

                    // Cierra el modal de Bootstrap antes de lanzar SweetAlert
                    const modal = bootstrap.Modal.getInstance(document.getElementById('cotizadorModal'));
                    modal.hide();

                    Swal.fire({
                        title: 'Datos del cliente',
                        html: `
            <div style="text-align: left;">
                <label for="swal-nombre-cotizacion">Nombre</label>
                <input id="swal-nombre-cotizacion" class="swal2-input" placeholder="Escribe tu nombre">

                <label for="swal-apellido-cotizacion">Apellido</label>
                <input id="swal-apellido-cotizacion" class="swal2-input" placeholder="Escribe tu apellido">

                <label for="swal-telefono-cotizacion">Teléfono</label>
                <input id="swal-telefono-cotizacion" class="swal2-input" placeholder="Ej. 7711234567">
            </div>
        `,
                        focusConfirm: false,
                        preConfirm: () => {
                            const nombre_cotizacion = document.getElementById('swal-nombre-cotizacion').value;
                            const apellido_cotizacion = document.getElementById('swal-apellido-cotizacion').value;
                            const telefono_cotizacion = document.getElementById('swal-telefono-cotizacion').value;

                            if (!nombre_cotizacion || !apellido_cotizacion || !telefono_cotizacion) {
                                Swal.showValidationMessage('Completa todos los campos');
                                return false;
                            }

                            return {
                                nombre_cotizacion,
                                apellido_cotizacion,
                                telefono_cotizacion
                            };
                        },
                        confirmButtonText: 'Confirmar cotización',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            confirmarCotizacion(result.value);
                        }
                    });
                }
            </script>

        </div>
    </div>
</div>


<footer class="footer">

    <section class="location-section">
        <div class="container">
            <h2>¡Acude con los expertos!</h2>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3552.3748050419726!2d-99.21496830219037!3d20.4942139394509!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d3e04102743045%3A0x7d72837fc6bcbee1!2sVidrio%20Y%20Aluminio!5e1!3m2!1sen!2smx!4v1733248547118!5m2!1sen!2smx"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Contacto</h5>
                <p><i class="bi bi-geo-alt-fill"></i> Lib. a Cardonal, San Nicolás, 42302 Ixmiquilpan, Hgo.</p>
                <p><i class="bi bi-envelope-fill"></i> Email: aluvidixmiquilpan@gmail.com</p>
                <p><i class="bi bi-telephone-fill"></i> Teléfono: 7712003391</p>
            </div>
            <div class="col-md-4">
                <h5>Síguenos</h5>
                <a href="#">Facebook</a> | <a href="#">Twitter</a> | <a href="#">Instagram</a>
            </div>
            <div class="col-md-4">
                <h5>Enlaces útiles</h5>
                <a href="">Vidrios</a><br>
                <a href="">Aluminios</a><br>
                <a href="">Herrajes</a>
            </div>
        </div>
        <p class="text-center mt-4">© 2025 ALUVID Ixmiquilpan. Todos los derechos reservados.</p>
    </div>
</footer>

<script>
    const RUTA_COTIZACION = "{{ route('cotizador_ventas') }}";
    const TOKEN_LARAVEL_COTIZACION = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/productos_cotizador.js') }}"></script>
