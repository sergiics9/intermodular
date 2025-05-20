document.addEventListener("DOMContentLoaded", () => {
  // Elementos del DOM
  const sortDropdown = document.getElementById("sort-dropdown");
  const sortOptions = document.querySelectorAll(".sort-option");
  const currentSortText = document.getElementById("current-sort-text");
  const productsContainer = document.getElementById("products-container");

  if (!sortDropdown || !productsContainer) return;

  // Función para actualizar la URL con el parámetro de ordenación
  function updateUrlWithSort(sort) {
    const url = new URL(window.location.href);
    url.searchParams.set("sort", sort);
    window.location.href = url.toString();
  }

  // Manejar clics en las opciones de ordenación
  sortOptions.forEach((option) => {
    option.addEventListener("click", function (e) {
      e.preventDefault();
      const sort = this.getAttribute("data-sort");

      // Guardar preferencia en localStorage
      localStorage.setItem("productSortPreference", sort);

      // Actualizar la URL y recargar la página
      updateUrlWithSort(sort);
    });
  });

  // Cargar preferencia guardada al iniciar
  const savedSort = localStorage.getItem("productSortPreference");
  if (savedSort) {
    // Verificar si ya hay un parámetro de ordenación en la URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentSort = urlParams.get("sort");

    // Si no hay un parámetro de ordenación en la URL, usar la preferencia guardada
    if (!currentSort) {
      updateUrlWithSort(savedSort);
    }
  }
});
