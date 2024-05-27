<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se enviaron datos
    if (isset($_POST['txtusuario']) && isset($_POST['txtclave']) && isset($_POST['tipo_cuenta'])) {
        // Obtener credenciales de inicio de sesión
        $usuario = $_POST['txtusuario'];
        $clave = $_POST['txtclave'];
        $tipo_cuenta = $_POST['tipo_cuenta'];

        require "../ConfiguracionBD/ConexionBDPDO.php"; // Incluir el archivo de conexión

        if ($tipo_cuenta == 'cliente') {
            $sql = "SELECT * FROM cliente WHERE usuario = :usuario";
        } else if ($tipo_cuenta == 'empleado' || $tipo_cuenta == 'administrador') {
            $sql = "SELECT * FROM empleado WHERE usuario = :usuario";
        }

        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        // Obtener el resultado de la consulta
        $fila = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $passwordHash = $fila['contraseña'];
            $correo = $fila['correo'];
            $nombreUsuario = isset($fila['nombre_usuario']) ? $fila['nombre_usuario'] : "";
            $idCliente = isset($fila['id_cliente']) ? $fila['id_cliente'] : "";
            $rol = $fila['rol'];
            $estadoUser = $fila['estado'];

            $_SESSION['nombre_usuario'] = $nombreUsuario;
            $_SESSION['id_cliente'] = $idCliente;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['correo'] = $correo;
            $_SESSION['rol'] = $rol;
            $_SESSION['estado'] = $estadoUser;
            echo 'estoy antes de verify<br>';
            // Verificar la contraseña usando password_verify
            if (password_verify($clave, $passwordHash) && $usuario == $fila['usuario']) {
                // Redirigir en función del tipo de cuenta
                echo 'estoy dentro de verify<br>';
                echo 'Tipo de cuenta: ' . $tipo_cuenta . '<br>';
                echo 'correo: ' . $correo . '<br>';
                echo 'nombre_usuario: ' . $nombreUsuario . '<br>';
                echo 'id_cliente: ' . $idCliente . '<br>';
                echo 'rol: ' . $rol . '<br>';
                echo 'estado: ' . $estadoUser . '<br>';
                
                if ($tipo_cuenta == 'cliente') {
                    echo 'estoy dentro de cliente<br>';
                    header("Location: ../ConUser/IndexConUser.php");
                } else if (($tipo_cuenta == 'empleado') && ($rol == 'emp') && ($estadoUser == 'activo')) {
                    echo 'estoy dentro de emp<br>';
                    header("Location: ../ConUser/Emp/IndexConEmpleado.php");
                } else if (($tipo_cuenta == 'administrador') && ($rol == 'admin') && ($estadoUser == 'activo')) {
                    echo 'estoy dentro de admin<br>';
                    header("Location: ../ConUser/Admin/IndexConAdmin.php");
                }else{
                    $_SESSION['error_message'] = 'Usuario no encontrado';
                    header("Location: Login.php");
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
