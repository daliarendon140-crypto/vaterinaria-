<?php 
require_once('Conexion.php');

class Empleado {
    private PDO $conexion;

    public function __construct(){
        $instancia = new Conexion();
        $this->conexion = $instancia->conectar();
    }

    public function validar($usuario, $contrasena){
        
        
        $sql = "SELECT id_empleado, puesto, nombre, 'empleado' as tipo FROM empleado WHERE usuario = :usuario AND contrasena = :contrasena";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            'usuario' => $usuario, 
            'contrasena' => $contrasena
        ]);
        
        $resultado = $stmt->fetch();

        
        if ($resultado) {
            return $resultado;
        }

        $sql_usuario = "SELECT id_usuario as id_empleado, nombre, 'usuario' as tipo FROM usuario WHERE nombre = :usuario AND contrasena = :contrasena";
        $stmt_u = $this->conexion->prepare($sql_usuario);
        $stmt_u->execute([
            'usuario' => $usuario, 
            'contrasena' => $contrasena
        ]);
        
        return $stmt_u->fetch();
    }
}
?>