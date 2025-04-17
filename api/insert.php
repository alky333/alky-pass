<?php
session_start();
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$plataforma = $data['plataforma'];
$usuario = $data['usuario'];
$contrasena = $data['contrasena'];
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO passwords (plataforma, usuario, contrasena, user_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$plataforma, $usuario, $contrasena, $user_id]);

echo json_encode(["status" => "ok"]);
