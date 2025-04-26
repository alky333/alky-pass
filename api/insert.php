<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$plataforma = $data['plataforma'] ?? '';
$usuario = $data['usuario'] ?? '';
$contrasena = $data['contrasena'] ?? '';
$usuario_id = $_SESSION['user_id'] ?? null;

if (!$plataforma || !$usuario || !$contrasena || !$usuario_id) {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

$sql = "INSERT INTO passwords (plataforma, usuario, contrasena, usuario_id) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$plataforma, $usuario, $contrasena, $usuario_id]);

header('Content-Type: application/json');
echo json_encode(["success" => true]);
?>
