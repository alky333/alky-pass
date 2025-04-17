<?php
session_start();
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$plataforma = $data['plataforma'];
$usuario = $data['usuario'];
$contrasena = $data['contrasena'];
$user_id = $_SESSION['user_id'];

$sql = "UPDATE passwords SET plataforma = ?, usuario = ?, contrasena = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$plataforma, $usuario, $contrasena, $id, $user_id]);

echo json_encode(["success" => true]);
