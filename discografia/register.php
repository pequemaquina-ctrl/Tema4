<?php
require 'conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Verificar si el usuario ya existe
    $stmt = $pdo->prepare("SELECT * FROM tabla_usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    if ($stmt->fetch()) {
        $error = "El usuario ya existe.";
    } else {
        // Encriptar la contraseña antes de guardarla
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Insertar el nuevo usuario en la base de datos
        $stmt = $pdo->prepare("INSERT INTO tabla_usuarios (usuario, password) VALUES (?, ?)");
        $stmt->execute([$usuario, $password_hash]);

        header("Location: login.php");
        exit();
    }
}
$stmt = $pdo->query("SELECT id, password FROM tabla_usuarios");
$usuarios = $stmt->fetchAll();

foreach ($usuarios as $usuario) {
    $password_plano = $usuario['password']; 
    $password_hash = password_hash($password_plano, PASSWORD_BCRYPT);


    $update = $pdo->prepare("UPDATE tabla_usuarios SET password = ? WHERE id = ?");
    $update->execute([$password_hash, $usuario['id']]);
}

echo "Contraseñas actualizadas y encriptadas correctamente.";
?>


<!DOCTYPE html>
<html>
<head><title>Registro</title></head>
<body>
<h1>Registro de Usuario</h1>
<form method="post">
    Usuario: <input type="text" name="usuario" required><br>
    Contraseña: <input type="password" name="password" required><br>
    <button type="submit">Registrarse</button>
</form>
<p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</body>
</html>
