@extends('layouts.client')

@section('title', 'Ficha técnica')

@section('content')
    <x-navbar-client />

    <div class="container my-4">

        <section class="about-section">
            <div class="container">
                <h2 class="mb-5">Ficha técnica del producto</h2>
            </div>
        </section>

        <div class="row align-items-stretch">
            <div class="col-12 col-md-4 mb-3">
                <div class="p-4 rounded text-center h-100">
                    <img src="{{ asset($producto_aluminio[0]->imagen) }}" class="img-thumbnail"
                        style="width: 100%; max-width: 250px; height: 250px; object-fit: cover;" alt="Aluminio5">
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3 d-flex justify-content-center align-items-center">
                <div class="p-4 rounded h-100">
                    <p class="card-text mb-4">
                        <strong>Código: </strong>{{ $producto_aluminio[0]->codigo }}
                        <BR></BR>
                        <strong>Producto: </strong>{{ $producto_aluminio[0]->producto }}
                        <BR></BR>
                        <strong>Precio: </strong>$ {{ $producto_aluminio[0]->precio }}
                        <BR></BR>
                        <strong>Línea: </strong>{{ $producto_aluminio[0]->linea }}
                        <BR></BR>
                        <strong>Serie: </strong>{{ $producto_aluminio[0]->serie }}
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="p-4 rounded text-center h-100 d-flex flex-column justify-content-center align-items-center">
                    <input type="number" class="form-control mb-3 text-center" placeholder="Cantidad" style="width: 200px;"
                        min="1">
                    <button id="btn-agregar-ficha" class="btn btn-primary mb-3" style="width: 200px;"
                        data-id="{{ $producto_aluminio[0]->id }}" data-codigo="{{ $producto_aluminio[0]->codigo }}"
                        data-producto="{{ $producto_aluminio[0]->producto }}"
                        data-precio="{{ $producto_aluminio[0]->precio }}"
                        data-preciop="{{ $producto_aluminio[0]->precio_pieza }}"
                        data-imagen="{{ asset($producto_aluminio[0]->imagen) }}"
                        data-stock="{{ $producto_aluminio[0]->stock_cantidad }}"
                        data-idc="{{ $producto_aluminio[0]->idc }}">
                        <i class="bi bi-cart-fill text-white"></i> Agregar al carrito
                    </button>
                    <a href="{{ route('catalogo_aluminios') }}" class="btn btn-secondary" style="width: 200px;">
                        <i class="bi bi-arrow-left-square-fill"></i> Regresar al
                        catálogo</a>
                </div>
            </div>


        </div>

    </div>

    <x-footer-client />
@endsection
<script src="{{ asset('js/producto_aluminio_carrito.js') }}"></script>
