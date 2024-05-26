<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se enviaron datos
    if (isset($_POST['txtusuario']) && isset($_POST['txtclave']) && isset($_POST['tipo_cuenta'])) {
        // Obtener credenciales de inicio de sesión
        $usuario = $_POST['txtusuario'];
        $clave = $_POST['txtclave'];
        $tipo_cuenta = $_POST['tipo_cuenta'];

        // Conexión a la base de datos
        require "../ConfiguracionBD/ConexionBDPDO.php"; // Incluir el archivo de conexión

        // Definir la consulta SQL en función del tipo de cuenta
        if ($tipo_cuenta == 'cliente') {
            $sql = "SELECT * FROM cliente WHERE usuario = :usuario";
        } else if ($tipo_cuenta == 'empleado') {
            $sql = "SELECT * FROM empleado WHERE usuario = :usuario";
        }

        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        // Obtener el resultado de la consulta
        $fila = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $passwordHash = $fila['contraseña'];
            $nombreUsuario = $fila['nombre_usuario'];
            $correo = $fila['correo'];
            $idCliente = $fila['id_cliente'];
            // Verificar la contraseña usando password_verify
            if (password_verify($clave, $passwordHash) && $usuario == $fila['usuario']) {
                $_SESSION['usuario'] = $usuario;
                $_SESSION['nombre_usuario'] = $nombreUsuario;
                $_SESSION['correo'] = $correo;
                $_SESSION['id_cliente'] = $idCliente;

                // Redirigir en función del tipo de cuenta
                if ($tipo_cuenta == 'cliente') {
                    header("Location: ../ConUser/IndexConUser.php");
                } else if ($tipo_cuenta == 'empleado') {
                    header("Location: ../ConUser/Emp/IndexConEmpleado.php");
                }
                exit();
            } else {
                $_SESSION['error_message'] = 'Credenciales incorrectas';
                header("Location: Login.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Usuario no encontrado';
            header("Location: Login.php");
            exit();
        }
    }
}
?>
