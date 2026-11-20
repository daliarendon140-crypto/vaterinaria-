<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/estilo.css">
    <script src="js/jquery-js.js"></script>
</head>
<body class="bg-light">

    <div class="container-fluid min-vh-100 d-flex align-items-center">
        <div class="row w-100 align-items-center justify-content-center">
            
            <div class="col-12 col-md-6 mb-4 mb-md-0">
                <div class="color_lateral w-100 d-flex justify-content-center align-items-center py-4">
                    <div style="background-color: pink; border-radius: 50%; border: #523333 solid 5px; width: 250px; height: 250px; display: flex; align-items: center; justify-content: center;" class="overflow-hidden shadow">
                         <img class="perrito img-fluid" src="img/perrito1.png" alt="Perrito" style="max-height: 80%;">
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6"> 
                <div class="row justify-content-center">
                    <div class="col-11 col-sm-9 col-md-8">
                        <form action="controladores/guardar_registro.php" method="POST" class="cuadrito_login p-4 border rounded shadow-sm bg-white">
                            <h1 class="text-center mb-4">Crear cuenta</h1>
                            
                            <div class="mb-3">
                                <label class="form-label">Nombre de usuario</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" name="contrasena" class="form-control" required>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <input type="submit" class="theme-danger btn-subtle btn-lg" value="Registrarse" style="width: 100%; height: 50px;">
                            </div>

                            <div class="text-center mt-3">
                                <p class="mb-0">¿Ya tienes cuenta? <a href="login.php" class="text-decoration-none fw-bold">Inicia sesión</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>