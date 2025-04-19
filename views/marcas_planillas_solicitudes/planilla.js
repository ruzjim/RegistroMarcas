function cargarPlanilla() {
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
                <td>${persona.Hora_entrada}</td>
                <td>
                  <button class="btn btn-sm btn-warning editar-btn" data-cedula="${persona.Cedula}">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger eliminar-btn" data-cedula="${persona.Cedula}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </td>
              </tr>
            `;
          tbody.append(fila);
        });
      }
    },
  });
}

// Guardar Persona (solo agregar)
$("#formAgregarPersona").on("submit", function (e) {
  e.preventDefault();

  const nuevaPersona = {
    nombre: $("#nombre").val(),
    apellido: $("#apellido").val(),
    edad: $("#edad").val(),
    cedula: $("#cedula").val(),
    hora_entrada: $("#hora_entrada").val(),
  };

  $.ajax({
    url: "agregar_persona_planilla.php", // Solo usamos el archivo de agregar
    method: "POST",
    data: nuevaPersona,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.status === "ok") {
        Swal.fire("Éxito", respuesta.mensaje, "success");
        $("#modalAgregarPersona").modal("hide");
        $("#formAgregarPersona")[0].reset();
        cargarPlanilla();
      } else {
        Swal.fire("Error", respuesta.mensaje, "error");
      }
    },
    error: function () {
      Swal.fire("Error", "No se pudo guardar la persona", "error");
    },
  });
});

$(document).on("click", ".editar-btn", function () {
  const cedula = $(this).data("cedula");

  $.ajax({
    url: "planillas.php",
    method: "GET",
    data: { cedula: cedula }, // ¡Aquí pasamos la cédula!
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.status === "ok") {
        const persona = respuesta.datos;

        $("#editar_nombre").val(persona.Nombre);
        $("#editar_apellido").val(persona.Apellido);
        $("#editar_edad").val(persona.Edad);
        $("#editar_cedula").val(persona.Cedula);
        $("#editar_hora_entrada").val(persona.Hora_entrada);
        $("#editar_ausencias").val(persona.Ausencias);
        $("#editar_tardias").val(persona.Tardias);
        const modalEditar = new bootstrap.Modal(
          document.getElementById("modalEditarPersona")
        );
        modalEditar.show();
      } else {
        Swal.fire("Error", respuesta.mensaje, "error");
      }
    },
    error: function () {
      Swal.fire(
        "Error",
        "No se pudo obtener la información de la persona",
        "error"
      );
    },
  });
});

$("#formEditarPersona").on("submit", function (e) {
  e.preventDefault();

  const personaEditada = {
    nombre: $("#editar_nombre").val(),
    apellido: $("#editar_apellido").val(),
    edad: $("#editar_edad").val(),
    cedula: $("#editar_cedula").val(),
    hora_entrada: $("#editar_hora_entrada").val(),
    ausencias: $("#editar_ausencias").val(),
    tardias: $("#editar_tardias").val()
  };

  $.ajax({
    url: "editar_persona_planilla.php",
    method: "POST",
    data: personaEditada,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.status === "ok") {
        Swal.fire("Éxito", respuesta.mensaje, "success");
        $("#modalEditarPersona").modal("hide");
        cargarPlanilla();
      } else {
        Swal.fire("Error", respuesta.mensaje, "error");
      }
    },
    error: function () {
      Swal.fire("Error", "No se pudo actualizar la persona", "error");
    },
  });
});



$(document).on("click", ".eliminar-btn", function () {
  const cedula = $(this).data("cedula");

  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡Esto eliminará a la persona de la planilla!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "eliminar_persona_planilla.php",
        method: "POST",
        data: { cedula: cedula },
        dataType: "json",
        success: function (respuesta) {
          if (respuesta.status === "ok") {
            Swal.fire("Eliminado", respuesta.mensaje, "success");
            cargarPlanilla();
          } else {
            Swal.fire("Error", respuesta.mensaje, "error");
          }
        },
        error: function () {
          Swal.fire("Error", "No se pudo eliminar a la persona", "error");
        },
      });
    }
  });
});

$(document).ready(function () {
  cargarPlanilla();
});
