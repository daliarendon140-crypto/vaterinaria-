<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servidor = "localhost";
$usuario_db = "root";
$password_db = "";
$dbname = "veterinaria";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$dbname;charset=utf8", $usuario_db, $password_db);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = trim($_POST['nombre']);
        $contrasena = $_POST['contrasena']; 

        
        $sql_verificar = "SELECT id_usuario FROM usuario WHERE nombre = :nombre";
        $stmt_v = $conexion->prepare($sql_verificar);
        $stmt_v->execute(['nombre' => $nombre]);

        if ($stmt_v->rowCount() > 0) {
            echo "<script>alert('El nombre de usuario ya está en uso. Elige otro.'); window.location='../registro.php';</script>";
            exit();
        } else {
        
            $sql = "INSERT INTO usuario (nombre, contrasena) VALUES (:nombre, :contrasena)";
            $stmt = $conexion->prepare($sql);
            
            $resultado = $stmt->execute([
                'nombre' => $nombre,
                'contrasena' => $contrasena
            ]);

            if ($resultado) {
                header("Location: ../login.php");
                exit();
            } else {
                echo "<script>alert('Error al registrar en la base de datos.'); window.location='../registro.php';</script>";
                exit();
            }
        }
    }
} catch (PDOException $e) {
    echo "Error de conexión o SQL: " . $e->getMessage();
}
?>