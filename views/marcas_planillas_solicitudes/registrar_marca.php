<?php
header('Content-Type: application/json');

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
if ($tipo === "Entrada" && intval(date("H")) < 12) {
    $stmt = $conexion->prepare("SELECT hora_entrada FROM Planilla WHERE cedula = ?");
    $stmt->bind_param("i", $cedula);
    $stmt->execute();
    $stmt->bind_result($hora_esperada);

    if ($stmt->fetch()) {
        if (strtotime($hora_actual) > strtotime($hora_esperada)) {
            $estado = "Tardía";
        }
    }
    $stmt->close();
}

$sql = "INSERT INTO Marcas (Cedula, Tipo_marca, Fecha, Hora, Estado) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssss", $cedula, $tipo, $fecha, $hora_actual, $estado);

if ($stmt->execute()) {
    $mensaje = $estado === "Tardía" ? "Marca registrada como tardía" : "Marca registrada con éxito";
    echo json_encode(["status" => "ok", "msg" => $mensaje]);
} else {
    echo json_encode(["status" => "error", "msg" => "Error al registrar"]);
}

$stmt->close();
$conexion->close();
