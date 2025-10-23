@extends('layouts.client')

@section('title', 'Catálogo de aluminios')

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
                    @foreach ($lineas_aluminio as $linea)
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
            @foreach ($productos_aluminio as $producto_aluminio)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3 flex-shrink-0">
                                <img src="{{ asset($producto_aluminio->imagen) }}" alt="{{ $producto_aluminio->producto }}"
                                    class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1"><strong>Código: </strong>{{ $producto_aluminio->codigo }}</p>
                                <h5 class="card-title mb-2">{{ $producto_aluminio->producto }}</h5>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('ficha_tecnica_aluminios', $producto_aluminio->id) }}"
                                        class="btn btn-secondary btn-sm"><i class="bi bi-info-circle-fill"></i>
                                        Información</a>
                                    <button class="btn btn-primary btn-sm agregar-carrito"
                                        data-id="{{ $producto_aluminio->id }}"
                                        data-codigo="{{ $producto_aluminio->codigo }}"
                                        data-producto="{{ $producto_aluminio->producto }}"
                                        data-preciop="{{ $producto_aluminio->precio_pieza }}"
                                        data-imagen="{{ asset($producto_aluminio->imagen) }}"
                                        data-stock="{{ $producto_aluminio->stock_cantidad }}"
                                        data-idc="{{ $producto_aluminio->idc }}">
                                        <i class="bi bi-cart-fill text-white"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($productos_aluminio->isEmpty())
                <div class="col-12 text-center">
                    <p>No se encontraron productos.</p>
                </div>
            @endif
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $productos_aluminio->links() }}
            </div>
        </div>

    </div>
    <div id="pagination" class="mt-4"></div>

    <x-footer-client />

@endsection

<script>
    window.seriesAluminio = @json($tipos_aluminio);
</script>
<script>
    const fichaTecnicaUrl = @json(route('ficha_tecnica_aluminios', ['id' => '__ID__']));
</script>
<script src="{{ asset('js/catalogo_aluminio.js') }}"></script>
<script src="{{ asset('js/producto_aluminio_carrito.js') }}"></script>
