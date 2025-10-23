document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("carritoModal");

    // Mostrar productos en el modal
    modal.addEventListener("show.bs.modal", function () {
        const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
        const contenedor = document.getElementById("carrito-contenido");
        contenedor.innerHTML = "";

        if (carrito.length === 0) {
            contenedor.innerHTML = "<p>El carrito está vacío</p>";
            return;
        }

        carrito.forEach((producto, index) => {
            const item = document.createElement("div");
            item.classList.add(
                "d-flex",
                "justify-content-between",
                "align-items-center",
                "mb-2"
            );

            let contenido = "";

            if (producto.idc === "3") {
                // Producto de vidrio
                contenido = `
                    <div class="d-flex align-items-center">
                        <img src="${producto.imagen}" alt="${producto.tonalidad}" style="width:50px; height:50px; object-fit:cover; margin-right:10px;">
                        <div>
                            <p class="mb-0"><strong>VIDRIO ${producto.tonalidad} ${producto.mm} mm</strong></p>
                        </div>
                    </div>
                `;
            } else {
                // Aluminio o Herrajes
                contenido = `
                    <div class="d-flex align-items-center">
                        <img src="${producto.imagen}" alt="${producto.producto}" style="width:50px; height:50px; object-fit:cover; margin-right:10px;">
                        <div>
                            <p class="mb-0"><strong>${producto.producto}</strong></p>
                        </div>
                    </div>
                `;
            }

            // Botón eliminar
            contenido += `
                <button class="btn btn-sm btn-danger ms-2 eliminar-producto" data-index="${index}" title="Eliminar">
                    <i class="bi bi-trash"></i>
                </button>
            `;

            item.innerHTML = contenido;
            contenedor.appendChild(item);
        });

        // Agregar eventos de eliminar
        document.querySelectorAll(".eliminar-producto").forEach((btn) => {
            btn.addEventListener("click", function () {
                const index = parseInt(this.getAttribute("data-index"));
                eliminarProductoCarrito(index);
            });
        });
    });

    // Contador inicial
    actualizarContadorCarrito();
});

// Eliminar un producto específico del carrito
function eliminarProductoCarrito(index) {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    if (index >= 0 && index < carrito.length) {
        carrito.splice(index, 1);
        localStorage.setItem("carrito", JSON.stringify(carrito));
        actualizarContadorCarrito();

        // Recargar el contenido del modal sin cerrarlo
        const modal = bootstrap.Modal.getInstance(
            document.getElementById("carritoModal")
        );
        if (modal) {
            document
                .getElementById("carritoModal")
                .dispatchEvent(new Event("show.bs.modal"));
        }
    }
}

// Vaciar todo el carrito
function vaciarCarrito() {
    localStorage.removeItem("carrito");
    actualizarContadorCarrito();

    Swal.fire({
        icon: "info",
        title: "Carrito vacío",
        timer: 1500,
        showConfirmButton: false,
    }).then(() => {
        location.reload(); // Recargar la página actual
    });
}

// Actualizar contador del carrito
function actualizarContadorCarrito() {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    const contador = document.getElementById("cart-count");

    actualizarContadorCotizador();

    if (!contador) return;

    if (carrito.length === 0) {
        contador.style.display = "none";
    } else {
        contador.innerText = carrito.length;
        contador.style.display = "inline-block";
    }
}
