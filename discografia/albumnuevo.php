<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Álbum</title>
</head>
<body>
<h1>Agregar nuevo álbum</h1>

<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = $_POST['titulo'] ?? '';
        $discografica = $_POST['discografica'] ?? '';
        $formato = $_POST['formato'] ?? '';
        $fechaLanzamiento = $_POST['fechaLanzamiento'] ?? '';
        $fechaCompra = $_POST['fechaCompra'] ?? '';
        $precio = $_POST['precio'] ?? '';

        if ($titulo != '') {
            $stmt = $pdo->prepare("INSERT INTO album (titulo, discografica, formato, fechaLanzamiento, fechaCompra, precio)
                                   VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$titulo, $discografica, $formato, $fechaLanzamiento, $fechaCompra, $precio]);
            header("Location: index.php?msg=Álbum creado correctamente");
            exit;
        } else {
            echo "<p>El título es obligatorio.</p>";
        }
    }

    
    $formatos = $pdo->query("SELECT DISTINCT formato FROM album WHERE formato IS NOT NULL AND formato <> ''")->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>

<form method="post">
    Título: <input type="text" name="titulo" required><br>
    Discográfica: <input type="text" name="discografica"><br>
    Formato: 
    <select name="formato">
        <option value="">-- Selecciona formato --</option>
        <?php
        foreach ($formatos as $f) {
            echo "<option value='" . htmlspecialchars($f) . "'>" . htmlspecialchars($f) . "</option>";
        }
        ?>
        <option value="Otro">Otro...</option>
    </select><br>
    Fecha de lanzamiento: <input type="date" name="fechaLanzamiento"><br>
    Fecha de compra: <input type="date" name="fechaCompra"><br>
    Precio (€): <input type="number" step="0.01" name="precio"><br>
    <button type="submit">Guardar álbum</button>
</form>

<a href="index.php">⬅️ Volver</a>
</body>
</html>

