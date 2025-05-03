document.addEventListener("DOMContentLoaded", () => {
  renderCart();
});

// Función para obtener el carrito desde localStorage
function getCart() {
  return JSON.parse(localStorage.getItem("cart")) || [];
}

// Función para guardar el carrito en localStorage
function saveCart(cart) {
  localStorage.setItem("cart", JSON.stringify(cart));
}

// Función para renderizar el carrito en la página
function renderCart() {
  const cart = getCart();
  const cartItemsContainer = document.getElementById("cart-items");
  const totalPriceElement = document.getElementById("total-price");

  if (!cartItemsContainer || !totalPriceElement) return;

  cartItemsContainer.innerHTML = ""; // Limpiar contenedor antes de renderizar

  if (cart.length === 0) {
    cartItemsContainer.innerHTML = "<p>No hay productos en el carrito.</p>";
  } else {
    cart.forEach((product, index) => {
      const productElement = document.createElement("div");
      productElement.classList.add("cart-item");

      productElement.innerHTML = `
        <p>${product.name} - ${product.size} - ${product.price}€</p>
        <i class="fas fa-trash-alt" data-index="${index}"></i> 
      `;

      cartItemsContainer.appendChild(productElement);
    });

    updateTotalPrice(cart);
    setupRemoveButtons();
  }
}

// Función para actualizar el precio total
function updateTotalPrice(cart) {
  const totalPriceElement = document.getElementById("total-price");
  if (!totalPriceElement) return;

  const totalPrice = cart.reduce((total, product) => total + product.price, 0);
  totalPriceElement.innerText = `Total: ${totalPrice.toFixed(2)}€`;
}

// Función para configurar los botones de eliminar
function setupRemoveButtons() {
  document.querySelectorAll(".fa-trash-alt").forEach((icon) => {
    icon.addEventListener("click", () => {
      removeFromCart(icon.getAttribute("data-index"));
    });
  });
}

// Función para eliminar un producto del carrito
function removeFromCart(index) {
  let cart = getCart();
  cart.splice(index, 1);
  saveCart(cart);
  renderCart();
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
  const productElement = event.target.closest(".product");
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

  let cart = getCart();
  cart.push(product);
  saveCart(cart);

  alert("Producto añadido al carrito");
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

  let datos = {
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

// Ejecutar cuando el DOM haya cargado
document.addEventListener("DOMContentLoaded", setupAddToCart);
