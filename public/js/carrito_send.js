function confirmarCompra(datosCliente) {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    if (carrito.length === 0) {
        Swal.fire({
            icon: "warning",
            title: "Carrito vacío",
            text: "Agrega productos antes de continuar",
            timer: 2000,
            showConfirmButton: false,
        });
        return;
    }

    fetch(RUTA_LIQUIDAR, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": TOKEN_LARAVEL,
        },
        body: JSON.stringify({
            carrito: carrito,
            cliente: datosCliente,
        }),
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Pedido procesado",
                    html: `Muchas gracias por su preferencia`,
                }).then(() => {
                    localStorage.removeItem("carrito");
                    actualizarContadorCarrito();
                    // Descargar el PDF automáticamente
                    const link = document.createElement("a");
                    link.href = `/aluvid/nota/${data.venta_id}`;
                    link.download = `pedido_${data.venta_id}.pdf`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    // Redirigir después de unos segundos
                    setTimeout(() => {
                        window.location.href = "/aluvid/inicio";
                    }, 3000);
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message,
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            Swal.fire({
                icon: "error",
                title: "Error de red",
                text: "No se pudo procesar tu solicitud",
            });
        });
}
