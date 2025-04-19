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
$hora_entrada = $_POST['hora_entrada'];
$ausencias = $_POST['ausencias'] ?? 0;
$tardias = $_POST['tardias'] ?? 0;
$query = "UPDATE Planilla SET Nombre=?, Apellido=?, Edad=?, Hora_entrada=?, 
  Ausencias = ?, 
  Tardias = ? WHERE Cedula=?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ssisiii", $nombre, $apellido, $edad, $hora_entrada, $ausencias, $tardias, $cedula);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'mensaje' => 'Persona actualizada']);
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error al actualizar persona']);
}

$stmt->close();
$conexion->close();
