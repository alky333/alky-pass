<?php
include 'db.php';

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

if (strlen($usuario) < 3 || strlen($contrasena) < 4) {
    echo "<script>alert('Usuario o contraseña muy cortos');window.location.href='../register.html';</script>";
    exit();
}

$sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':usuario', $usuario);
$stmt->execute();

if ($stmt->fetch()) {
    echo "<script>alert('Ese usuario ya existe');window.location.href='../register.html';</script>";
    exit();
}

$hash = password_hash($contrasena, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (usuario, contrasena) VALUES (:usuario, :contrasena)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':contrasena', $hash);
$stmt->execute();

echo "<script>alert('Cuenta creada correctamente');window.location.href='../login.html';</script>";
exit();
