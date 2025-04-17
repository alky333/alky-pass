<?php
session_start();
include 'db.php';

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':usuario', $usuario);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($contrasena, $user['contrasena'])) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['user_id'] = $user['id'];
    header("Location: ../index.php");
    exit();
} else {
    echo "<script>alert('Credenciales inválidas');window.location.href='../login.html';</script>";
    exit();
}
?>
