<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_cuenta'] != 'cliente') {
    header("Location: ../NoUser/MensajeCerrarSesion.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Alejandria Login Recuperar contraseña</title>
</head>
<body style="background: #989898;">
    <div class="container mt-4 col-4">
        <div class="card col-sm-10">
            <div class="card-body">

                <div class="form-group text-center">
                    <h3>Cambiar contraseña</h3>
                    <img src="../img/logoBiblioteca.png" alt="70" width="170"/>

                    <label style="display: block">Gestos de Biblioteca</label>
                </div>

                <form class="form-sign" action="ProcesoActualizarContraseñaConUser.php" method="POST">

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
                        <label>Digite Dni:</label>
                        <input type="number" name="txtdni" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Respuesta a pregunta de seguridad:</label>
                        <input type="text" name="txtrespuesta" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Digite contraseña nueva:</label>
                        <input type="password" name="txtcontraNueva" class="form-control">
                    </div>

                    <input type="submit" name="submit" value="Enviar Cambio" class="btn btn-primary">
                    <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-warning">
                    <input type="button" value="Atrás" class="btn btn-info" onclick="window.location.href = './IndexConUser.php';">

                </form><br>
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
