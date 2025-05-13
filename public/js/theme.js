// Función para establecer el tema
function setTheme(themeName) {
  localStorage.setItem("theme", themeName);
  document.documentElement.setAttribute("data-theme", themeName);

  // Actualizar los estilos de Bootstrap para el modo oscuro
  if (themeName === "dark") {
    // Ajustar estilos de las tarjetas para el modo oscuro
    document.querySelectorAll(".card").forEach((card) => {
      card.style.backgroundColor = "#1e1e1e";
      card.style.borderColor = "#2c2c2c";
    });

    // Ajustar estilos de los textos para el modo oscuro
    document
      .querySelectorAll(".card-title, .card-text, h1, h2, h3, h4, h5, h6")
      .forEach((text) => {
        if (
          !text.classList.contains("text-primary") &&
          !text.classList.contains("text-success") &&
          !text.classList.contains("text-danger") &&
          !text.classList.contains("text-warning") &&
          !text.classList.contains("text-info")
        ) {
          text.style.color = "#e0e0e0";
        }
      });

    // Ajustar estilos de los contenedores de imágenes para el modo oscuro
    document
      .querySelectorAll(".card-img-top, .product-image-container")
      .forEach((imgContainer) => {
        imgContainer.style.backgroundColor = "#1e1e1e";
        imgContainer.style.borderColor = "#2c2c2c";
      });

    // Ajustar estilos de las imágenes de vista previa
    document.querySelectorAll(".img-thumbnail").forEach((img) => {
      img.style.backgroundColor = "#1e1e1e";
      img.style.borderColor = "#2c2c2c";
    });

    // Ajustar estilos de los dropdowns para el modo oscuro
    document.querySelectorAll(".dropdown-menu").forEach((menu) => {
      menu.style.backgroundColor = "#2c2c2c";
      menu.style.borderColor = "rgba(255,255,255,.15)";
    });

    document.querySelectorAll(".dropdown-item").forEach((item) => {
      item.style.color = "#e0e0e0";
    });
  } else {
    // Restaurar estilos por defecto para el modo claro
    document
      .querySelectorAll(
        ".card, .card-title, .card-text, h1, h2, h3, h4, h5, h6, .dropdown-menu, .dropdown-item, .card-img-top, .product-image-container, .img-thumbnail"
      )
      .forEach((element) => {
        element.style.removeProperty("background-color");
        element.style.removeProperty("border-color");
        element.style.removeProperty("color");
      });
  }
}

// Función para alternar entre temas
function toggleTheme() {
  // Prevent interference with Bootstrap dropdowns
  event.stopPropagation();

  if (localStorage.getItem("theme") === "dark") {
    setTheme("light");
  } else {
    setTheme("dark");
  }
}

// Función para detectar la preferencia del sistema
function detectPreferredTheme() {
  // Verificar si hay una preferencia guardada
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme) {
    return savedTheme;
  }

  // Verificar preferencia del sistema
  if (
    window.matchMedia &&
    window.matchMedia("(prefers-color-scheme: dark)").matches
  ) {
    return "dark";
  }

  return "light";
}

// Inicializar tema al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  // Establecer tema inicial
  setTheme(detectPreferredTheme());

  // Configurar el botón de toggle
  const themeToggle = document.getElementById("themeToggle");
  if (themeToggle) {
    themeToggle.addEventListener("click", toggleTheme);
  }

  // Escuchar cambios en la preferencia del sistema
  if (window.matchMedia) {
    window
      .matchMedia("(prefers-color-scheme: dark)")
      .addEventListener("change", (e) => {
        if (!localStorage.getItem("theme")) {
          setTheme(e.matches ? "dark" : "light");
        }
      });
  }

  // Aplicar el tema actual a los elementos existentes
  if (localStorage.getItem("theme") === "dark") {
    document.querySelectorAll(".card").forEach((card) => {
      card.style.backgroundColor = "#1e1e1e";
      card.style.borderColor = "#2c2c2c";
    });

    document
      .querySelectorAll(".card-title, .card-text, h1, h2, h3, h4, h5, h6")
      .forEach((text) => {
        if (
          !text.classList.contains("text-primary") &&
          !text.classList.contains("text-success") &&
          !text.classList.contains("text-danger") &&
          !text.classList.contains("text-warning") &&
          !text.classList.contains("text-info")
        ) {
          text.style.color = "#e0e0e0";
        }
      });
  }
});
