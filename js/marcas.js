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
document.getElementById("btn-marca").addEventListener("click", function () {
  const cedula = document.getElementById("cedula").value.trim();
  const tipo = this.textContent.trim(); // Entrada o Salida

  if (cedula === "") {
    Swal.fire("Cuidado", "Debe ingresar la cédula", "warning");
    return;
  }

  $.post(
    "../marcas_planillas_solicitudes/registrar_marca.php",
    { cedula, tipo },
    function (response) {
      try {
        const res = JSON.parse(response);
        if (res.status === "ok") {
          Swal.fire("Listo", res.msg, "success");
          document.getElementById("cedula").value = "";
        } else {
          Swal.fire("Error", res.msg, "error");
        }
      } catch (err) {
        console.error(err);
        Swal.fire("Error", "Ocurrió un error inesperado", "error");
      }
    }
  );
});

// Actualizar botón en la carga de la página
updateButton();
