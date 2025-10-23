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
                <select name="tonalidad" id="tonalidad" class="form-select">
                    <option value="">
                        Todas las tonalidades</option>
                    @foreach ($vidrio_tonalidades as $tonalidad)
                        <option value="{{ $tonalidad->id }}">
                            {{ $tonalidad->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-5 mb-3">
                <select name="mm" id="mm" class="form-select">
                    <option value="">
                        Todas las medidas</option>
                    @foreach ($vidrio_mm as $mm)
                        <option value="{{ $mm->id }}">
                            {{ $mm->mm }} mm</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Cards de Productos -->
        <div id="product-cards" class="row px-3">
            <!-- Card 1 -->
            @foreach ($productos_vidrio as $producto_vidrio)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3 flex-shrink-0">
                                <img src="{{ asset($producto_vidrio->imagen) }}" alt="{{ $producto_vidrio->tonalidad }}"
                                    class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-2">{{ $producto_vidrio->tonalidad }}</h5>
                                <p>{{ $producto_vidrio->mm }} mm</p>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('ficha_tecnica_vidrios', $producto_vidrio->id) }}"
                                        class="btn btn-secondary btn-sm"><i class="bi bi-info-circle-fill"></i>
                                        Información</a>
                                    <button class="btn btn-primary btn-sm agregar-carrito"
                                        data-id="{{ $producto_vidrio->id }}"
                                        data-tonalidad="{{ $producto_vidrio->tonalidad }}"
                                        data-mm="{{ $producto_vidrio->mm }}"
                                        data-precioh="{{ $producto_vidrio->precio_hoja }}"
                                        data-imagen="{{ asset($producto_vidrio->imagen) }}"
                                        data-stock="{{ $producto_vidrio->stock_cantidad }}"
                                        data-idc="{{ $producto_vidrio->idc }}">
                                        <i class="bi bi-cart-fill text-white"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($productos_vidrio->isEmpty())
                <div class="col-12 text-center">
                    <p>No se encontraron productos.</p>
                </div>
            @endif
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $productos_vidrio->links() }}
            </div>
        </div>

    </div>
    <div id="pagination" class="mt-4"></div>

    <x-footer-client />
@endsection
<script>
    const fichaTecnicaUrl = @json(route('ficha_tecnica_vidrios', ['id' => '__ID__']));
</script>
<script src="{{ asset('js/catalogo_vidrios.js') }}"></script>
<script src="{{ asset('js/producto_vidrios_carrito.js') }}"></script>
