<?php 
require_once('Conexion.php');

class Cita {
    private PDO $conexion;

    public function __construct(){
        $instancia = new Conexion();
        $this->conexion = $instancia->conectar();
    }

    public function guardar($id_usuario, $nombre_mascota, $raza, $edad, $fecha, $hora, $nombre_contacto, $telefono, $motivo) {
        $sql = "INSERT INTO citas (id_usuario, nombre_mascota, raza, edad, fecha, hora, nombre_contacto, telefono, motivo) 
                VALUES (:id_usuario, :nombre_mascota, :raza, :edad, :fecha, :hora, :nombre_contacto, :telefono, :motivo)";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            'id_usuario'      => $id_usuario,
            'nombre_mascota'  => $nombre_mascota,
            'raza'            => $raza,
            'edad'            => $edad,
            'fecha'           => $fecha,
            'hora'            => $hora,
            'nombre_contacto' => $nombre_contacto,
            'telefono'        => $telefono,
            'motivo'          => $motivo
        ]);
        
        return $stmt;
    }

    public function mostrarTodos(){
    $sql = "SELECT * FROM citas";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
   }
}
?>