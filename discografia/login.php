<?php
require 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // ✅ Corregido el nombre de la tabla y el parámetro
    $stmt = $pdo->prepare("SELECT * FROM tabla_usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: index.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h1>Inicio de Sesión</h1>
<form method="post">
    Usuario: <input type="text" name="usuario" required><br>
    Contraseña: <input type="password" name="password" required><br>
    <button type="submit">Entrar</button>
</form>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
</body>
</html>
