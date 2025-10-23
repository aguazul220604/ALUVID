document.addEventListener("DOMContentLoaded", () => {
    const series = window.seriesAluminio;

    const lineaSelect = document.getElementById("linea");
    const serieSelect = document.getElementById("serie");
    const productCards = document.getElementById("product-cards");

    function cargarProductos(linea, serie, page = 1, search = "") {
        let url = `/catalogo-aluminios/filtrar?page=${page}`;
        if (linea) url += `&linea=${linea}`;
        if (serie) url += `&serie=${serie}`;
        if (search) url += `&search=${encodeURIComponent(search)}`;

        fetch(url)
            .then((res) => res.json())
            .then((response) => {
                const productos = response.data;
                const links = response.links;
                const paginacion = document.getElementById("pagination");

                productCards.innerHTML = ""; // limpiar

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
                                        <p class="mb-1"><strong>Código: </strong>${
                                            producto.codigo
                                        }</p>
                                        <h5 class="card-title mb-2">${
                                            producto.producto
                                        }</h5>
                                        <div class="d-flex gap-2">
                                            <!-- Aquí uso la URL generada en el script -->
                                            <a href="${fichaTecnicaUrl.replace(
                                                "__ID__",
                                                producto.id
                                            )}"
                                               class="btn btn-secondary btn-sm"><i class="bi bi-info-circle-fill"></i>
                                               Información</a>
                                           <button class="btn btn-primary btn-sm agregar-carrito"
                                                   data-id="${producto.id}"
                                                   data-codigo="${
                                                       producto.codigo
                                                   }"
                                                   data-producto="${
                                                       producto.producto
                                                   }"
                                                   data-preciop="${
                                                       producto.precio_pieza
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

                renderPaginacion(links, linea, serie, search); // <- pasa también search aquí

                registrarEventosCarrito();
            });
    }

    function renderPaginacion(links, linea, serie, search = "") {
        const paginacion = document.getElementById("pagination");
        paginacion.innerHTML = ""; // Limpiar

        if (links.last_page <= 1) {
            return;
        }

        let html = '<nav><ul class="pagination justify-content-center">';

        html += `<li class="page-item ${
            links.current_page === 1 ? "disabled" : ""
        }">
                    <a class="page-link" href="#" data-page="${
                        links.current_page - 1
                    }">&lsaquo;</a>
                 </li>`;

        for (let page = 1; page <= links.last_page; page++) {
            if (page === links.current_page) {
                html += `<li class="page-item active">
                            <span class="page-link">${page}</span>
                         </li>`;
            } else {
                html += `<li class="page-item">
                            <a class="page-link" href="#" data-page="${page}">${page}</a>
                         </li>`;
            }
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

        paginacion.querySelectorAll("a.page-link").forEach((link) => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const page = parseInt(e.target.getAttribute("data-page"));
                if (page >= 1 && page <= links.last_page) {
                    cargarProductos(linea, serie, page, search);
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
    }

    if (lineaSelect && serieSelect) {
        lineaSelect.addEventListener("change", function () {
            const lineaSeleccionada = this.value;

            // Limpiar y rellenar select de series
            serieSelect.innerHTML =
                '<option value="" selected disabled>Seleccione la serie</option>';
            const seriesFiltradas = series.filter(
                (s) => s.id_linea == lineaSeleccionada
            );
            seriesFiltradas.forEach((s) => {
                const option = document.createElement("option");
                option.value = s.id_serie;
                option.textContent = s.serie;
                serieSelect.appendChild(option);
            });

            // Cargar productos solo con línea seleccionada
            cargarProductos(lineaSeleccionada, null);
        });

        serieSelect.addEventListener("change", function () {
            const lineaSeleccionada = lineaSelect.value;
            const serieSeleccionada = this.value;

            // Cargar productos filtrando por línea y serie
            cargarProductos(lineaSeleccionada, serieSeleccionada);
        });
    }

    const searchInput = document.getElementById("search");
    const searchIcon = document.getElementById("search-icon");

    searchInput.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            const search = searchInput.value.trim();
            cargarProductos(null, null, 1, search); // Búsqueda nueva
        }
    });

    searchIcon.addEventListener("click", function () {
        const search = searchInput.value.trim();
        cargarProductos(null, null, 1, search); // Búsqueda nueva
    });
});
