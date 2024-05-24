<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se enviaron datos
    if (isset($_POST['txtusuario']) && isset($_POST['txtclave'])) {
        // Obtener credenciales de inicio de sesión
        $usuario = $_POST['txtusuario'];
        $clave = $_POST['txtclave'];

        // Conexión a la base de datos
        require "../ConfiguracionBD/ConexionBDPDO.php"; // Incluir el archivo de conexión
        $consulta = $conexion->prepare("SELECT * FROM cliente WHERE usuario = :usuario");
        $consulta->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        // Obtener el resultado de la consulta
        $fila = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $passwordHash = $fila['contraseña'];
            $nombreUsuario = $fila['nombre_usuario'];
            $correo = $fila['correo'];
            //echo 'Hash en la base de datos:' . $passwordHash . '<br>';
            // Verificar la contraseña usando password_verify
            if (password_verify($clave, $passwordHash)) {
                //echo '<br>entro a password_verify<br>';
                $_SESSION['usuario'] = $usuario;
                $_SESSION['nombre_usuario'] = $nombreUsuario;
                $_SESSION['correo'] = $correo;
                header("Location: ../ConUser/IndexConUser.php");
                exit();
            } else {
                $_SESSION['error_message'] = 'Credenciales incorrectas';
                header("Location: Login.php");
                exit;
            }
        } else {
            $_SESSION['error_message'] = 'Usuario no encontrado';
            header("Location: Login.php");
                exit;
        }
    }
}
?>
