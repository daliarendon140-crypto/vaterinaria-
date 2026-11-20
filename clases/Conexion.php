<?php 
class Conexion{
	private $host = "localhost";
	private $bd = "veterinaria";
	private $user = "root";
	private $password = "";

	public function conectar(): PDO{
		$con = "mysql:host={$this->host};dbname={$this->bd};charset=utf8mb4";
		try{
			$conexion = new PDO($con, $this->user, $this->password, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
				PDO::ATTR_EMULATE_PREPARES => false 
			]);
			return $conexion;
		} catch(PDOException $e){
			throw new RuntimeException("Error al conectar la bd", 0, $e);
		}
	}
}
?>