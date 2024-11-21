<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $db = new SQLite3('/var/www/html/mi_sitio/sugerencias.db');
    $stmt = $db->prepare("INSERT INTO sugerencias (nombre, email, sugerencia) VALUES (:nombre, :email, :sugerencia)");
    $stmt->bindValue(':nombre', 'Prueba Usuario', SQLITE3_TEXT);
    $stmt->bindValue(':email', 'prueba@example.com', SQLITE3_TEXT);
    $stmt->bindValue(':sugerencia', 'Esto es una prueba', SQLITE3_TEXT);

    if ($stmt->execute()) {
        echo "Inserción exitosa.";
    } else {
        echo "Error al insertar: " . $db->lastErrorMsg();
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

