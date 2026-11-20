<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>

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
                        <form action="Controladores/validar.php" method="POST" class="cuadrito_login p-4 border rounded shadow-sm bg-white">
                            <h1 class="text-center mb-4">Iniciar sesión</h1>
                            
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input type="text" name="usuario" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" name="contrasena" class="form-control" required>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <input type="submit" class="theme-danger btn-subtle btn-lg" value="Iniciar" style="width: 100%; height: 50px;">
                            </div>

                            <!-- Enlace para registrarse -->
                            <div class="text-center mt-3">
                                <p class="mb-0">¿No tienes cuenta? <a href="registro.php" class="text-decoration-none fw-bold">Regístrate aquí</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>