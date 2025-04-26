<?php
session_start();
include 'db.php';
 
$sql = "SELECT * FROM passwords";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
echo json_encode($rows);
