document.addEventListener("DOMContentLoaded", () => {
    const series = window.seriesAluminio;

    // FORMULARIO DE CREACIÓN
    const lineaSelect = document.getElementById("linea");
    const serieSelect = document.getElementById("serie");

    if (lineaSelect && serieSelect) {
        lineaSelect.addEventListener("change", function () {
            const lineaSeleccionada = this.value;

            // Reiniciar el select de serie
            serieSelect.innerHTML =
                '<option value="" selected disabled>Seleccione la serie</option>';

            // Filtrar y mostrar series
            const seriesFiltradas = series.filter(
                (s) => s.id_linea == lineaSeleccionada
            );
            seriesFiltradas.forEach((s) => {
                const option = document.createElement("option");
                option.value = s.id_serie;
                option.textContent = s.serie;
                serieSelect.appendChild(option);
            });
        });
    }

    // FORMULARIOS DE EDICIÓN
    document
        .querySelectorAll('select[id^="linea_update_"]')
        .forEach((lineaSelectUpdate) => {
            lineaSelectUpdate.addEventListener("change", function () {
                const productoId = this.id.replace("linea_update_", "");
                const serieSelectUpdate = document.getElementById(
                    `serie_update_${productoId}`
                );
                const lineaSeleccionada = this.value;

                if (serieSelectUpdate) {
                    // Reiniciar el select de serie
                    serieSelectUpdate.innerHTML =
                        '<option value="" selected disabled>Seleccione la serie</option>';

                    // Filtrar y mostrar series
                    const seriesFiltradas = series.filter(
                        (s) => s.id_linea == lineaSeleccionada
                    );
                    seriesFiltradas.forEach((s) => {
                        const option = document.createElement("option");
                        option.value = s.id_serie;
                        option.textContent = s.serie;
                        serieSelectUpdate.appendChild(option);
                    });
                }
            });
        });
});
