
<?php
session_start();

if (!isset($_SESSION['id_empleado'])) {
    header('location: login.php');
    exit();
}

include('menu.php');
include('clases/Cita.php');

$clase_cita = new Cita();

$datos = $clase_cita->mostrarTodos();
?>

<div class="container mt-5">

    <h2 class="mb-4">Citas agendadas</h2>

    <div class="table-responsive shadow rounded-3">

        <table class="table table-striped table-hover table-bordered align-middle text-center">

            <thead>
                <tr class="theme-danger">
                    <th>Mascota</th>
                    <th>Raza</th>
                    <th>Edad</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Nombre de contacto</th>
                    <th>Teléfono</th>
                    <th>Motivo</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($datos as $fila) {
                ?>

                <tr>
                    <td><?=$fila['nombre_mascota']?></td>
                    <td><?=$fila['raza']?></td>
                    <td><?=$fila['edad']?></td>
                    <td><?=$fila['fecha']?></td>
                    <td><?=$fila['hora']?></td>
                    <td><?=$fila['nombre_contacto']?></td>
                    <td><?=$fila['telefono']?></td>
                    <td><?=$fila['motivo']?></td>
                </tr>

                <?php
                }
                ?>
            </tbody>

        </table>
    </div>
</div>

</body>
</html>