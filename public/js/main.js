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
          // Quitar la clase 'selected' de la talla previamente seleccionada
          if (selectedSize) {
            selectedSize.classList.remove("selected");
          }

          // Añadir la clase 'selected' a la talla actual
          option.classList.add("selected");
          selectedSize = option;

          // Habilitar el botón de añadir al carrito
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

  // Obtener información del producto
  const productName = productElement.querySelector("h3").innerText;
  const productPrice = Number.parseFloat(
    productElement.querySelector("p").innerText.replace("€", "")
  );
  const productId = Number.parseInt(
    productElement.getAttribute("data-product-id")
  );

  // Verificar que se haya seleccionado una talla
  const sizeOption = productElement.querySelector(".size-option.selected");
  if (!sizeOption) {
    alert("Por favor, selecciona una talla");
    return;
  }
  const productSize = sizeOption.innerText;

  // Crear objeto del producto
  const product = {
    id: productId,
    name: productName,
    price: productPrice,
    size: productSize,
  };

  // Obtener carrito actual o crear uno nuevo
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart.push(product);
  localStorage.setItem("cart", JSON.stringify(cart));

  // Mostrar mensaje de confirmación
  const toast = document.createElement("div");
  toast.className = "position-fixed bottom-0 end-0 p-3";
  toast.style.zIndex = "11";
  toast.innerHTML = `
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <strong class="me-auto">Carrito</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        <strong>${productName}</strong> (Talla: ${productSize}) añadido al carrito.
      </div>
    </div>
  `;
  document.body.appendChild(toast);

  // Eliminar el toast después de 3 segundos
  setTimeout(() => {
    toast.remove();
  }, 3000);
}

// Función para manejar el formulario de compra
function setupPurchaseForm() {
  const form = document.getElementById("formCompra");
  if (form) {
    form.addEventListener("submit", handleFormSubmit);
  }
}

function handleFormSubmit(event) {
  event.preventDefault();

  const nombre = document.getElementById("nombre").value;
  const email = document.getElementById("email").value;
  const direccion = document.getElementById("direccion").value;
  const telefono = document.getElementById("telefono").value;

  if (!nombre || !email || !direccion || !telefono) {
    alert("Por favor, completa todos los campos");
    return;
  }

  const datos = {
    nombre,
    email,
    direccion,
    telefono,
    carrito: getCart(),
  };

  datos.carrito = datos.carrito.map((item) => ({
    ...item,
    quantity: 1,
    id: item.id || null,
  }));

  fetch("procesar_pedido.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    credentials: "include",
    body: JSON.stringify(datos),
  })
    .then((response) => response.json())
    .then((jsonResponse) => {
      if (jsonResponse.success) {
        localStorage.removeItem("cart");
        window.location.href = "confirmacion.php";
      } else {
        alert("Error al procesar el pedido: " + jsonResponse.message);
      }
    })
    .catch((error) => {
      console.error("Error al enviar los datos:", error);
    });
}

// Función para obtener el carrito desde localStorage
function getCart() {
  return JSON.parse(localStorage.getItem("cart")) || [];
}

// Función para actualizar vista previa en formulario de creación/edición
function actualizarVistaPrevia() {
  const nombreInput = document.querySelector('input[name="nombre"]');
  const precioInput = document.querySelector('input[name="precio"]');
  const tallasInput = document.querySelector('input[name="tallas"]');
  const imagenInput = document.querySelector('input[name="imagen"]');

  if (!nombreInput || !precioInput) return;

  // Actualizar el nombre y precio
  const previewNombre = document.getElementById("preview-nombre");
  const previewPrecio = document.getElementById("preview-precio");

  if (previewNombre) previewNombre.textContent = " " + nombreInput.value;
  if (previewPrecio) previewPrecio.textContent = " " + precioInput.value + " €";

  // Convertir las tallas separadas por comas a un formato con espacios
  if (tallasInput && document.getElementById("preview-tallas")) {
    const tallasArray = tallasInput.value
      .split(",")
      .map((talla) => talla.trim()); // Convertir a array y quitar espacios
    document.getElementById("preview-tallas").textContent =
      " " + tallasArray.join(" "); // Unir las tallas con un espacio
  }

  // Mostrar imagen de vista previa
  if (
    imagenInput &&
    imagenInput.files[0] &&
    document.getElementById("preview-image")
  ) {
    const reader = new FileReader();
    reader.onload = (e) => {
      document.getElementById("preview-image").src = e.target.result;
    };
    reader.readAsDataURL(imagenInput.files[0]);
  }
}

// Añadir eventos para actualizar vista previa al escribir en los campos
document.addEventListener("DOMContentLoaded", () => {
  const nombreInput = document.querySelector('input[name="nombre"]');
  const precioInput = document.querySelector('input[name="precio"]');
  const tallasInput = document.querySelector('input[name="tallas"]');
  const imagenInput = document.querySelector('input[name="imagen"]');

  if (nombreInput) nombreInput.addEventListener("input", actualizarVistaPrevia);
  if (precioInput) precioInput.addEventListener("input", actualizarVistaPrevia);
  if (tallasInput) tallasInput.addEventListener("input", actualizarVistaPrevia);
  if (imagenInput)
    imagenInput.addEventListener("change", actualizarVistaPrevia);

  // Llamar a la función de vista previa al cargar la página para que se inicialice
  actualizarVistaPrevia();
});
