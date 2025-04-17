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
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$edad = $_POST['edad'];
$cedula = $_POST['cedula'];

$query = "INSERT INTO Planilla (Nombre, Apellido, Edad, Cedula) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ssii", $nombre, $apellido, $edad, $cedula);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'mensaje' => 'Persona agregada']);
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error al agregar persona']);
}

$stmt->close();
$conexion->close();