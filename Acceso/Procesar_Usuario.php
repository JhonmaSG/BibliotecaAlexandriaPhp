<?php

session_start();

include "../ConfiguracionBD/ConexionBDPDO.php";
$nombre_usuario = $_POST['txtnombre'];
$cedula = $_POST['txtdni'];
$usuario = $_POST['txtuser'];
$contraseña1 = $_POST['txtpass1'];
$contraseña2 = $_POST['txtpass2'];
$correo = $_POST['txtemail'];

$consultasql = $conexion->prepare("Select * from cliente where cedula=" . $cedula);
$consultasql->execute();
$resultado = $consultasql->fetchAll();
if ($resultado) {
    $_SESSION['error_message'] = "El usuario ya existe en la Base de Datos";
    //echo "<p>El usuario ya existe en la Base de Datos<p>";
} else {
    if ($contraseña1 != $contraseña2) {
        $_SESSION['error_message'] = "Las contraseñas no coinciden";
        //echo "<p>Las claves no coinciden....<p>";
    } else {
        $contraseña_hash = password_hash($contraseña1, PASSWORD_DEFAULT);
        $sentenciasql = $conexion->prepare("Insert into cliente (usuario,contraseña,correo,cedula,nombre_usuario) values(?,?,?,?,?);");
        $sentenciasql->bindParam(1, $usuario);
        $sentenciasql->bindParam(2, $contraseña_hash);
        $sentenciasql->bindParam(3, $correo);
        $sentenciasql->bindParam(4, $cedula);
        $sentenciasql->bindParam(5, $nombre_usuario);
        $sentenciasql->execute();
        if ($sentenciasql) {
            header("Location: ../Acceso/Login.php");
        } else {
            $_SESSION['error_message'] = "Ocurrió un error al registrar el usuario";
            //echo "<p>Ocurrio un Error al digitar los Datos<p>";
        }
    }
}
    header("Location: CrearCuenta.php");
    exit;
?> 