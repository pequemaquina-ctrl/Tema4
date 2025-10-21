<!DOCTYPE html>
<html>
<head>
    <title>Buscar Canciones</title>
</head>
<body>
<h1>Buscar Canciones</h1>

<form method="get">
    <input type="text" name="q" placeholder="Título de la canción" required>
    <button type="submit">Buscar</button>
</form>

<?php
if (!empty($_GET['q'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $q = "%" . $_GET['q'] . "%";
        $stmt = $pdo->prepare("
            SELECT c.titulo AS cancion, c.duracion, c.genero, a.titulo AS album, a.formato
            FROM cancion c
            JOIN album a ON c.album = a.codigo
            WHERE c.titulo LIKE ?
            ORDER BY a.titulo, c.posicion
        ");
        $stmt->execute([$q]);

        echo "<h2>Resultados:</h2>";
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . htmlspecialchars($row['cancion']) . " — " .
                 htmlspecialchars($row['album']) . " (" . htmlspecialchars($row['formato']) . ")</li>";
        }
        echo "</ul>";

    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<a href="index.php">⬅️ Volver al inicio</a>
</body>
</html>
