document.addEventListener("DOMContentLoaded", () => {
    // Manejar botones desde catálogo
    document.querySelectorAll(".agregar-carrito").forEach((boton) => {
        boton.addEventListener("click", function () {
            const stock = parseInt(this.dataset.stock);
            const cantidad = 1;

            if (stock < cantidad) {
                Swal.fire({
                    icon: "error",
                    title: "Stock insuficiente",
                    text: "No hay suficiente stock para agregar este producto.",
                    timer: 2000,
                    showConfirmButton: false,
                });
                return;
            }

            agregarProductoAlCarrito({
                id: this.dataset.id,
                codigo: this.dataset.codigo,
                producto: this.dataset.producto,
                preciop: parseFloat(this.dataset.preciop),
                imagen: this.dataset.imagen,
                cantidad: cantidad,
                stock: this.dataset.stock,
                idc: this.dataset.idc,
            });
        });
    });

    // Manejar botón desde ficha técnica
    const botonAgregarFicha = document.getElementById("btn-agregar-ficha");
    if (botonAgregarFicha) {
        botonAgregarFicha.addEventListener("click", function () {
            const cantidadInput = document.querySelector(
                'input[type="number"]'
            );

            const stock = parseInt(this.dataset.stock);
            const cantidad = parseInt(cantidadInput.value) || 1;

            if (stock < cantidad) {
                Swal.fire({
                    icon: "error",
                    title: "Stock insuficiente",
                    text: "No hay suficiente stock para agregar este producto.",
                    timer: 2000,
                    showConfirmButton: false,
                });
                return;
            }

            agregarProductoAlCarrito({
                id: this.dataset.id,
                codigo: this.dataset.codigo,
                producto: this.dataset.producto,
                preciop: parseFloat(this.dataset.preciop),
                imagen: this.dataset.imagen,
                cantidad: cantidad,
                stock: this.dataset.stock,
                idc: this.dataset.idc,
            });
        });
    }

    actualizarContadorCarrito();
});

// Función común para agregar productos
function agregarProductoAlCarrito(producto) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    const existe = carrito.find(
        (item) => item.id == producto.id && item.idc == producto.idc
    );

    if (existe) {
        Swal.fire({
            icon: "warning",
            title: "Producto ya agregado",
            text: producto.producto,
            timer: 1500,
            showConfirmButton: false,
        });
    } else {
        carrito.push(producto);
        localStorage.setItem("carrito", JSON.stringify(carrito));

        Swal.fire({
            icon: "success",
            title: "Producto agregado",
            text: producto.producto,
            timer: 1500,
            showConfirmButton: false,
        });

        actualizarContadorCarrito();
        actualizarContadorCotizador();
    }
}

// Función para actualizar el badge del carrito
function actualizarContadorCarrito() {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    const contador = document.getElementById("cart-count");

    if (!contador) return; // Si no hay badge, no hacemos nada

    if (carrito.length === 0) {
        contador.style.display = "none";
    } else {
        contador.innerText = carrito.length; // Solo productos únicos
        contador.style.display = "inline-block";
    }
}
