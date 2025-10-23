@extends('layouts.client')

@section('title', 'Cotizador de ventanas')

@section('content')
    <x-navbar-client />

    <div class="container my-4">
        <section class="about-section">
            <div class="container">
                <h2 class="mb-5">Cotizador de ventanas</h2>
            </div>
        </section>
    </div>



    <div x-data="aberturasApp()" class="container py-4">

        <!-- Select de aberturas -->
        <div class="mb-4">
            <label for="aberturaSelect" class="form-label fw-bold">Modelos de aberturas</label>
            <select id="aberturaSelect" class="form-select w-100" x-model="selected">
                <option value="" disabled>Seleccionar abertura</option>
                <template x-for="abertura in aberturas" :key="abertura.id">
                    <option :value="abertura.id" x-text="abertura.descripcion"></option>
                </template>
            </select>
        </div>

        <!-- Imagen y descripción de la abertura -->
        <div class="text-center mb-4" x-show="selected !== ''">
            <template x-for="abertura in aberturas" :key="'img-' + abertura.id">
                <div x-show="selected == abertura.id">
                    <img :src="'/' + abertura.imagen" class="img-fluid rounded shadow mb-2" style="max-height: 400px;">
                    <p class="fw-semibold fs-5" x-text="abertura.descripcion"></p>
                </div>
            </template>
        </div>

        <!-- Información técnica -->
        <div class="border p-4 rounded bg-light" x-show="selected !== ''">
            <h5 class="mb-3">Detalles técnicos</h5>

            <div class="mb-4">
                <label for="baseSelect" class="form-label fw-bold">Medidas de la base</label>
                <template x-for="abertura in aberturas" :key="'img-' + abertura.id">
                    <div x-show="selected == abertura.id">
                        <p class="fw-semibold fs-5" x-text="abertura.base"></p>
                    </div>
                </template>
            </div>

            <!-- Tabla de componentes de aluminio -->
            <div class="mt-4" x-show="aluminiosPorAbertura[selected]">
                <h6>Componentes de Aluminio</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Código</th>
                            <th>Precio (m)</th>
                            <th>Longitud</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="comp in aluminiosPorAbertura[selected]" :key="comp.id">
                            <tr>
                                <td><img :src="'/' + comp.imagen" width="60"></td>
                                <td x-text="comp.producto"></td>
                                <td x-text="comp.codigo"></td>
                                <td x-text="comp.precio"></td>
                                <td>longitud</td>
                                <td x-text="comp.cantidad_producto_aluminio"></td>
                                <td>sutotal</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Tabla de componentes de herrajes -->
            <div class="mt-4" x-show="herrajesPorAbertura[selected]">
                <h6>Componentes de Herrajes</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Código</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="comp in herrajesPorAbertura[selected]" :key="comp.id">
                            <tr>
                                <td><img :src="'/' + comp.imagen" width="60"></td>
                                <td x-text="comp.producto"></td>
                                <td x-text="comp.codigo"></td>
                                <td x-text="comp.precio"></td>
                                <td x-text="comp.cantidad_producto_herrajes"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script Alpine.js -->
    <script>
        function aberturasApp() {
            return {
                selected: '',
                aberturas: @json($aberturas),
                aluminiosPorAbertura: @json($aluminiosPorAbertura),
                herrajesPorAbertura: @json($herrajesPorAbertura),
            }
        }
    </script>
    <x-footer-client />
@endsection
<script src="{{ asset('js/producto_aluminio_carrito.js') }}"></script>
<script src="https://unpkg.com/alpinejs" defer></script>
