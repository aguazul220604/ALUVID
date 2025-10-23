$(document).ready(function () {
    $(".tabla-dinamica").DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
        },
        pageLength: 6,
        stripeClasses: [],
        dom: "Bfrtip",
        order: [[0, "asc"]],
        columnDefs: [{ type: "num", targets: 0 }],
    });

    /////////////////////////////////////////////////////////// Vidrios

    $(".formEliminar_tonalidades").submit(function (e) {
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
                    text: "Tonalidad eliminada exitosamente",
                    icon: "success",
                    confirmButtonColor: "#00532C",
                    showConfirmButton: true,
                }).then(() => {
                    form.submit();
                });
            }
        });
    });

    $(".formEliminar_espesor").submit(function (e) {
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
                    text: "Espesor eliminado exitosamente",
                    icon: "success",
                    confirmButtonColor: "#00532C",
                    showConfirmButton: true,
                }).then(() => {
                    form.submit();
                });
            }
        });
    });

    /////////////////////////////////////////////////////////// Aluminios

    $(".formEliminar_serie_aluminio").submit(function (e) {
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
                    text: "Serie eliminada exitosamente",
                    icon: "success",
                    confirmButtonColor: "#00532C",
                    showConfirmButton: true,
                }).then(() => {
                    form.submit();
                });
            }
        });
    });

    $(".formEliminar_linea_aluminio").submit(function (e) {
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
                    text: "Línea eliminada exitosamente",
                    icon: "success",
                    confirmButtonColor: "#00532C",
                    showConfirmButton: true,
                }).then(() => {
                    form.submit();
                });
            }
        });
    });

    /////////////////////////////////////////////////////////// Herrajes

    $(".formEliminar_serie_herrajes").submit(function (e) {
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
                    text: "Serie eliminada exitosamente",
                    icon: "success",
                    confirmButtonColor: "#00532C",
                    showConfirmButton: true,
                }).then(() => {
                    form.submit();
                });
            }
        });
    });

    $(".formEliminar_linea_herrajes").submit(function (e) {
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
                    text: "Línea eliminada exitosamente",
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
