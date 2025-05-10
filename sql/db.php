<?php
try {
    $pdo = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "sur2010");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
