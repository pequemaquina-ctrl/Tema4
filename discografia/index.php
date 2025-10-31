<?php
require 'auth.php';
require 'conexion.php';
?>
<!DOCTYPE html>
<html>
<head><title>Discografía</title></head>
<body>
<header>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?> |
       <a href="logout.php">Cerrar sesión</a></p>
</header>

<h1>Lista de Álbumes</h1>

<?php
try {
    $st = $pdo->query("SELECT * FROM album ORDER BY titulo");

    echo "<ul>";
    while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
        echo '<li><a href="album.php?codigo=' . htmlspecialchars($row['codigo']) . '">' .
             htmlspecialchars($row['titulo']) . '</a> (' . htmlspecialchars($row['formato']) . ')</li>';
    }
    echo "</ul>";

    echo "<br><a href='albumnuevo.php'>➕ Agregar nuevo álbum</a>";
    echo "<br><a href='canciones.php'>🔍 Buscar canciones</a>";

    if (isset($_GET['msg'])) {
        echo "<p style='color:green'>" . htmlspecialchars($_GET['msg']) . "</p>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
</body>
</html>
