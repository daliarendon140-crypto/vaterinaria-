<?php
session_start();

if (!isset($_SESSION['id_empleado'])) {
    header('location: login.php');
    exit();
}

include('menu.php');

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_nuevo = trim($_POST['nombre'] ?? '');
    $estatus_nuevo = 1;
    $usuario_nuevo = trim($_POST['usuario_nuevo'] ?? '');
    $contrasena_nuevo = $_POST['contrasena_nuevo'] ?? '';

    $admin_user = trim($_POST['admin_user'] ?? '');
    $admin_pass = $_POST['admin_pass'] ?? '';

    try {
        $conexion = new PDO('mysql:host=localhost;dbname=veterinaria;charset=utf8', 'root', '');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conexion->prepare("SELECT * FROM empleado WHERE usuario = ? AND puesto = 'administrador'");
        $stmt->execute([$admin_user]);
        $admin_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin_data && $admin_pass === $admin_data['contrasena']) {
            $insert = $conexion->prepare("INSERT INTO empleado (nombre, estatus, usuario, contrasena) VALUES (?, ?, ?, ?)");
            if ($insert->execute([$nombre_nuevo, $estatus_nuevo, $usuario_nuevo, $contrasena_nuevo])) {
                $mensaje = "¡Nuevo empleado registrado exitosamente!";
            } else {
                $mensaje = "Error al registrar el empleado.";
            }
        } else {
            $mensaje = "Error: Las credenciales del Administrador General son incorrectas.";
        }
    } catch (PDOException $e) {
        $mensaje = "Error de conexión: " . $e->getMessage();
    }
}

$usuarioSesion = $_SESSION['usuario'] ?? '';
?>

<br>
<br>
<br>

<div class="container mb-5">
    <div class="row">
        <form action="" method="POST" class="offset-1 col-10">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h1 class="mb-0">Registrar Empleado</h1>
                <a href="eliminar_empleado.php" class="btn btn-danger">Eliminar empleado</a>
            </div>
            <br>

            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></div><br>
            <?php endif; ?>

            <h4>1. Datos del Nuevo Empleado</h4><br>

            <label>Nombre completo</label>
            <input type="text" name="nombre" class="form-control" required><br>

            <label>Usuario</label>
            <input type="text" name="usuario_nuevo" class="form-control" required><br>

            <label>Contraseña</label>
            <input type="password" name="contrasena_nuevo" class="form-control" required><br>

            <hr class="my-4">

            <h4>2. Autorización del Administrador General</h4><br>

            <label>Su usuario de administrador</label>
            <input type="text" name="admin_user" class="form-control" value="<?php echo htmlspecialchars($usuarioSesion, ENT_QUOTES, 'UTF-8'); ?>" required><br>

            <label>Su contraseña de administrador</label>
            <input type="password" name="admin_pass" class="form-control" required><br>

            <div align="center">
                <input type="submit" class="theme-danger btn-subtle btn-lg" value="Guardar" style="width: 100%; max-width: 300px; height: 60px;">
            </div>
        </form>
    </div>
</div>

</body>
</html>