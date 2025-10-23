@extends('layouts.client')

@section('title', 'Catálogo')

@section('content')
    <x-navbar-client />

    <x-catalogo-info-box />

    <!-- Container más ancho -->
    <div class="container-fluid mt-5">

        <!-- Barra de Búsqueda -->
        <div class="row justify-content-center mb-4 px-3">
            <div class="col-12 col-md-10">
                <div class="input-group">
                    <input type="text" class="form-control" id="search" placeholder="Buscar productos..."
                        aria-label="Buscar productos" aria-describedby="search-icon">
                    <span class="input-group-text" id="search-icon">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>
        </div>

        <!-- Filtros (Selects) -->
        <div class="row justify-content-center mb-4 px-3">
            <div class="col-12 col-md-5 mb-3">
                <select name="linea" id="linea" class="form-select">
                    <option value="">
                        Todos los productos</option>
                    @foreach ($lineas_herrajes as $linea)
                        <option value="{{ $linea->id }}">
                            {{ $linea->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-5 mb-3">
                <select name="serie" id="serie" class="form-select">
                    <option value="" selected disabled>
                        Seleccione la serie</option>
                </select>
            </div>
        </div>

        <!-- Cards de Productos -->
        <div id="product-cards" class="row px-3">
            <!-- Card 1 -->
            @foreach ($productos_herrajes as $producto_herrajes)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3 flex-shrink-0">
                                <img src="{{ asset($producto_herrajes->imagen) }}" alt="{{ $producto_herrajes->producto }}"
                                    class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1"><strong>Código: </strong>{{ $producto_herrajes->codigo }}</p>
                                <h5 class="card-title mb-2">{{ $producto_herrajes->producto }}</h5>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('ficha_tecnica_herrajes', $producto_herrajes->id) }}"
                                        class="btn btn-secondary btn-sm"><i class="bi bi-info-circle-fill"></i>
                                        Información</a>
                                    <button class="btn btn-primary btn-sm agregar-carrito"
                                        data-id="{{ $producto_herrajes->id }}"
                                        data-codigo="{{ $producto_herrajes->codigo }}"
                                        data-producto="{{ $producto_herrajes->producto }}"
                                        data-precio="{{ $producto_herrajes->precio }}"
                                        data-imagen="{{ asset($producto_herrajes->imagen) }}"
                                        data-stock="{{ $producto_herrajes->stock_cantidad }}"
                                        data-idc="{{ $producto_herrajes->idc }}">
                                        <i class="bi bi-cart-fill text-white"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($productos_herrajes->isEmpty())
                <div class="col-12 text-center">
                    <p>No se encontraron productos.</p>
                </div>
            @endif
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $productos_herrajes->links() }}
            </div>
        </div>

    </div>
    <div id="pagination" class="mt-4"></div>

    <x-footer-client />

@endsection

<script>
    window.seriesHerrajes = @json($tipos_herrajes);
</script>
<script>
    const fichaTecnicaUrl = @json(route('ficha_tecnica_herrajes', ['id' => '__ID__']));
</script>
<script src="{{ asset('js/catalogo_herrajes.js') }}"></script>
<script src="{{ asset('js/producto_herrajes_carrito.js') }}"></script>
