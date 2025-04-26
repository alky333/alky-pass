<?php
/**
 * Este archivo contiene la configuración de la base de datos.
 * Los datos de conexión (host, dbname, username, password)
 * deben ser actualizados cuando el proyecto sea subido a un host.
 */
$host = " sql311.infinityfree.com";
$dbname = "if0_38827235_keeper_db";
$username = "if0_38827235";
$password = "084086191"; // sin contraseña por defecto en XAMPP

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
