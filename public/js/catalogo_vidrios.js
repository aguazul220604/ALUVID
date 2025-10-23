document.addEventListener("DOMContentLoaded", () => {
    const tonalidadSelect = document.getElementById("tonalidad");
    const medidaSelect = document.getElementById("mm");

    function resetSelect(selectElement, texto) {
        selectElement.value = "";
        const defaultOption = selectElement.querySelector("option[value='']");
        if (defaultOption) defaultOption.textContent = texto;
    }

    function cargarProductos(tonalidad, mm, page = 1, search = "") {
        let url = `/catalogo-vidrios/filtrar?page=${page}`;
        if (tonalidad) url += `&tonalidad=${tonalidad}`;
        if (mm) url += `&mm=${mm}`;
        if (search) url += `&search=${encodeURIComponent(search)}`;

        fetch(url)
            .then((res) => res.json())
            .then((response) => {
                const productos = response.data;
                const links = response.links;
                const productCards = document.getElementById("product-cards");
                const paginacion = document.getElementById("pagination");

                productCards.innerHTML = "";

                if (productos.length === 0) {
                    productCards.innerHTML =
                        "<p class='text-center'>No se encontraron productos</p>";
                    paginacion.innerHTML = "";
                    return;
                }

                productos.forEach((producto) => {
                    const card = `
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3 flex-shrink-0">
                                        <img src="/${producto.imagen}" alt="${
                        producto.producto
                    }"
                                            class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-2">${
                                            producto.tonalidad
                                        }</h5>

                                     <p>${producto.mm} mm</p>
                                        <div class="d-flex gap-2">
                                            <a href="${fichaTecnicaUrl.replace(
                                                "__ID__",
                                                producto.id
                                            )}"
                                               class="btn btn-secondary btn-sm"><i class="bi bi-info-circle-fill"></i>
                                               Información</a>
                                           <button class="btn btn-primary btn-sm agregar-carrito"
                                                   data-id="${producto.id}"
                                                   data-tonalidad="${
                                                       producto.tonalidad
                                                   }"
                                                   data-mm="${producto.mm}"
                                                   data-precioh="${
                                                       producto.precioh
                                                   }"
                                                   data-imagen="/${
                                                       producto.imagen
                                                   }"
                                                   data-stock="${
                                                       producto.stock_cantidad
                                                   }"
                                                   data-idc="${producto.idc}">
                                               <i class="bi bi-cart-fill text-white"></i> Agregar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    productCards.innerHTML += card;
                });

                renderPaginacion(links, tonalidad, mm, search);
                registrarEventosCarrito();
            });
    }

    function renderPaginacion(links, tonalidad, mm, search = "") {
        const paginacion = document.getElementById("pagination");
        paginacion.innerHTML = "";

        if (links.last_page <= 1) return;

        let html = '<nav><ul class="pagination justify-content-center">';

        html += `<li class="page-item ${
            links.current_page === 1 ? "disabled" : ""
        }">
        <a class="page-link" href="#" data-page="${
            links.current_page - 1
        }">&lsaquo;</a>
    </li>`;

        for (let page = 1; page <= links.last_page; page++) {
            html += `<li class="page-item ${
                page === links.current_page ? "active" : ""
            }">
            <a class="page-link" href="#" data-page="${page}">${page}</a>
        </li>`;
        }

        html += `<li class="page-item ${
            links.current_page === links.last_page ? "disabled" : ""
        }">
        <a class="page-link" href="#" data-page="${
            links.current_page + 1
        }">&rsaquo;</a>
    </li>`;

        html += "</ul></nav><br>";
        paginacion.innerHTML = html;

        // ⚠️ Aquí es clave mantener tonalidad/mm/search aunque sean null
        paginacion.querySelectorAll("a.page-link").forEach((link) => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const page = parseInt(e.target.getAttribute("data-page"));
                if (page >= 1 && page <= links.last_page) {
                    cargarProductos(tonalidad, mm, page, search); // <- aquí está la magia
                }
            });
        });
    }

    function registrarEventosCarrito() {
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
                    tonalidad: this.dataset.tonalidad,
                    mm: this.dataset.mm,
                    precioh: parseFloat(this.dataset.precioh),
                    imagen: this.dataset.imagen,
                    cantidad: cantidad,
                    stock: this.dataset.stock,
                    idc: this.dataset.idc,
                });
            });
        });
    }

    // Manejador para tonalidad
    tonalidadSelect.addEventListener("change", function () {
        const tonalidadSeleccionada = this.value;

        // Si seleccionó una tonalidad, resetea medida a "Todas"
        if (tonalidadSeleccionada) {
            resetSelect(medidaSelect, "Todas las medidas");
            cargarProductos(tonalidadSeleccionada, null);
        } else {
            cargarProductos(null, null);
        }
    });

    // Manejador para medida
    medidaSelect.addEventListener("change", function () {
        const medidaSeleccionada = this.value;

        // Si seleccionó una medida, resetea tonalidad a "Todas"
        if (medidaSeleccionada) {
            resetSelect(tonalidadSelect, "Todas las tonalidades");
            cargarProductos(null, medidaSeleccionada);
        } else {
            cargarProductos(null, null);
        }
    });

    // Búsqueda (se mantiene igual)
    const searchInput = document.getElementById("search");
    const searchIcon = document.getElementById("search-icon");

    searchInput.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            const search = searchInput.value.trim();
            cargarProductos(null, null, 1, search);
        }
    });

    searchIcon.addEventListener("click", function () {
        const search = searchInput.value.trim();
        cargarProductos(null, null, 1, search);
    });
});
