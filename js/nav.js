// Cargar el nav en el contenedor de la pagina que lo llamen
fetch("../../components/nav.html")
  .then((response) => response.text())
  .then((data) => {
    console.log(data);

    document.getElementById("nav-container").innerHTML = data;
  })
  .catch((error) => console.error("Error al cargar el nav:", error));

// $.ajax({
//   url: "components/nav.html",
//   method: "GET",
//   success: function (data) {
//     $("#nav-container").html(data);
//   },
//   error: function (error) {
//     console.error("Error al cargar el nav:", error);
//   },
// });
