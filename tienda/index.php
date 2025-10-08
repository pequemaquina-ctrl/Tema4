<!DOCTYPE html>
<html>
<head>
    <title>Store Products</title>
</head>
<body>
    <h1>Product Codes in Stock</h1>
    <ul>
        <?php
        $conn = new mysqli('localhost', 'dwes', 'dwes', 'tienda');
        

        // Consulta que obtiene sólo los códigos de producto que existen en stock (sin duplicados)
        $sql = "SELECT DISTINCT producto AS cod FROM stock ORDER BY producto";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
        
            while ($row = $result->fetch_assoc()) {
                echo '<li><a href="stock.php?id=' . htmlspecialchars($row['cod']) . '">' . htmlspecialchars($row['cod']) . '</a></li>';
            }
        } else {
            echo "<li>No hay productos con stock.</li>";
        }
        $conn->close();
        ?>
    </ul>
</body>
</html>
