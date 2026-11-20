<?php 
require_once('Conexion.php');

class Medicamento {
    private PDO $conexion;

    public function __construct(){
        $instancia = new Conexion();
        $this->conexion = $instancia->conectar();
    }

    public function guardar($nombre, $descripcion, $precio){
        $sql = "INSERT INTO medicamentos (nombre, descripcion, precio) VALUES (:nombre, :descripcion, :precio)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            'nombre' => $nombre, 
            'descripcion' => $descripcion,
            'precio' => $precio
        ]);
        return $stmt;
    }
    public function mostrarTodos(){
    $sql = "SELECT * FROM medicamentos";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
   }
}
?>