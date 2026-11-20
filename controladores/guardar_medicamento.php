<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = $_POST['precio'] ?? 0;
    $nombreImagen = '';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (in_array($ext, $permitidas)) {
            $nombreImagen = uniqid('med_') . '.' . $ext;
            $carpetaDestino = __DIR__ . '/../img/';

            if (!is_dir($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            move_uploaded_file($_FILES['imagen']['tmp_name'], $carpetaDestino . $nombreImagen);
        }
    }

    try {
        $conexion = new PDO('mysql:host=localhost;dbname=veterinaria;charset=utf8', 'root', '');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conexion->prepare("INSERT INTO medicamentos (nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $descripcion, $precio, $nombreImagen]);

        header('Location: ../catalogo_medicamentos.php');
        exit();
    } catch (PDOException $e) {
        echo "Error al guardar: " . $e->getMessage();
    }
}