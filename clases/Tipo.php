<?php 
require_once('Conexion.php');

class Tipo{

	private PDO $conexion;

	public function __construct(){

		$instancia = new Conexion();

		$this->conexion = $instancia->conectar();
}

function guardar($nombre, $descripcion, $precio){
	$sql = "INSERT INTO tipo (nombre, descripcion, precio, estatus) VALUES (:nombre, :descripcion, :precio, 1)";
	 $stmt = $this->conexion->prepare($sql);
		  $stmt->execute([
		  	'nombre' => $nombre, 
		  	'descripcion' => $descripcion, 
		  	'precio' => $precio
		]);
		  return $stmt;

	
   }

   function mostrarTodos(){
   $sql = "SELECT * FROM tipo";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute();
   return $stmt->fetchAll();
   }
}

 ?>