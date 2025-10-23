$(document).ready(function () {
    const tabla = $("#tabla_aluminio").DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
        },
        pageLength: 6,
        stripeClasses: [],
        dom: "Bfrtip",
    });

    const series = window.seriesAluminio;
    const serieSelect = document.getElementById("filtroSerie");

    // Desactiva select de serie al inicio
    serieSelect.disabled = true;

    // Filtro por serie
    $("#filtroSerie").on("change", function () {
        const valor = this.value;

        if (valor) {
            tabla
                .column(4)
                .search("^" + valor + "$", true, false)
                .draw();
        } else {
            tabla.column(4).search("").draw();
        }
    });

    // Filtro por línea
    $("#filtroLinea").on("change", function () {
        const lineaSeleccionada = this.value;

        // Limpiar filtro de serie en la tabla
        tabla.column(4).search("").draw();

        // Limpiar y desactivar el select de serie
        serieSelect.innerHTML =
            '<option value="" selected disabled>Seleccione la serie</option>';
        serieSelect.disabled = true;

        if (lineaSeleccionada) {
            // Aplicar filtro de línea
            tabla
                .column(5)
                .search("^" + lineaSeleccionada + "$", true, false)
                .draw();

            // Activar y poblar select de series si hay series para la línea
            const seriesFiltradas = series.filter(
                (s) => s.linea === lineaSeleccionada
            );
            if (seriesFiltradas.length > 0) {
                serieSelect.disabled = false;
                seriesFiltradas.forEach((s) => {
                    const option = document.createElement("option");
                    option.value = s.serie;
                    option.textContent = s.serie;
                    serieSelect.appendChild(option);
                });
            }
        } else {
            tabla.column(4).search("").draw(); // Serie
            tabla.column(5).search("").draw(); // Línea
        }
    });
});
