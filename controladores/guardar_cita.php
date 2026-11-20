<?php
session_start();

if (!isset($_SESSION['id_empleado'])) {
    header('location: ../login.php');
    exit();
}

include('../clases/Cita.php');

$clase_cita = new Cita();

$id_empleado     = $_SESSION['id_empleado'];
$nombre_mascota  = $_POST['nombre'];
$raza            = $_POST['Raza'];
$edad            = $_POST['edad'];
$fecha           = $_POST['Fecha'];
$hora            = $_POST['Hora'];
$nombre_contacto = $_POST['Nombre'];
$telefono        = $_POST['Telefono'];
$motivo          = $_POST['motivo'];


$resultado = $clase_cita->guardar($id_empleado, $nombre_mascota, $raza, $edad, $fecha, $hora, $nombre_contacto, $telefono, $motivo);

if ($resultado) {
    echo "<script>
        alert('Cita guardada correctamente');
        window.location.href = '../formulario_cita.php';
    </script>";
} else {
    echo "<script>
        alert('Error al guardar la cita');
        window.location.href = '../formulario_cita.php';
    </script>";
}
?>