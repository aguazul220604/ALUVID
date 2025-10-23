@extends('layouts.client')

@section('title', 'Liquidación de carrito')

<style>
    table {
        border-collapse: collapse;
        margin-bottom: 2rem;
        width: 100%;
    }

    th,
    td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    th {
        background-color: #b3b3b3;
        text-align: center;
        color: rgb(41, 41, 41);
    }

    button {
        margin: 0 2px;
    }

    .titulo {
        background-color: #001d4a;
        text-align: center;
        color: rgb(255, 255, 255);
    }
</style>


@section('content')
    <x-navbar-client />

    <div class="container my-4">
        <section class="about-section">
            <div class="container">
                <h2 class="mb-5">Resumen de tu carrito</h2>
            </div>
        </section>

        <div id="contenedor"></div>

        <div class="mt-4">
            <h3>Total a pagar: <span id="total">0.00</span></h3>
            <a href="{{ route('catalogo_aluminios') }}" class="btn btn-secondary"><i class="bi bi-cart-fill text-white"></i>
                Seguir comprando</a>

            <button class="btn btn-primary" onclick="mostrarModal()">
                <i class="bi bi-check-square-fill"></i> Confirmar pedido
            </button>

        </div>

        <script>
            function mostrarModal() {
                const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
                if (carrito.length === 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "Carrito vacío",
                        text: "Agrega productos antes de continuar.",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                    return;
                }

                const hoy = new Date().toISOString().split('T')[0];
                Swal.fire({
                    title: 'Datos del cliente',
                    html: `
        <div style="text-align: left;">
            <label for="swal-nombre">Nombre</label>
            <input id="swal-nombre" class="swal2-input" placeholder="Escribe tu nombre">

            <label for="swal-apellido">Apellido</label>
            <input id="swal-apellido" class="swal2-input" placeholder="Escribe tu apellido">

            <label for="swal-telefono">Teléfono</label>
            <input id="swal-telefono" class="swal2-input" placeholder="Ej. 7711234567">

            <label for="swal-fecha">Fecha de retiro</label>
            <input id="swal-fecha" type="date" class="swal2-input" min="${hoy}">

            <label for="swal-hora">Hora de retiro</label>
            <input id="swal-hora" type="time" class="swal2-input">

        </div>
    `,
                    focusConfirm: false,
                    preConfirm: () => {
                        const nombre = document.getElementById('swal-nombre').value;
                        const apellido = document.getElementById('swal-apellido').value;
                        const telefono = document.getElementById('swal-telefono').value;
                        const fecha = document.getElementById('swal-fecha').value;
                        const hora = document.getElementById('swal-hora').value;

                        if (!nombre || !apellido || !telefono || !fecha || !hora) {
                            Swal.showValidationMessage('Completa todos los campos');
                            return false;
                        }

                        return {
                            nombre,
                            apellido,
                            telefono,
                            fecha,
                            hora
                        };
                    },
                    confirmButtonText: 'Confirmar pedido',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        confirmarCompra(result.value);
                    }
                });
            }
        </script>
    </div>

    <x-footer-client />
@endsection
<script src="{{ asset('js/carrito_liquidar.js') }}"></script>
<script>
    const RUTA_LIQUIDAR = "{{ route('liquidar_procesar') }}";
    const TOKEN_LARAVEL = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/carrito_send.js') }}"></script>
