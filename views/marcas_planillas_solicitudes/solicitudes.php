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

$tipo = $_POST['tipo'] ?? '';
$colaborador = $_POST['colaborador'] ?? '';
$inicio = $_POST['inicio'] ?? '';
$fin = $_POST['fin'] ?? '';
$motivo = $_POST['motivo'] ?? '';

$query = "INSERT INTO Solicitudes (Tipo_Solicitud, Nombre_Colaborador, Fecha_Inicio, Fecha_Final, Motivo)
          VALUES (?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($query);

if (!$stmt) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error en la preparación de la consulta']);
    exit;
}

$stmt->bind_param('sssss', $tipo, $colaborador, $inicio, $fin, $motivo);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'mensaje' => 'Solicitud registrada']);
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'No se pudo guardar']);
}

$stmt->close();
$conexion->close();
