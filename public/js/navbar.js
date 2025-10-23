document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".pcoded-item li");

    // Obtener la página activa guardada en localStorage
    const activePage = localStorage.getItem("activeMenu");

    menuItems.forEach((item) => {
        const link = item.querySelector("a");
        if (link) {
            const href = link.getAttribute("href");

            // Marcar como activo si coincide con la última opción seleccionada
            if (href === activePage) {
                item.classList.add("active");
            }

            item.addEventListener("click", function () {
                // Remover la clase 'active' de todos los elementos
                menuItems.forEach((li) => li.classList.remove("active"));

                this.classList.add("active");

                localStorage.setItem("activeMenu", href);
            });
        }
    });
});
