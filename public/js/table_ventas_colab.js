$(document).ready(function () {
    const tabla = $("#tabla_ventas").DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
        },
        pageLength: 9,
        stripeClasses: [],
        dom: "Bfrtip",
        order: [[8, "desc"]],
    });

    // Filtro personalizado por fecha
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const filtro = $("#filtroFecha").val();
        const fechaStr = data[8];

        if (!fechaStr || !filtro) return true; // No hay filtro, mostrar todo

        const hoy = new Date();
        const fechaVenta = new Date(fechaStr);

        if (filtro === "dia") {
            return fechaVenta.toDateString() === hoy.toDateString();
        }

        if (filtro === "semana") {
            const primerDiaSemana = new Date(
                hoy.setDate(hoy.getDate() - hoy.getDay())
            );
            const ultimoDiaSemana = new Date(primerDiaSemana);
            ultimoDiaSemana.setDate(primerDiaSemana.getDate() + 6);

            return (
                fechaVenta >= primerDiaSemana && fechaVenta <= ultimoDiaSemana
            );
        }

        if (filtro === "mes") {
            return (
                fechaVenta.getMonth() === hoy.getMonth() &&
                fechaVenta.getFullYear() === hoy.getFullYear()
            );
        }

        return true;
    });

    // Evento cambio de filtro
    $("#filtroFecha").on("change", function () {
        tabla.draw(); // Recalcular la tabla con el filtro aplicado
    });
});
