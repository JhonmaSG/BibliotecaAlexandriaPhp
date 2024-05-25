<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
              rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Alejandria Login</title>
    </head>
    <body style="background: #989898;">
        <div class="container mt-4 col-4">
            <div class="card col-sm-10">
                <div class="card-body">
                    <div class="form-group text-center">
                            <h3>Login</h3>
                            <img src="../img/logoBiblioteca.png" alt="70" width="170"/>
                            <label style="display: block"><br><b>Bienvenido a Alexandria</b></label>
                            <label style="display: block">Gestos de Biblioteca</label>
                        </div>
                    <form class="form-sign" method="POST" action='Validar_Login.php'>
                        <?php
                        // Mostrar mensaje de error si existe
                        if (isset($_SESSION['error_message'])) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo $_SESSION['error_message'];
                            echo '</div>';
                            // Eliminar el mensaje de error después de mostrarlo
                            unset($_SESSION['error_message']);
                        }
                        ?>

                        <div class="form-group">
                            <label>Usuario:</label>
                            <input type="text" name="txtusuario" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Contraseña:</label>
                            <input type="password" name="txtclave" class="form-control">
                            <a href="RecuperarContraseña.php" class="btn btn-link">Olvidé mi contraseña</a>
                        </div>

                        <br>
                        <input type="submit" value="Login" class="btn btn-primary">
                        <input type="reset" value="Limpiar" class="btn btn-warning">
                        <input type="button" value="Atrás" class="btn btn-info" onclick="window.location.href = '../NoUser/IndexNoUser.php';">
                    </form>
                </div>
            </div>
        </div>

        <script src="https://kit.fontawesome.com/9dbadc2946.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" 
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" 
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>