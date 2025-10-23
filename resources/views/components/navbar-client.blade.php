<nav class="navbar navbar-expand-lg navbar-custom fixed-top bg-white shadow-sm">
    <div class="container-fluid" style="background-color: #001d4a; border-bottom: 3px solid #0096d6;">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Logo ALUVID" style="height: 40px; margin-right: 10px;">
            <span style="color: white;">ALUVID IXMIQUILPAN</span>
        </a>

        <!-- Botón hamburguesa -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarOpciones"
            aria-controls="navbarOpciones" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list text-white fs-3"></i> <!-- Ícono hamburguesa -->
        </button>

        <!-- Contenido colapsable -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarOpciones">
            <ul class="navbar-nav align-items-center">
                <!-- Inicio -->
                <li class="nav-item">
                    <a class="btn btn-primary ms-2 my-1" href="{{ route('inicio') }}">
                        <i class="bi bi-house text-white"></i>
                    </a>
                </li>

                <!-- Carrito -->
                <li class="nav-item position-relative">
                    <a class="btn btn-primary ms-2 my-1 position-relative" data-bs-toggle="modal"
                        data-bs-target="#carritoModal">
                        <i class="bi bi-cart-fill text-white"></i>
                        <span id="cart-count"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.6rem; display: none;">
                            0
                        </span>
                    </a>
                </li>

                <!-- Cotizador -->
                <li class="nav-item">
                    <a class="btn btn-primary ms-2 my-1" href="{{ route('cotizador_ventanas') }}">
                        <i class="bi bi-calculator text-white"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<header class="header">
    <div class="container overlay">
        <h1>ALUVID IXMIQUILPAN</h1>
        <p>Calidad y diseño en cada detalle</p>
    </div>
</header>

<!-- Modal -->
<div class="modal fade" id="carritoModal" tabindex="-1" aria-labelledby="carritoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="carritoModalLabel">Carrito de compras</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Contenedor con scroll interno -->
            <div class="modal-body" id="carrito-contenido" style="max-height: 400px; overflow-y: auto;">
                <!-- Aquí se cargará el carrito -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="vaciarCarrito()">
                    <i class="bi bi-cart-x-fill"></i> Vaciar carrito
                </button>
                <a href="{{ route('liquidar') }}" class="btn btn-primary">
                    <i class="bi bi-credit-card"></i> Realizar pago
                </a>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('js/carrito_open.js') }}"></script>
