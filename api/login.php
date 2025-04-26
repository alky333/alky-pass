<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php';

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
$stmt->bindParam(':usuario', $usuario);
$stmt->execute();
$user = $stmt->fetch();

if ($user && password_verify($contrasena, $user['contrasena'])) {
    // Guardar en sesión el nombre y el ID
    $_SESSION['usuario'] = $usuario;
    $_SESSION['user_id'] = $user['id']; // <-- Esto es necesario para insert.php
    echo "<script>alert('Inicio de sesión exitoso');window.location.href='../index.php';</script>";
} else {
    echo "<script>alert('Usuario o contraseña incorrectos');window.location.href='../login.html';</script>";
}
?>
