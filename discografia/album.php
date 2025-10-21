<!DOCTYPE html>
<html>
<head>
    <title>Álbum</title>
</head>
<body>
<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $codigo = isset($_GET['codigo']) ? intval($_GET['codigo']) : 0;

    $st = $pdo->prepare("SELECT * FROM album WHERE codigo = ?");
    $st->execute([$codigo]);
    $album = $st->fetch(PDO::FETCH_ASSOC);

    if (!$album) {
        echo "<p>Álbum no encontrado.</p>";
        exit;
    }

    echo "<h1>" . htmlspecialchars($album['titulo']) . "</h1>";
    echo "<p>Discográfica: " . htmlspecialchars($album['discografica']) . "</p>";
    echo "<p>Formato: " . htmlspecialchars($album['formato']) . "</p>";
    echo "<p>Fecha de lanzamiento: " . htmlspecialchars($album['fechaLanzamiento']) . "</p>";
    echo "<p>Fecha de compra: " . htmlspecialchars($album['fechaCompra']) . "</p>";
    echo "<p>Precio: " . htmlspecialchars($album['precio']) . " €</p>";

    echo "<h2>Canciones</h2>";
    $stmt2 = $pdo->prepare("SELECT * FROM cancion WHERE album = ? ORDER BY posicion");
    $stmt2->execute([$codigo]);

    echo "<ul>";
    while ($song = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>" . htmlspecialchars($song['posicion']) . ". " . 
             htmlspecialchars($song['titulo']) . " (" . 
             htmlspecialchars($song['duracion']) . ") — " . 
             htmlspecialchars($song['genero']) . "</li>";
    }
    echo "</ul>";

    echo "<a href='cancionnueva.php?album_codigo=$codigo'>➕ Agregar nueva canción</a><br>";
    echo "<a href='borraralbum.php?codigo=$codigo' onclick='return confirm(\"¿Seguro que deseas borrar este álbum y sus canciones?\");'>🗑️ Borrar álbum</a><br>";
    echo "<a href='index.php'>⬅️ Volver al inicio</a>";

} catch (PDOException $e) {
    echo "Error al consultar el álbum: " . $e->getMessage();
}
?>
</body>
</html>

