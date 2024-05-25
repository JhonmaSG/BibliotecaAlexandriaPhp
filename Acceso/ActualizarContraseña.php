<?php
session_start();
require("../ConfiguracionBD/ConexionBDPDO.php");

if (isset($_POST['EnviarRecuperacion'])) {
    $usuario = $_POST['txtuser'];
    $correo = $_POST['txtcorreo'];
    $cedula = $_POST['txtdni'];
    $respuesta = $_POST['txtrespuesta'];
    $nueva_contraseña = $_POST['txtcontraNueva'];

    try {
        $consulta = $conexion->prepare("SELECT * FROM cliente WHERE usuario = ? AND correo = ? AND cedula = ? AND respuesta = ?");
        $consulta->bindParam(1, $usuario);
        $consulta->bindParam(2, $correo);
        $consulta->bindParam(3, $cedula);
        $consulta->bindParam(4, $respuesta);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $nueva_contraseña_hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
            $actualizacion = $conexion->prepare("UPDATE cliente SET contraseña = ? WHERE usuario = ? AND correo = ? AND cedula = ? AND respuesta = ?");
            $actualizacion->bindParam(1, $nueva_contraseña_hash);
            $actualizacion->bindParam(2, $usuario);
            $actualizacion->bindParam(3, $correo);
            $actualizacion->bindParam(4, $cedula);
            $actualizacion->bindParam(5, $respuesta);
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

    header("Location: ./MensajeContraseñaActualizada.php");
    exit;
}
?>
