<?php
session_start();
if (!isset($_SESSION['id_empleado'])) {
    header('location: login.php');
    exit();
}
include('menu.php');
?>

<br>
<br>
<br>

<div class="container mb-5">
    <div class="row">
        <form action="Controladores/guardar_medicamento.php" method="POST" enctype="multipart/form-data" class="offset-1 col-10">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h1 class="mb-0">Registro de medicamentos</h1>
                <a href="catalogo_medicamentos.php" class="btn btn-secondary">Ver catálogo de medicamentos</a>
            </div>
            <br>

            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required><br>

            <label>Descripción</label>
            <input type="text" name="descripcion" class="form-control" required><br>

            <label>Precio</label>
            <div class="input-group mb-3">
                <span class="input-group-text">$</span>
                <input type="number" step="0.01" name="precio" class="form-control" placeholder="0.00" required>
            </div><br>

            <label>Imagen del medicamento</label>
            <input type="file" name="imagen" class="form-control" accept="image/*"><br><br>

            <div align="center">
                <input type="submit" class="theme-danger btn-subtle btn-lg" value="Guardar" style="width: 100%; max-width: 300px; height: 60px;">
            </div>
        </form>
    </div>
</div>
</body>
</html>