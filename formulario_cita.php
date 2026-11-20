<?php
session_start();
if (!isset($_SESSION['id_empleado'])) {
    header('location: login.php');
    exit();
}
include('menu.php');
?>

?>
<br>
<br>
<br>

<div class="container">
    <div class="row">
        <form action="Controladores/guardar_cita.php" method="POST" class="offset-1 col-10">
            <h1>Registro Citas</h1><br>
            
            <label>Nombre de la mascota</label>
            <input type="text" name="nombre" class="form-control" required> <br>
            
            <label>Raza</label>
            <input type="text" name="Raza" class="form-control"><br>
            
            <label>Edad aproximada</label>
            <select name="edad" class="form-control" required>
                <option value="">Seleccione una opción</option>
                <option value="1">1 año</option>
                <option value="2">2 años</option>
                <option value="3">3 años</option>
                <option value="4">Más de tres años</option>
            </select><br>
            
            <label>Fecha</label>
            <input type="date" name="Fecha" class="form-control" required> <br>
            
            <label>Hora</label>
            <input type="time" name="Hora" class="form-control" required> <br>
            
            <label>Tu nombre</label>
            <input type="text" name="Nombre" class="form-control" required> <br>
            
            <label>Teléfono</label>
            <input type="text" name="Telefono" class="form-control"> <br>
<label>Motivo</label>
            <select name="motivo" class="form-control" required>
                <option value="">Seleccione una opción</option>
                <option value="med">Médico</option>
                <option value="est">Estético</option>
            </select><br>
            <div align="center">    
                <input type="submit" class="theme-danger btn-subtle btn-lg" value="Guardar" style="width: 100%; max-width: 300px; height: 60px;">
            </div>
        </form>
    </div>
</div>
</body>
</html>