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
                    <form class="form-sign" method="POST" action='Validar_Login.php'>
                        <div class="form-group text-center">
                            <h3>Login</h3>
                            <img src="../img/logoBiblioteca.png" alt="70" width="170"/>
                            <label style="display: block"><br><b>Bienvenido a Alexandria</b></label>
                            <label style="display: block">Gestos de Biblioteca</label>
                        </div><?php
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
                            <input type="submit" value="Olvide mi contraseña" class="btn btn-link">
                        </div>

                        <br>
                        <input type="submit" value="Login" class="btn btn-primary">
                        <input type="reset" value="Limpiar" class="btn btn-warning">
                        <input type="button" value="Atrás" class="btn btn-info" onclick="window.location.href = '../NoUser/IndexNoUser.php';">
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" 
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" 
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    </body>
</html>
