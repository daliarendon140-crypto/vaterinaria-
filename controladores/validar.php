<?php 
session_start();

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

include('../clases/Empleado.php'); 

$clase = new Empleado();
$datos = $clase->validar($usuario, $contrasena);

if($datos){
    $_SESSION['id_empleado'] = $datos['id_empleado'];
    $_SESSION['nombre'] = $datos['nombre'];
    
    header('location: ../index.php');
} else {
    echo "Usuario NO encontrado";
}
?>