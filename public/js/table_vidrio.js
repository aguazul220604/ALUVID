$(document).ready(function () {
    var tabla = $("#tabla_vidrio").DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
        },
        pageLength: 6,
        stripeClasses: [],
        dom: "Bfrtip",
    });

    // Filtro por tonalidad
    $("#filtroTonalidad").on("change", function () {
        const valor = this.value;
        if (valor) {
            tabla
                .column(1)
                .search("^" + valor + "$", true, false)
                .draw();
        } else {
            tabla.column(1).search("").draw();
        }
    });

    // Filtro por medida
    $("#filtroMedida").on("change", function () {
        const valor = this.value;
        if (valor) {
            tabla
                .column(2)
                .search("^" + valor + "$", true, false)
                .draw();
        } else {
            tabla.column(2).search("").draw();
        }
    });

    $(".formEliminar").submit(function (e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            text: "¿Desea eliminar el registro?",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#6c757d",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#d33",
            confirmButtonText: "Eliminar",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    text: "Registro eliminado exitosamente",
                    icon: "success",
                    confirmButtonColor: "#00532C",
                    showConfirmButton: true,
                }).then(() => {
                    form.submit();
                });
            }
        });
    });
});
