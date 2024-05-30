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
    <title>Alejandria Login</title>
</head>
<body style="background: #989898;">
    <div class="container mt-4 col-4">
        <div class="card col-sm-10">
            <div class="card-body">
                <form class="form-sign" action="./IndexConUser.php" method="POST">
                    <div class="form-group text-center">
                        <?php
                        // Mostrar mensaje de éxito o error si existe
                        if (isset($_SESSION['message'])) {
                            $alert_type = $_SESSION['message_type'] === 'error' ? 'alert-danger' : 'alert-success';
                            echo '<div class="alert ' . $alert_type . '" role="alert">';
                            echo '<h2>' . $_SESSION['message'] . '</h2>';
                            echo '</div>';
                            // Eliminar el mensaje después de mostrarlo
                            unset($_SESSION['message']);
                            unset($_SESSION['message_type']);
                        }
                        ?>
                    </div>

                    <input type="submit" value="Inicio" class="btn btn-warning btn-lg btn-block">
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
