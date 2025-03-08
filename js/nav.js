
// Cargar el nav en el contenedor de la pagina que lo llamen
    fetch('components/nav.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('nav-container').innerHTML = data;
        })
        .catch(error => console.error('Error al cargar el nav:', error));


        prueba();
        function prueba(){
            console.log('prueba');
            
        }