$(document).ready(function () {
  $.ajax({
    url: "planillas.php",
    method: "GET",
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.status === "ok") {
        const tbody = $("#tabla-planilla");
        tbody.empty();

        respuesta.datos.forEach((persona) => {
          const fila = `
                        <tr>
                            <td>${persona.Nombre}</td>
                            <td>${persona.Apellido}</td>
                            <td>${persona.Edad}</td>
                            <td>${persona.Cedula}</td>
                            <td>${persona.Ausencias}</td>
                            <td>${persona.Tardias}</td>
                        </tr>
                    `;
          tbody.append(fila);
        });
      } else {
        Swal.fire("Error", respuesta.mensaje, "error");
      }
    },
    error: function () {
      Swal.fire("Error", "No se pudo cargar la planilla", "error");
    },
  });
});
$("#formAgregarPersona").submit(function (e) {
  e.preventDefault();

  const datos = {
    nombre: $("#nombre").val(),
    apellido: $("#apellido").val(),
    edad: $("#edad").val(),
    cedula: $("#cedula").val(),
  };

  $.ajax({
    url: "agregar_persona_planilla.php",
    method: "POST",
    data: datos,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.status === "ok") {
        Swal.fire("¡Éxito!", respuesta.mensaje, "success");
        $("#modalAgregarPersona").modal("hide");
        $("#formAgregarPersona")[0].reset();
        setTimeout(() => location.reload(), 1000); // O volver a llamar AJAX
      } else {
        Swal.fire("Error", respuesta.mensaje, "error");
      }
    },
    error: function () {
      Swal.fire("Error", "No se pudo guardar la persona", "error");
    },
  });
});
