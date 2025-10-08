<?php
$conn = new mysqli('localhost', 'dwes', 'dwes', 'tienda');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : '';

// Si vienen datos por POST para actualizar el stock
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unidades'])) {
    $stocks = $_POST['unidades']; // Array con codigo tienda => unidades
    $conn->begin_transaction();

    $stmt = $conn->prepare("UPDATE stock SET unidades = ? WHERE producto = ? AND tienda = ?");
    if (!$stmt) {
        die("Error en la preparación: " . $conn->error);
    }

    $error = false;
    foreach ($stocks as $tienda => $unidades) {
        $unidades = (int)$unidades;
        $stmt->bind_param("isi", $unidades, $id, $tienda);
        if (!$stmt->execute()) {
            $error = true;
            break;
        }
    }

    if (!$error) {
        $conn->commit();
        echo "<p>Stock actualizado correctamente.</p>";
    } else {
        $conn->rollback();
        echo "<p>Error al actualizar el stock.</p>";
    }

    $stmt->close();
}

// Obtener el stock actual para mostrar el formulario
$sql = "SELECT nombre AS tienda, s.unidades, t.cod 
        FROM stock s 
        JOIN tienda t ON s.tienda = t.cod 
        WHERE s.producto = '$id'";
$res = $conn->query($sql);

if ($res->num_rows === 0) {
    echo "No hay stock para este producto.";
} else {
    echo "<h2>Modificar stock por tienda</h2>";
    echo "<form method='post' action='stock.php?id=$id'>";
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($row['tienda']) . 
             ": <input type='number' name='unidades[" . $row['cod'] . "]' value='" . 
             $row['unidades'] . "' min='0'></li>";
    }
    echo "</ul>";
    echo "<button type='submit'>Actualizar stock</button>";
    echo "</form>";
}

$conn->close();
?>
