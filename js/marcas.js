// Función para actualizar el reloj
function updateClock() {
  const now = new Date();
  const hours = now.getHours().toString().padStart(2, "0");
  const minutes = now.getMinutes().toString().padStart(2, "0");
  const seconds = now.getSeconds().toString().padStart(2, "0");
  document.getElementById("clock").innerText = `${hours}:${minutes}:${seconds}`;
}

// Actualizar cada segundo
setInterval(updateClock, 1000);
updateClock();

// Función para actualizar el botón según la hora
function updateButton() {
  const now = new Date();
  const button = document.getElementById("btn-marca");

  if (now.getHours() < 12) {
    button.textContent = "Entrada";
    button.classList.remove("btn-danger");
    button.classList.add("btn-primary");
  } else {
    button.textContent = "Salida";
    button.classList.remove("btn-primary");
    button.classList.add("btn-danger");
  }
}

// Actualizar botón en la carga de la página
updateButton();
