<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$plataforma = $data['plataforma'] ?? '';
$usuario = $data['usuario'] ?? '';
$contrasena = $data['contrasena'] ?? '';
$usuario_id = $_SESSION['user_id'] ?? null;

if (!$id || !$plataforma || !$usuario || !$contrasena || !$usuario_id) {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

$sql = "UPDATE passwords SET plataforma = ?, usuario = ?, contrasena = ? WHERE id = ? AND usuario_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$plataforma, $usuario, $contrasena, $id, $usuario_id]);

header('Content-Type: application/json');
echo json_encode(["success" => true]);
?>
