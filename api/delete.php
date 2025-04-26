<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$usuario_id = $_SESSION['user_id'] ?? null;

if (!$id || !$usuario_id) {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

$sql = "DELETE FROM passwords WHERE id = ? AND usuario_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id, $usuario_id]);

header('Content-Type: application/json');
echo json_encode(["success" => true]);
?>
