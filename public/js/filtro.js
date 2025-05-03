const form = document.getElementById("filtroForm");
const minInput = document.getElementById("minPrecio");
const maxInput = document.getElementById("maxPrecio");
const ordenSelect = document.getElementById("orden");
const minValor = document.getElementById("minValor");
const maxValor = document.getElementById("maxValor");
const sliderTrack = document.querySelector(".slider-track");
let debounceTimer;

function actualizarValores() {
  let min = parseInt(minInput.value);
  let max = parseInt(maxInput.value);

  // Evitar que se solapen los valores
  if (min > max - 10) {
    minInput.value = max - 10;
    min = max - 10;
  }
  if (max < min + 10) {
    maxInput.value = min + 10;
    max = min + 10;
  }

  minValor.textContent = min + " €";
  maxValor.textContent = max + " €";

  // Ajustar la barra visual del rango
  let minPos = (min / 250) * 100;
  let maxPos = (max / 250) * 100;
  sliderTrack.style.left = minPos + "%";
  sliderTrack.style.right = 100 - maxPos + "%";

  // Usar debounce para evitar envíos múltiples seguidos
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    form.submit();
  }, 500);
}

// Adjuntar los eventos
minInput.addEventListener("input", actualizarValores);
maxInput.addEventListener("input", actualizarValores);

ordenSelect.addEventListener("change", () => {
  form.submit();
});
