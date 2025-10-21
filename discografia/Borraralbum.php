<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $codigo = isset($_GET['codigo']) ? intval($_GET['codigo']) : 0;

    $pdo->beginTransaction();

    $pdo->prepare("DELETE FROM cancion WHERE album = ?")->execute([$codigo]);
    $pdo->prepare("DELETE FROM album WHERE codigo = ?")->execute([$codigo]);

    $pdo->commit();

    header("Location: index.php?msg=Álbum eliminado correctamente");
    exit;

} catch (PDOException $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    header("Location: album.php?codigo=$codigo&error=" . urlencode($e->getMessage()));
    exit;
}
?>
