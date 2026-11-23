<?php
session_start();

include('menu.php');

$datos = [];
$columnaId = "id";

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

    $consulta = $conexion->query("SELECT * FROM medicamentos");
    $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</div></div>";
}
?>

<style>
    .tarjeta-med {
        background: linear-gradient(160deg, #64748b 0%, #475569 100%);
        color: #ffffff;
        border-radius: 12px;
        padding: 20px;
        height: 100%;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.12);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .tarjeta-med:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.18);
    }
    .precio-med {
        background-color: rgba(255, 255, 255, 0.16);
        border-radius: 8px;
        padding: 4px 10px;
        font-weight: 700;
        font-size: 1.35rem;
        white-space: nowrap;
    }
    .caja-imagen-med {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 12px;
        text-align: center;
        margin-top: 14px;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
    }
    .caja-imagen-med img {
        width: 100%;
        height: 175px;
        object-fit: contain;
    }
</style>

<div class="container mt-4 mb-5">
    <h1 class="mb-1">Medicamentos</h1>
    <p class="text-muted mb-4">Conoce los medicamentos disponibles para el cuidado de tu mascota.</p>

    <div class="row g-4">
        <?php if (!empty($datos)): ?>
            <?php foreach ($datos as $fila): ?>
                <?php
                    $idMed = (int)($fila[$columnaId] ?? 0);
                    $nombre = htmlspecialchars($fila['nombre'] ?? 'Medicamento', ENT_QUOTES, 'UTF-8');
                    $descripcion = htmlspecialchars($fila['descripcion'] ?? 'Sin descripción disponible.', ENT_QUOTES, 'UTF-8');
                    $precio = htmlspecialchars($fila['precio'] ?? '0.00', ENT_QUOTES, 'UTF-8');

                    $imagenArchivo = trim($fila['imagen'] ?? '');
                    if ($imagenArchivo !== '' && file_exists('img/' . $imagenArchivo)) {
                        $rutaImagen = 'img/' . htmlspecialchars($imagenArchivo, ENT_QUOTES, 'UTF-8');
                    } elseif ($imagenArchivo !== '' && file_exists($imagenArchivo)) {
                        $rutaImagen = htmlspecialchars($imagenArchivo, ENT_QUOTES, 'UTF-8');
                    } else {
                        $rutaImagen = 'img/perrito1.png';
                    }
                ?>
                <div class="col-12 col-md-4">
                    <div class="tarjeta-med d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <span class="fw-bold fs-5"><?php echo $nombre; ?></span>
                                <span class="precio-med">$<?php echo $precio; ?></span>
                            </div>
                            <p class="small mt-2 mb-0" style="color: #e2e8f0; line-height: 1.4;">
                                <?php echo $descripcion; ?>
                            </p>
                        </div>

                        <div>
                            <div class="caja-imagen-med">
                                <img src="<?php echo $rutaImagen; ?>" alt="<?php echo $nombre; ?>">
                            </div>

                            <div class="d-flex justify-content-between gap-2 mt-3">
                                <button type="button" class="btn btn-primary btn-sm flex-fill fw-semibold">Ver</button>
                                <a href="editar_medicamento.php?id=<?php echo $idMed; ?>" class="btn btn-warning btn-sm flex-fill fw-semibold">Editar</a>
                                <button type="button" class="btn btn-danger btn-sm flex-fill fw-semibold">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-4 mb-0">
                    No hay medicamentos registrados por el momento.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>