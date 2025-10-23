document.addEventListener("DOMContentLoaded", () => {
    mostrarProductosPorCategoria();
});

function mostrarProductosPorCategoria() {
    const contenedor = document.getElementById("contenedor");
    contenedor.innerHTML = "";

    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    const categorias = {
        1: { nombre: "Aluminios", productos: [] },
        2: { nombre: "Herrajes", productos: [] },
        3: { nombre: "Vidrios", productos: [] },
    };

    let totalGeneral = 0;

    carrito.forEach((producto, index) => {
        const idc = parseInt(producto.idc);
        if (categorias[idc]) {
            categorias[idc].productos.push({ ...producto, index });
        }
    });

    for (const [idc, categoria] of Object.entries(categorias)) {
        if (categoria.productos.length > 0) {
            const titulo = document.createElement("h3");
            titulo.textContent = categoria.nombre;
            contenedor.appendChild(titulo);

            const tabla = document.createElement("table");
            tabla.border = "1";
            tabla.style.width = "100%";
            tabla.innerHTML = `
                <thead>
                    <tr>
                        <th class="titulo">Imagen</th>
                        <th class="titulo">Producto</th>
                        <th class="titulo">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            `;

            const tbody = tabla.querySelector("tbody");

            categoria.productos.forEach((prod) => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
<td style="width: 60px; text-align: center; vertical-align: top;">
    <img src="${prod.imagen}" alt="producto" width="50">
</td>
<td style="width: 100%; vertical-align: top;">
    <div style="display: flex; flex-direction: column; gap: 5px;">
        <div style="font-weight: bold;">${
            prod.producto ||
            prod.tonalidad + " " + prod.mm + "mm" ||
            "Sin nombre"
        }</div>
        <div class="detalle-tabla-container"></div>
    </div>
</td>
<td style="width: 180px; text-align: center; vertical-align: middle;">
    <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
        <button class="btn btn-danger btn-sm " onclick="modificarCantidad(${
            prod.index
        }, 'restar')"><i class="bi bi-dash-circle"></i></button>
        <span id="cantidad-${
            prod.index
        }" style="min-width: 20px; text-align: center;">${prod.cantidad}</span>
        <button class="btn btn-primary btn-sm" onclick="modificarCantidad(${
            prod.index
        }, 'sumar')"><i class="bi bi-plus-circle"></i></button>
        <button class="btn btn-outline-danger btn-sm ms-3" onclick="eliminarProducto(${
            prod.index
        })" style="margin-left: 8px;"><i class="bi bi-trash3-fill"></i></button>
    </div>
</td>

`;
                tbody.appendChild(fila);

                // Fila vacía reservada para tabla futura
                const filaDetalle = document.createElement("tr");
                filaDetalle.innerHTML = `
    <td colspan="4" style="padding: 10px 0;">
        <div style="min-height: 60px; background-color: #f9f9f9; border-top: 1px solid #ccc;">
            <!-- Aquí puedes insertar una subtabla o información adicional -->
        </div>
    </td>
