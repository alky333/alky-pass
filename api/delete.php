<?php
session_start();
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM passwords WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id, $user_id]);

echo json_encode(["success" => true]);
