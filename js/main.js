document.addEventListener("DOMContentLoaded", () => {
  setupSizeSelection();
  setupAddToCart();
  setupPurchaseForm();
});

// Función para manejar la selección de tallas
function setupSizeSelection() {
  document
    .querySelectorAll(".product, .product-details-flex")
    .forEach((productElement) => {
      const sizeOptions = productElement.querySelectorAll(".size-option");
      const addToCartButton = productElement.querySelector(".add-to-cart");

      if (!sizeOptions.length || !addToCartButton) return;

      let selectedSize = null;

      sizeOptions.forEach((option) => {
        option.addEventListener("click", () => {
          if (selectedSize) {
            selectedSize.classList.remove("selected");
          }

          option.classList.add("selected");
          selectedSize = option;

          addToCartButton.disabled = false;
        });
      });

      // Deshabilitar el botón hasta que se seleccione una talla
      addToCartButton.disabled = true;
    });
}

// Función para manejar la adición de productos al carrito
function setupAddToCart() {
  document.querySelectorAll(".add-to-cart").forEach((button) => {
    button.addEventListener("click", (event) => {
      addToCart(event);
    });
  });
}

function addToCart(event) {
  const productElement = event.target.closest(
    ".product, .product-details-flex"
  );

  const productName = productElement.querySelector("h3").innerText;
  const productPrice = parseFloat(
    productElement.querySelector("p").innerText.replace("€", "")
  );
  const productId = parseInt(productElement.getAttribute("data-product-id"));

  const sizeOption = productElement.querySelector(".size-option.selected");
  if (!sizeOption) {
    alert("Por favor, selecciona una talla");
    return;
  }
  const productSize = sizeOption.innerText;

  const product = {
    id: productId,
    name: productName,
    price: productPrice,
    size: productSize,
  };

  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart.push(product);
  localStorage.setItem("cart", JSON.stringify(cart));

  alert("Producto añadido al carrito");
}

function actualizarVistaPrevia() {
  const nombre = document.querySelector('input[name="nombre"]').value;
  const precio = document.querySelector('input[name="precio"]').value;
  const tallas = document.querySelector('input[name="tallas"]').value;
  const imagen = document.querySelector('input[name="imagen"]').files[0];

  // Actualizar el nombre y precio
  document.getElementById("preview-nombre").textContent = " " + nombre;
  document.getElementById("preview-precio").textContent = " " + precio + " €";

  // Convertir las tallas separadas por comas a un formato con espacios
  const tallasArray = tallas.split(",").map((talla) => talla.trim()); // Convertir a array y quitar espacios
  document.getElementById("preview-tallas").textContent =
    " " + tallasArray.join(" "); // Unir las tallas con un espacio

  // Mostrar imagen de vista previa
  if (imagen) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("preview-image").src = e.target.result;
    };
    reader.readAsDataURL(imagen);
  }
}

// Añadir eventos para actualizar vista previa al escribir en los campos
document
  .querySelector('input[name="nombre"]')
  .addEventListener("input", actualizarVistaPrevia);
document
  .querySelector('input[name="precio"]')
  .addEventListener("input", actualizarVistaPrevia);
document
  .querySelector('input[name="tallas"]')
  .addEventListener("input", actualizarVistaPrevia);
document
  .querySelector('input[name="imagen"]')
  .addEventListener("change", actualizarVistaPrevia);

// Llamar a la función de vista previa al cargar la página para que se inicialice
window.addEventListener("load", actualizarVistaPrevia);
