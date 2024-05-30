<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_cuenta'] != 'cliente') {
    header("Location: ../NoUser/MensajeCerrarSesion.php");
    exit();
}
require("../ConfiguracionBD/ConexionBDPDO.php");

if (isset($_POST['submit'])) {
    $cedula = $_POST['txtdni'];
    $respuesta = $_POST['txtrespuesta'];
    $nueva_contraseña = $_POST['txtcontraNueva'];

    try {
        $consulta = $conexion->prepare("SELECT * FROM cliente WHERE cedula = ? AND respuesta = ?");
        $consulta->bindParam(1, $cedula);
        $consulta->bindParam(2, $respuesta);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $nueva_contraseña_hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
            $actualizacion = $conexion->prepare("UPDATE cliente SET contraseña = ? WHERE cedula = ? AND respuesta = ?");
            $actualizacion->bindParam(1, $nueva_contraseña_hash);
            $actualizacion->bindParam(2, $cedula);
            $actualizacion->bindParam(3, $respuesta);
            $actualizacion->execute();

            $_SESSION['message'] = "Contraseña actualizada correctamente.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Datos incorrectos. Por favor, intente nuevamente.";
            $_SESSION['message_type'] = "error";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        $_SESSION['message_type'] = "error";
    }

    header("Location: ./MensajeContraseñaActualizadaConUser.php");
    exit;
}
?>
