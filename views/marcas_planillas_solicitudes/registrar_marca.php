<?php
header('Content-Type: application/json');
date_default_timezone_set('America/Costa_Rica');
$host = '82.197.82.143';
$usuario = 'u603397150_AmbWebQ12025';
$password = 'AmbWebQ12025';
$base_datos = 'u603397150_AmbWebQ12025';

$conexion = new mysqli($host, $usuario, $password, $base_datos);

if ($conexion->connect_errno) {
    echo json_encode(['status' => 'error', 'msg' => 'Error de conexión']);
    exit;
}
// Recibir datos
$cedula = $_POST['cedula'];
$tipo = $_POST['tipo']; // Entrada o Salida

if (empty($cedula) || empty($tipo)) {
    echo json_encode(["status" => "error", "msg" => "Datos incompletos"]);
    exit;
}

$fecha = date("Y-m-d");
$hora_actual = date("H:i:s");
$estado = "Normal";

// Si es entrada y es de mañana, consultamos la hora esperada
if ($tipo === "Entrada") {
    $stmt = $conexion->prepare("SELECT Hora_entrada FROM Planilla WHERE Cedula = ?");
    $stmt->bind_param("i", $cedula);
    $stmt->execute();
    $stmt->bind_result($hora_esperada);

    if ($stmt->fetch()) {
        // Guardamos el valor antes de cerrar el statement
        $hora_esperada_copy = $hora_esperada;

        $stmt->close(); // CERRAMOS ANTES DE HACER OTRO PREPARE

        if (strtotime($hora_actual) > strtotime($hora_esperada_copy)) {
            $estado = "Tardía";

            // Ahora sí podemos preparar otro statement
            $stmt2 = $conexion->prepare("UPDATE Planilla SET Tardias = Tardias + 1 WHERE Cedula = ?");
            $stmt2->bind_param("i", $cedula);
            $stmt2->execute();
            $stmt2->close();

            error_log("Hora esperada: $hora_esperada_copy vs actual: $hora_actual");
        }
    } else {
        $stmt->close(); // Asegúrate de cerrarlo también si no entra al fetch
        error_log("No se encontró la cédula $cedula en Planilla");
    }
}


$sql = "INSERT INTO Marcas (Cedula, Tipo_marca, Fecha, Hora, Estado) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("issss", $cedula, $tipo, $fecha, $hora_actual, $estado);

if ($stmt->execute()) {
    $mensaje = $estado === "Tardía" ? "Marca registrada como tardía" : "Marca registrada con éxito";
    echo json_encode(["status" => "ok", "msg" => $mensaje]);
} else {
    echo json_encode(["status" => "error", "msg" => "Error al registrar"]);
}

$stmt->close();
$conexion->close();
