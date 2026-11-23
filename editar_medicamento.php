<?php
session_start();

if (!isset($_SESSION['id_empleado'])) {
    header('location: login.php');
    exit();
}

include('menu.php');

$idMed = (int)($_GET['id'] ?? $_POST['id_medicamento'] ?? 0);
$mensaje = "";
$medicamento = null;
$columnaId = 'id';

try {
    $conexion = new PDO('mysql:host=localhost;dbname=veterinaria;charset=utf8', 'root', '');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $estructura = $conexion->query("SHOW COLUMNS FROM medicamentos")->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($estructura)) {
        $columnaId = $estructura[0]['Field'];
        foreach ($estructura as $col) {
            if (($col['Key'] ?? '') === 'PRI') {
                $columnaId = $col['Field'];
                break;
            }
        }
    }

    $stmt = $conexion->prepare("SELECT * FROM medicamentos WHERE `$columnaId` = ?");
    $stmt->execute([$idMed]);
    $medicamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && $medicamento) {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = $_POST['precio'] ?? 0;
        $nombreImagen = $medicamento['imagen'] ?? '';

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (in_array($ext, $permitidas)) {
                $nombreImagen = uniqid('med_') . '.' . $ext;
                $carpetaDestino = __DIR__ . '/img/';

                if (!is_dir($carpetaDestino)) {
                    mkdir($carpetaDestino, 0777, true);
                }

                move_uploaded_file($_FILES['imagen']['tmp_name'], $carpetaDestino . $nombreImagen);
            }
        }

        $update = $conexion->prepare("UPDATE medicamentos SET nombre = ?, descripcion = ?, precio = ?, imagen = ? WHERE `$columnaId` = ?");
        if ($update->execute([$nombre, $descripcion, $precio, $nombreImagen, $idMed])) {
            $mensaje = "Medicamento actualizado correctamente.";
            $stmt->execute([$idMed]);
            $medicamento = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $mensaje = "Error al actualizar el medicamento.";
        }
    }
} catch (PDOException $e) {
    $mensaje = "Error: " . $e->getMessage();
}
?>

<br>
<br>
<br>

<div class="container mb-5">
    <div class="row">
        <?php if ($medicamento): ?>
            <form action="" method="POST" enctype="multipart/form-data" class="offset-1 col-10">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h1 class="mb-0">Editar medicamento</h1>
                    <a href="catalogo_medicamentos.php" class="btn btn-secondary">Regresar al catálogo</a>
                </div>
                <br>

                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-info"><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></div><br>
                <?php endif; ?>

                <input type="hidden" name="id_medicamento" value="<?php echo $idMed; ?>">

                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($medicamento['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

                <label>Descripción</label>
                <input type="text" name="descripcion" class="form-control" value="<?php echo htmlspecialchars($medicamento['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

                <label>Precio</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo htmlspecialchars($medicamento['precio'] ?? '0.00', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div><br>

                <label>Cambiar imagen (opcional)</label>
                <input type="file" name="imagen" class="form-control" accept="image/*"><br><br>

                <div align="center">
                    <input type="submit" class="theme-danger btn-subtle btn-lg" value="Guardar cambios" style="width: 100%; max-width: 300px; height: 60px;">
                </div>
            </form>
        <?php else: ?>
            <div class="offset-1 col-10">
                <div class="alert alert-warning">Medicamento no encontrado.</div>
                <a href="catalogo_medicamentos.php" class="btn btn-secondary">Regresar al catálogo</a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>