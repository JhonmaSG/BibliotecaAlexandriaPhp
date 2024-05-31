<<<<<<< HEAD
<?php
session_start();

include "../ConfiguracionBD/ConexionBDPDO.php";

$nombre_usuario = $_POST['txtnombre'];
$cedula = $_POST['txtdni'];
$usuario = $_POST['txtuser'];
$contraseña1 = $_POST['txtpass1'];
$contraseña2 = $_POST['txtpass2'];
$correo = $_POST['txtemail'];
$respuesta = $_POST['txtrespuesta'];

$consultasql = $conexion->prepare("SELECT * FROM cliente WHERE cedula = :cedula");
$consultasql->bindParam(':cedula', $cedula, PDO::PARAM_STR);
$consultasql->execute();
$resultado = $consultasql->fetchAll();

if ($resultado) {
    $_SESSION['message'] = "El usuario ya existe en la Base de Datos";
    $_SESSION['message_type'] = "error";
} else {
    if ($contraseña1 != $contraseña2) {
        $_SESSION['message'] = "Las contraseñas no coinciden";
        $_SESSION['message_type'] = "error";
    } else {
        $contraseña_hash = password_hash($contraseña1, PASSWORD_DEFAULT);
        $sentenciasql = $conexion->prepare("INSERT INTO cliente (usuario, contraseña, correo, cedula, respuesta, nombre_usuario) VALUES (?, ?, ?, ?, ?, ?);");
        $sentenciasql->bindParam(1, $usuario);
        $sentenciasql->bindParam(2, $contraseña_hash);
        $sentenciasql->bindParam(3, $correo);
        $sentenciasql->bindParam(4, $cedula);
        $sentenciasql->bindParam(5, $respuesta);
        $sentenciasql->bindParam(6, $nombre_usuario);
        
        if ($sentenciasql->execute()) {
            $_SESSION['message'] = "Cuenta creada exitosamente";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Ocurrió un error al registrar el usuario";
            $_SESSION['message_type'] = "error";
        }
    }
}

header("Location: mensajeCuentaCreada.php");
exit;
?>