<?php
session_start();

if (!isset($_SESSION['id_empleado'])) {
    header('location: login.php');
    exit();
}

include('menu.php');

$mensaje = "";
$empleados = [];

try {
    $conexion = new PDO('mysql:host=localhost;dbname=veterinaria;charset=utf8', 'root', '');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_eliminar = (int)($_POST['id_eliminar'] ?? 0);
        $admin_user = trim($_POST['admin_user'] ?? '');
        $admin_pass = $_POST['admin_pass'] ?? '';

        $stmt = $conexion->prepare("SELECT * FROM empleado WHERE usuario = ? AND puesto = 'administrador' AND estatus = 1");
        $stmt->execute([$admin_user]);
        $admin_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin_data && $admin_pass === $admin_data['contrasena']) {
            if ($id_eliminar <= 0) {
                $mensaje = "Error: ID de empleado no válido.";
            } elseif ((string)$id_eliminar === (string)$_SESSION['id_empleado']) {
                $mensaje = "Error: No puedes desactivar tu propia sesión activa.";
            } else {
                $update = $conexion->prepare("UPDATE empleado SET estatus = 0 WHERE id_empleado = ? AND COALESCE(puesto, '') != 'administrador'");
                if ($update->execute([$id_eliminar])) {
                    $mensaje = "Empleado dado de baja correctamente.";
                } else {
                    $mensaje = "Error al dar de baja al empleado.";
                }
            }
        } else {
            $mensaje = "Error: Las credenciales del Administrador General son incorrectas.";
        }
    }

    $consultaEmpleados = $conexion->query("SELECT id_empleado, nombre, usuario, estatus FROM empleado WHERE estatus = 1 AND COALESCE(puesto, '') != 'administrador' ORDER BY id_empleado DESC");
    $empleados = $consultaEmpleados->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensaje = "Error de conexión: " . $e->getMessage();
}

$usuarioSesion = $_SESSION['usuario'] ?? '';
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h2 class="mb-0">Eliminar empleados</h2>
        <a href="registro_empleado.php" class="btn btn-secondary">Registrar empleado</a>
    </div>

    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <div class="table-responsive shadow rounded-3">
        <table class="table table-striped table-hover table-bordered align-middle text-center mb-0">
            <thead>
                <tr class="theme-danger">
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    <th>Autorización y acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($empleados)): ?>
                    <?php foreach ($empleados as $emp): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($emp['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($emp['usuario'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>Activo</td>
                            <td>
                                <form action="" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas dar de baja a este empleado?');">
                                    <input type="hidden" name="id_eliminar" value="<?php echo (int)$emp['id_empleado']; ?>">
                                    <input type="text" name="admin_user" class="form-control form-control-sm d-inline-block mb-1" style="max-width: 150px;" value="<?php echo htmlspecialchars($usuarioSesion, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Usuario admin" required>
                                    <input type="password" name="admin_pass" class="form-control form-control-sm d-inline-block mb-1" style="max-width: 150px;" placeholder="Contraseña admin" required>
                                    <button type="submit" class="btn btn-danger btn-sm mb-1">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-3">No hay empleados activos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>