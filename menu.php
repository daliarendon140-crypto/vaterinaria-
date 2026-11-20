<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$esEmpleado = false;
$esAdmin = false;

if (isset($_SESSION['id_empleado'])) {
    try {
        $conexionMenu = new PDO('mysql:host=localhost;dbname=veterinaria;charset=utf8', 'root', '');
        $conexionMenu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmtMenu = $conexionMenu->prepare("SELECT puesto, estatus FROM empleado WHERE id_empleado = ?");
        $stmtMenu->execute([$_SESSION['id_empleado']]);
        $usuarioMenu = $stmtMenu->fetch(PDO::FETCH_ASSOC);

        if ($usuarioMenu) {
            $esEmpleado = true;
            $puestoMenu = strtolower(trim((string)($usuarioMenu['puesto'] ?? '')));
            $estatusMenu = strtolower(trim((string)($usuarioMenu['estatus'] ?? '')));

            if ($puestoMenu === 'administrador' || $estatusMenu === 'administrador') {
                $esAdmin = true;
            }
        }
    } catch (PDOException $e) {
        $esEmpleado = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Veterinaria</title>
   <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
   <link rel="stylesheet" type="text/css" href="css/estilo.css?=1">
   <script src="js/jquery-js.js"></script>
   <script src="js/bootstrap.bundle.js"></script>
</head>
<body>
  <nav class="navbar sm:navbar-expand bg-1 fg-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="img/perrito1.png">
    </a>
    <button class="btn-icon navbar-toggler" type="button" data-bs-toggle="drawer" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" aria-hidden="true"></span>
    </button>
    <dialog class="drawer drawer-end" tabindex="-1" id="navbarNav" aria-labelledby="navbarNavLabel">
      <div class="drawer-header">
        <h5 class="drawer-title" id="navbarNavLabel">Menú</h5>
        <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Close"></button>
      </div>
      <div class="drawer-body">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="formulario_cita.php">Agenda tu cita</a>
            </li>

            <?php if ($esEmpleado): ?>
                <li class="nav-item">
                    <a class="nav-link" href="formulario_medicamentos.php">Registro de medicamentos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lista_citas.php">Ver citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lista_medicamentos.php">Ver registro de medicamentos</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="catalogo_medicamentos.php">Catálogo de medicamentos</a>
                </li>
            <?php endif; ?>

            <?php if ($esAdmin): ?>
                <li class="nav-item">
                    <a class="nav-link" href="registro_empleado.php">Registrar Empleado</a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <?php if ($esEmpleado): ?>
                    <a class="nav-link text-danger fw-bold" href="Controladores/cerrar_sesion.php">Cerrar sesión</a>
                <?php else: ?>
                    <a class="nav-link text-primary fw-bold" href="login.php">Iniciar sesión o registrar</a>
                <?php endif; ?>
            </li>
        </ul>
      </div>
    </dialog>
  </div>
</nav>