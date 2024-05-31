<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_cuenta'] != 'cliente') {
    header("Location: ../NoUser/MensajeCerrarSesion.php");
    exit();
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
              rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="../estilos.css">

        <title>index</title>
    </head>
    <body>

        <header>
            <?php include('EncabezadoConUser.php'); ?>
        </header>

        <main>
            <?php include('../Carrusel.php'); ?>
            <div class="biblioteca-info">
                <h2>Biblioteca Alexandria</h2>
                <p>Biblioteca Alexandria es una institución dedicada a la promoción de la lectura y el aprendizaje.
                <br>Ofrecemos una amplia variedad de libros, recursos digitales y espacios para el estudio y la investigación.</p>

                <h3><b>Contacto</b></h3>
                <p><b>Dirección:</b> Calle 123, Ciudad Perdida</p>
                <p><b>Teléfono:</b> +123 456 7890</p>
                <p><b>Email:</b> info@bibliotecaAlexandria.com</p>

                <h3>Redes Sociales</h3>
                <p>Síguenos en:</p>
                <ul>
                    <li><i class="fa-brands fa-facebook"></i><a href="" target="_blank">  Facebook</a></li>
                    <li><i class="fa-brands fa-twitter"></i><a href="" target="_blank">  Twitter</a></li>
                    <li><i class="fa-brands fa-instagram"></i><a href="" target="_blank">  Instagram</a></li>
                </ul>
            </div>
        </main>

        <footer>
            <?php include('../Pie.php'); ?>
        </footer>

        <script src="https://kit.fontawesome.com/9dbadc2946.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" 
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" 
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>
