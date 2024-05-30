<?php
//session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_cuenta'] != 'empleado') {
    header("Location: ../../NoUser/MensajeCerrarSesion.php");
    exit();
}
else {

    if (isset($_SESSION['nombre_usuario'])) {
        $nombreUsuario = $_SESSION['nombre_usuario'];
    }
    if (isset($_SESSION['correo'])) {
        $correo = $_SESSION['correo'];
    }
    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    }

// Verificar si se ha presionado el enlace "Salir"
    if (isset($_GET['logout'])) {
        // Destruir la sesión
        session_destroy();
        // Redirigir a la página de inicio de sesión
        header("Location: ../../NoUser/IndexNoUser.php");
        exit();
    }
    ?>
    <!doctype html>
    <html lang="es">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Encabezado</title>
        </head>
        <body>
            <nav class="navbar navbar-expand-lg navbar-dark bg-success itemsNavEncabezado">
                <div class="collapse navbar-collapse divNavEncabezado">

                    <ul class="navbar-nav">
                        <div class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-sm-5 me-5">
                                <li class="nav-item active ms-sm-5 me-5">
                                    <a class="btn btn-outline-light"
                                       href="./IndexConEmpleado.php"><i class="fa-solid fa-house"></i> Inicio</a>
                                </li>
                                <li class="nav-item active ms-sm-5 me-5">
                                    <a class="btn btn-outline-light" 
                                       href="./Libros.php" ><i class="fa-solid fa-book"></i> Libros</a>
                                </li>
                                <li class="nav-item active ms-sm-5 me-5">
                                    <a class="btn btn-outline-light" 
                                       href="./MovimientoLibros.php" ><i class="fa-solid fa-book-open"></i></i> Movimiento Libros</a>
                                </li>
                                <li class="nav-item active ms-sm-5 me-5">
                                    <a class="btn btn-outline-light" 
                                       href="./Prestamos.php" ><i class="fa-solid fa-building"></i> Prestamos</a>
                                </li>
                                <li class="nav-item active ms-sm-5 me-5">
                                    <a class="btn btn-outline-light" 
                                       href="./Devoluciones.php" ><i class="fa-solid fa-building"></i> Devoluciones</a>
                                </li>
                                <li class="nav-item active ms-sm-5 me-5">
                                    <a class="btn btn-outline-light" 
                                       href="./Multas.php" ><i class="fa-solid fa-money-bill"></i> Multas</a>
                                </li>
                            </ul>
                        </div>
                    </ul>
                </div>

                <div class="dropdown me-5" style="padding-right: 150px;">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($usuario); ?>
                    </button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item" href="#"><img src="../../img/user.png" alt="user image" width="60"/></a></li>
                        <?php
                        if (isset($nombreUsuario) && isset($correo)) {
                            echo "<li><a class='dropdown-item' href='#'>" . htmlspecialchars($nombreUsuario) . "</a></li>";
                            echo "<li><a class='dropdown-item' href='#'>" . htmlspecialchars($correo) . "</a></li>";
                        }
                        ?>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <?php
                            // Si el usuario está autenticado, mostrar el enlace de "Salir"
                            if (isset($_SESSION['usuario'])) {
                                //echo '<p><a href="../../NoUser/IndexNoUser.php?logout=true">Salir</a></p>';
                                echo '<p><a href="../../NoUser/CerrarSesion.php">Salir</a></p>';
                            }
                            ?>
                        </li>
                    </ul>
                </div>

            </nav>

        </body>
    </html>
    <?php
}
?>