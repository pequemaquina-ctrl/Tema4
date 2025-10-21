<!DOCTYPE html>
<html>
<head>
    <title>Nueva Canción</title>
</head>
<body>
<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $album_codigo = isset($_GET['album_codigo']) ? intval($_GET['album_codigo']) : 0;

    $stmt = $pdo->prepare("SELECT titulo FROM album WHERE codigo = ?");
    $stmt->execute([$album_codigo]);
    $album = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$album) {
        echo "<p>Álbum no encontrado.</p>";
        exit;
    }

    echo "<h1>Agregar canción al álbum: " . htmlspecialchars($album['titulo']) . "</h1>";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = $_POST['titulo'] ?? '';
        $posicion = $_POST['posicion'] ?? '';
        $duracion = $_POST['duracion'] ?? '';
        $genero = $_POST['genero'] ?? '';

        if ($titulo != '') {
            $stmtInsert = $pdo->prepare("INSERT INTO cancion (titulo, album, posicion, duracion, genero) VALUES (?, ?, ?, ?, ?)");
            $stmtInsert->execute([$titulo, $album_codigo, $posicion, $duracion, $genero]);
            echo "<p>✅ Canción añadida correctamente.</p>";
        } else {
            echo "<p>El título de la canción es obligatorio.</p>";
        }
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<form method="post">
    Título: <input name="titulo" required><br>
    Posición: <input type="number" name="posicion" min="1"><br>
    Duración: <input name="duracion" placeholder="3:45"><br>
    Género: <input name="genero"><br>
    <button type="submit">Guardar canción</button>
</form>

<a href="album.php?codigo=<?= $album_codigo ?>">⬅️ Volver al álbum</a>
</body>
</html>
