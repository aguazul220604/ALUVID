document.addEventListener("DOMContentLoaded", function () {
    const modal_cotizador = document.getElementById("cotizadorModal");

    // Mostrar productos en el modal
    modal_cotizador.addEventListener("show.bs.modal", function () {
        const carrito_cotizador =
            JSON.parse(localStorage.getItem("carrito")) || [];
        const contenedor = document.getElementById("cotizador-contenido");
        contenedor.innerHTML = "";

        if (carrito_cotizador.length === 0) {
            contenedor.innerHTML = "<p>El cotizador está vacío</p>";
            return;
        }

        carrito_cotizador.forEach((producto, index) => {
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
                <button class="btn btn-sm btn-danger ms-2 cotizador-contenido-cotizador" data-index="${index}" title="Eliminar">
                    <i class="bi bi-trash"></i>
                </button>
            `;

            item.innerHTML = contenido;
            contenedor.appendChild(item);
        });

        // Agregar eventos de eliminar
        document
            .querySelectorAll(".cotizador-contenido-cotizador")
            .forEach((btn) => {
                btn.addEventListener("click", function () {
                    const index = parseInt(this.getAttribute("data-index"));
                    eliminarProductoCotizador(index);
                });
            });
    });

    // Contador inicial
    actualizarContadorCotizador();
});

// Eliminar un producto específico del carrito (cotizador)
function eliminarProductoCotizador(index) {
    const carrito_cotizador = JSON.parse(localStorage.getItem("carrito")) || [];

    if (index >= 0 && index < carrito_cotizador.length) {
        carrito_cotizador.splice(index, 1);
        localStorage.setItem("carrito", JSON.stringify(carrito_cotizador));

        // ✅ Actualizar ambos contadores
        actualizarContadorCarrito(); // Esta función también llama a actualizarContadorCotizador()

        // Recargar el contenido del modal sin cerrarlo
        const modal_cotizador = bootstrap.Modal.getInstance(
            document.getElementById("cotizadorModal")
        );
        if (modal_cotizador) {
            document
                .getElementById("cotizadorModal")
                .dispatchEvent(new Event("show.bs.modal"));
        }
    }
}

// Actualizar contador del cotizador
function actualizarContadorCotizador() {
    const carrito_cotizador = JSON.parse(localStorage.getItem("carrito")) || [];
    const contador_cotizador = document.getElementById("cotizador-count");

    if (!contador_cotizador) return;

    if (carrito_cotizador.length === 0) {
        contador_cotizador.style.display = "none";
    } else {
        contador_cotizador.innerText = carrito_cotizador.length;
        contador_cotizador.style.display = "inline-block";
    }
}

function confirmarCotizacion(cliente) {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    fetch(RUTA_COTIZACION, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": TOKEN_LARAVEL_COTIZACION,
        },
        body: JSON.stringify({
            carrito,
            cliente,
        }),
    })
        .then((response) => response.blob())
        .then((blob) => {
            const url = window.URL.createObjectURL(blob);
            window.open(url, "_blank");
        })
        .catch((error) => {
            console.error("Error al generar cotización:", error);
        });
}
