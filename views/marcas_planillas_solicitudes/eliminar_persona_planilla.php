<?php
header('Content-Type: application/json');

$host = '82.197.82.143';
$usuario = 'u603397150_AmbWebQ12025';
$password = 'AmbWebQ12025';
$base_datos = 'u603397150_AmbWebQ12025';

$conexion = new mysqli($host, $usuario, $password, $base_datos);

if ($conexion->connect_errno) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error de conexión']);
    exit;
}

$cedula = $_POST['cedula'];

$query = "DELETE FROM Planilla WHERE Cedula=?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $cedula);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'mensaje' => 'Persona eliminada']);
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error al eliminar persona']);
}

$stmt->close();
$conexion->close();
