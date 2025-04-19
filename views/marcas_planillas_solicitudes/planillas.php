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

$cedula = isset($_GET['cedula']) ? $conexion->real_escape_string($_GET['cedula']) : null;

if ($cedula) {
    $query = "SELECT * FROM Planilla WHERE Cedula = '$cedula'";
    $resultado = $conexion->query($query);

    if ($fila = $resultado->fetch_assoc()) {
        echo json_encode(['status' => 'ok', 'datos' => $fila]);
    } else {
        echo json_encode(['status' => 'error', 'mensaje' => 'Persona no encontrada']);
    }
} else {
    $query = "SELECT * FROM Planilla";
    $resultado = $conexion->query($query);

    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    echo json_encode(['status' => 'ok', 'datos' => $datos]);
}

$conexion->close();
