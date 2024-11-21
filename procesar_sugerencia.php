<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Conexión a la base de datos
    $db = new SQLite3('/var/www/html/mi_sitio/sugerencias.db');

    // Crear tabla si no existe
    $db->exec("CREATE TABLE IF NOT EXISTS sugerencias (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nombre TEXT,
        email TEXT,
        sugerencia TEXT
    )");

    // Validar datos del formulario
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : 'Anónimo';
    $email = !empty($_POST['email']) ? $_POST['email'] : 'Sin correo';
    $sugerencia = !empty($_POST['sugerencia']) ? $_POST['sugerencia'] : 'Sin sugerencia';

    // Preparar e insertar datos
    $stmt = $db->prepare("INSERT INTO sugerencias (nombre, email, sugerencia) VALUES (:nombre, :email, :sugerencia)");
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $db->lastErrorMsg());
    }
    $stmt->bindValue(':nombre', $nombre, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':sugerencia', $sugerencia, SQLITE3_TEXT);

    // Ejecutar consulta
    if ($stmt->execute()) {
        echo "<p>Gracias por tu sugerencia, $nombre!</p>";
    } else {
        throw new Exception("Error al ejecutar la consulta: " . $db->lastErrorMsg());
    }

    // Cerrar conexión a la base de datos
    $db->close();

} catch (Exception $e) {
    echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
}

// procesar_sugerencia.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos y procesamiento de la sugerencia
    $db = new SQLite3('/var/www/html/mi_sitio/sugerencias.db');
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : 'Anónimo';
    $email = !empty($_POST['email']) ? $_POST['email'] : 'Sin correo';
    $sugerencia = !empty($_POST['sugerencia']) ? $_POST['sugerencia'] : 'Sin sugerencia';

    $stmt = $db->prepare("INSERT INTO sugerencias (nombre, email, sugerencia) VALUES (:nombre, :email, :sugerencia)");
    $stmt->bindValue(':nombre', $nombre, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':sugerencia', $sugerencia, SQLITE3_TEXT);
    $stmt->execute();

    $db->close();

    // Redirigir a index.html con el mensaje de éxito como parámetro
    header("Location: index.html?mensaje=" . urlencode("Gracias por tu sugerencia, $nombre!"));
    exit;
}

?>

