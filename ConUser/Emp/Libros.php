<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_cuenta'] != 'empleado') {
    header("Location: ../../NoUser/MensajeCerrarSesion.php");
    exit();
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
              rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="../../estilos.css">

        <title>Libros</title>
    </head>
    <body>
        <header>
            <?php include('EncabezadoConEmp.php'); ?>
        </header>
        <main>
            <?php
            include('../../Carrusel.php');
            include('ListarTablaLibroConEmp.php');?>
        </main>
        <footer>
            <?php include('../../Pie.php'); ?>
        </footer>
        <script src="https://kit.fontawesome.com/9dbadc2946.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" 
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" 
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>