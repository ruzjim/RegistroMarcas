<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante</title>
</head>
<body>
    SOLICITUD CREADA
    <br>
    <br>
    Solicitud del empleado: 
    <?php echo($_POST["Datos"]);?>
    <br>
    Correo del empleado: 
    <?php echo($_POST["email"]);?>
    <br>
    Tipo de solicitud: 
    <?php echo($_POST["tipo"]);?>
    <br>
    Dia que inicia: 
    <?php echo($_POST["fechas"]);?>
    <br>
    Dia que termina: 
    <?php echo($_POST["fechae"]);?>
    <br>
    <button><a href="Solicitudes.html">Cerrar</a></button>
</body>
</html>