<?php
$dsn = 'mysql:host=localhost;dbname=discografia;charset=utf8';
$usuario = 'discografia';
$clave = 'discografia';

try {
    $pdo = new PDO($dsn, $usuario, $clave);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