`;
                const tablaInterna = document.createElement("table");
                tablaInterna.style.width = "100%";
                tablaInterna.style.border = "1px solid #ccc";
                tablaInterna.style.marginTop = "5px";
                tablaInterna.style.fontSize = "0.9em";
                tablaInterna.style.borderCollapse = "collapse";
                tablaInterna.style.maxWidth = "400px";
                tablaInterna.style.boxShadow = "0 0 5px rgba(0,0,0,0.1)";
                if (parseInt(idc) === 1) {
                    // Generar tabla con desglose de piezas
                    const piezas = prod.cantidad;
                    const subtotalPiezas = piezas * prod.preciop;
                    totalGeneral += subtotalPiezas;

                    const tablaInterna = document.createElement("table");
                    tablaInterna.style.width = "100%";
                    tablaInterna.style.border = "1px solid #ccc";
                    tablaInterna.style.marginTop = "10px";
                    tablaInterna.innerHTML = `
        <thead>
            <tr>
                <th>Piezas (6m)</th>
                <th>Precio por pieza</th>
                <th>Subtotal piezas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">${piezas}</td>
                <td style="text-align: center;">${prod.preciop.toLocaleString(
                    "es-MX",
                    {
                        style: "currency",
                        currency: "MXN",
                    }
                )}</td>
                <td style="text-align: center;"><strong>${subtotalPiezas.toLocaleString(
                    "es-MX",
                    {
                        style: "currency",
                        currency: "MXN",
                    }
                )}</strong></td>
            </tr>
        </tbody>
    `;

                    fila.querySelector(".detalle-tabla-container").appendChild(
                        tablaInterna
                    );
                } else if (parseInt(idc) === 2) {
                    const precioUnitario = prod.precio;
                    const subtotal = precioUnitario * prod.cantidad;
                    totalGeneral += subtotal;

                    const tablaInterna = document.createElement("table");
                    tablaInterna.style.width = "100%";
                    tablaInterna.style.border = "1px solid #ccc";
                    tablaInterna.style.marginTop = "10px";
                    tablaInterna.innerHTML = `
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">${prod.cantidad}</td>
                <td style="text-align: center;">${precioUnitario.toLocaleString(
                    "es-MX",
                    {
                        style: "currency",
                        currency: "MXN",
                    }
                )}</td>
                <td style="text-align: center;"><strong>${subtotal.toLocaleString(
                    "es-MX",
                    {
                        style: "currency",
                        currency: "MXN",
                    }
                )}</strong></td>
            </tr>
        </tbody>
    `;

                    fila.querySelector(".detalle-tabla-container").appendChild(
                        tablaInterna
                    );
                } else if (parseInt(idc) === 3) {
                    const hojas = prod.cantidad;
                    const precioHoja = prod.precioh;
                    const subtotalHojas = hojas * precioHoja;
                    totalGeneral += subtotalHojas;

                    const tablaInterna = document.createElement("table");
                    tablaInterna.style.width = "100%";
                    tablaInterna.style.border = "1px solid #ccc";
                    tablaInterna.style.marginTop = "10px";
                    tablaInterna.innerHTML = `
        <thead>
            <tr>
                <th>Hojas (4m²)</th>
                <th>Precio por hoja</th>
                <th>Subtotal hojas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">${hojas}</td>
                <td style="text-align: center;">${precioHoja.toLocaleString(
                    "es-MX",
                    {
                        style: "currency",
                        currency: "MXN",
                    }
                )}</td>
              <td style="text-align: center;"><strong>${subtotalHojas.toLocaleString(
                  "es-MX",
                  {
                      style: "currency",
                      currency: "MXN",
                  }
              )}</strong></td>
            </tr>
        </tbody>
    `;

                    fila.querySelector(".detalle-tabla-container").appendChild(
                        tablaInterna
                    );
                }
            });

            contenedor.appendChild(tabla);
        }
    }
    document.getElementById("total").textContent = totalGeneral.toLocaleString(
        "es-MX",
        {
            style: "currency",
            currency: "MXN",
        }
    );
}

function modificarCantidad(index, accion) {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    const producto = carrito[index];
    const stockDisponible = parseInt(producto.stock);

    if (accion === "sumar") {
        if (producto.cantidad + 1 > stockDisponible) {
            Swal.fire({
                icon: "warning",
                title: "¡Stock insuficiente!",
                text: `Solo hay ${stockDisponible} unidades disponibles.`,
                timer: 2000,
                showConfirmButton: false,
            });
            return;
        }
        producto.cantidad += 1;
    } else if (accion === "restar") {
        producto.cantidad -= 1;

        if (producto.cantidad <= 0) {
            carrito.splice(index, 1);

            Swal.fire({
                icon: "success",
                title: "Producto eliminado",
                timer: 1500,
                showConfirmButton: false,
            });
        }
    }

    localStorage.setItem("carrito", JSON.stringify(carrito));
    mostrarProductosPorCategoria();
    actualizarContadorCarrito();
}

function eliminarProducto(index) {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    const producto = carrito[index];

    Swal.fire({
        title: "¿Eliminar producto?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            carrito.splice(index, 1);
            localStorage.setItem("carrito", JSON.stringify(carrito));
            mostrarProductosPorCategoria();
            actualizarContadorCarrito();

            Swal.fire({
                icon: "success",
                title: "Producto eliminado",
                timer: 1500,
                showConfirmButton: false,
            });
        }
    });
}
