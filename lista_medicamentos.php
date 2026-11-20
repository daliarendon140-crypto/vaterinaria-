<?php
session_start();

if (!isset($_SESSION['id_empleado'])) {
    header('location: login.php');
    exit();
}

include('menu.php');
include('clases/Medicamento.php');

$clase_medicamentos = new Medicamento();

$datos = $clase_medicamentos->mostrarTodos();
?>

<div class="container mt-5 pt-2">

    <h2 class="mb-4">Medicamentos</h2>

    <div class="table-responsive shadow rounded-3">

        <table class="table table-striped table-hover table-bordered align-middle text-center">

            <thead>
                <tr class="theme-danger">
                    <th>Nombre</th>
                    <th>Referencia</th>
                    <th>Precio</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (!empty($datos)) {
                    foreach ($datos as $fila) {
                ?>

                <tr>
                    <td><?=$fila['nombre']?></td>
                    <td><?=$fila['descripcion']?></td>
                    <td>$<?=$fila['precio']?></td>
                </tr>

                <?php
                    }
                } else {
                ?>
                <tr>
                    <td colspan="3" class="text-center py-3">No hay medicamentos registrados.</td>
                </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>
</div>

</body>
</html>