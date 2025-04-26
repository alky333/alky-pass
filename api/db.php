
<?php
// db.php
$host = 'sql311.infinityfree.com';
$dbname = 'if0_38827235_keeper_db';
$username = 'if0_38827235';
$password = '084086191';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("🔴 Error de conexión a la base de datos: " . $e->getMessage());
}
?>
