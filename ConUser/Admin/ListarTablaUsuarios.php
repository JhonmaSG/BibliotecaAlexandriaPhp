<?php
require("../../ConfiguracionBD/ConexionBDPDO.php");
$usuario = [];
$resultados = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $consulta = "SELECT * FROM cliente WHERE id_cliente = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}
try {
    $consultaBusqueda = "SELECT * FROM cliente";
    if (!empty($_GET['busqueda'])) {
        $busqueda = $_GET['busqueda'];
        if (isset($_GET['id_cliente'])) {
            $consultaBusqueda .= " WHERE id_cliente = '$busqueda'";
        } elseif (isset($_GET['nombre_usuario'])) {
            $consultaBusqueda .= " WHERE nombre_usuario = '$busqueda'";
        } elseif (isset($_GET['cedula'])) {
            $consultaBusqueda .= " WHERE cedula = '$busqueda'";
        }
    }
    $ejecutar = $conexion->prepare($consultaBusqueda);
    $ejecutar->execute();
    $resultados = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al listar la tabla Usuario<br/>" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuarios</title>
    </head>
    <body>
        <div class="" style="margin: 0 150px; width: 80%;">
            <h2 class="mt-4 text-center">Búsqueda de Usuarios</h2><br>
            <form action="" method="get" style="margin: 0 400px;">
                <div class="form-group">
                    <label for="busqueda">Buscar:</label><br>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese la búsqueda" style="width: 90%;">
                </div><br>
                <button type="submit" name="enviar" class="btn btn-warning">Mostrar Todos</button>
                <button type="submit" name="id_cliente" class="btn btn-primary">Buscar por Id Usuario</button>
                <button type="submit" name="nombre_usuario" class="btn btn-primary">Buscar por Nombre Usuario</button>
                <button type="submit" name="cedula" class="btn btn-primary">Buscar por Cedula</button>
            </form><br>

            <div class="card" style="margin: 0 200px;">
                <div class="card-body">
                    <form action="./Usuarios.php" method="POST">
                        <div class="form-group">
                            <label>Id Cliente</label>
                            <input type="number" value="<?php echo isset($usuario['id_cliente']) ? htmlspecialchars($usuario['id_cliente']) : ''; ?>"
                                   name="txtidcliente" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" value="<?php echo isset($usuario['usuario']) ? htmlspecialchars($usuario['usuario']) : ''; ?>"
                                   name="txtusuario" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="text" value="<?php echo isset($usuario['contraseña']) ? htmlspecialchars($usuario['contraseña']) : ''; ?>"
                                   name="txtcontraseña" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Correo</label>
                            <input type="text" value="<?php echo isset($usuario['correo']) ? htmlspecialchars($usuario['correo']) : ''; ?>"
                                   name="txtcorreo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Cedula</label>
                            <input type="number" value="<?php echo isset($usuario['cedula']) ? htmlspecialchars($usuario['cedula']) : ''; ?>"
                                   name="txtcedula" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Respuesta</label>
                            <input type="text" value="<?php echo isset($usuario['respuesta']) ? htmlspecialchars($usuario['respuesta']) : ''; ?>"
                                   name="txtrespuesta" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nombre Usuario</label>
                            <input type="text" value="<?php echo isset($usuario['nombre_usuario']) ? htmlspecialchars($usuario['nombre_usuario']) : ''; ?>"
                                   name="txtnombreusuario" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Fecha Inicio</label>
                            <input type="text" value="<?php echo isset($usuario['fecha_inicio']) ? htmlspecialchars($usuario['fecha_inicio']) : ''; ?>"
                                   name="txtfechainicio" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" value="<?php echo isset($usuario['estado']) ? htmlspecialchars($usuario['estado']) : ''; ?>"
                                   name="txtestado" class="form-control">
                        </div><br>
                        <input type="submit" name="Agregar" value="Agregar" class="btn btn-info">
                        <input type="submit" name="Actualizar" value="Actualizar" class="btn btn-success">
                        
                    </form>
                </div>
            </div>

            <?php
            if (isset($_SESSION['message'])) {
                $alert_type = $_SESSION['message_type'] === 'error' ? 'alert-danger' : 'alert-success';
                echo '<div class="alert ' . $alert_type . '" role="alert">';
                echo '<h2 class="text-center">' . $_SESSION['message'] . '</h2>';
                echo '</div>';
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>

            <?php if (!empty($resultados)): ?>
                <div class="mt-4">
                    <h4>Resultados de la búsqueda:</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID CLIENTE</th>
                                <th>USUARIO</th>
                                <th>CONTRASEÑA</th>
                                <th>CORREO</th>
                                <th>CEDULA</th>
                                <th>RESPUESTA</th>
                                <th>NOMBRE USUARIO</th>
                                <th>FECHA INICIO</th>
                                <th>ESTADO</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $resultado): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($resultado['id_cliente']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['contraseña']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['correo']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['cedula']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['respuesta']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['nombre_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['fecha_inicio']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['estado']); ?></td>
                                    <td>
                                        <a class="btn btn-warning" href="?id=<?php echo htmlspecialchars($resultado['id_cliente']); ?>">Editar</a>
                                        <a class="btn btn-danger" href="?borrar_id=<?php echo htmlspecialchars($resultado['id_cliente']); ?>">Borrar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif (isset($_GET['enviar']) && empty($resultados)): ?>
                <div class="mt-4">
                    <?php
                    //$_SESSION['message'] = "No se encontraron Resultados";
                    //$_SESSION['message_type'] = "alert-danger";
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Agregar"])) {
            try {
                $usuario = $_POST["txtusuario"];
                $contraseña = $_POST["txtcontraseña"];
                $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);
                $correo = $_POST["txtcorreo"];
                $cedula = $_POST["txtcedula"];
                $respuesta = $_POST["txtrespuesta"];
                $nombre_usuario = $_POST["txtnombreusuario"];
                $estado = $_POST["txtestado"];

                $consulta = "INSERT INTO cliente (usuario, contraseña, correo, cedula, respuesta, nombre_usuario, estado) "
                        . "VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conexion->prepare($consulta);
                $stmt->bindParam(1, $usuario);
                $stmt->bindParam(2, $contraseña_hash);
                $stmt->bindParam(3, $correo);
                $stmt->bindParam(4, $cedula);
                $stmt->bindParam(5, $respuesta);
                $stmt->bindParam(6, $nombre_usuario);
                $stmt->bindParam(7, $estado);

                $stmt->execute();
                $_SESSION['message'] = "Usuario Agregado Correctamente";
                $_SESSION['message_type'] = "success";
                echo '<script>window.location="./Usuarios.php"</script>';
                //echo "Los datos se han insertado correctamente en la tabla libro.";
            } catch (PDOException $e) {
                echo "Error al insertar datos en la tabla Usuarios: " . $e->getMessage();
            }
        }
        ?>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Actualizar"])) {
            try {
                $idCliente = $_POST["txtidcliente"];
                $usuario = $_POST["txtusuario"];
                $contraseña = $_POST["txtcontraseña"];
                $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);
                if (password_verify($contraseña, $passwordHash)) { //Entra si no se cambio desde txt
                    $contraseña_hash = $contraseña; //contraHash es la contra encriptada
                }

                $correo = $_POST["txtcorreo"];
                $cedula = $_POST["txtcedula"];
                $respuesta = $_POST["txtrespuesta"];
                $nombre_usuario = $_POST["txtnombreusuario"];
                $estado = $_POST["txtestado"];

                $consulta = "UPDATE cliente SET usuario = ?, contraseña = ?, correo = ?, cedula = ?, respuesta = ?, nombre_usuario = ?, "
                        . " estado = ? WHERE id_cliente = ?";
                $stmt = $conexion->prepare($consulta);
                $stmt->bindParam(1, $usuario);
                $stmt->bindParam(2, $contraseña_hash);
                $stmt->bindParam(3, $correo);
                $stmt->bindParam(4, $cedula);
                $stmt->bindParam(5, $respuesta);
                $stmt->bindParam(6, $nombre_usuario);
                $stmt->bindParam(7, $estado);
                $stmt->bindParam(8, $idCliente);

                $stmt->execute();
                $_SESSION['message'] = "Usuario Actualizado Correctamente";
                $_SESSION['message_type'] = "success";
                echo '<script>window.location="./Usuarios.php"</script>';
                //echo "Los datos se han actualizado correctamente en la tabla libro.";
            } catch (PDOException $e) {
                echo "Error al actualizar datos en la tabla Usuarios: " . $e->getMessage();
            }
        }

        if (isset($_GET['borrar_id'])) {
            $id_libro_borrar = $_GET['borrar_id'];
            try {
                $consulta_borrar = "DELETE FROM cliente WHERE id_cliente = ?";
                $stmt = $conexion->prepare($consulta_borrar);
                $stmt->execute([$id_libro_borrar]);
                $_SESSION['message'] = "Usuarios Borrado correctamente";
                $_SESSION['message_type'] = "success";
                echo '<script>window.location="./Usuarios.php"</script>';
            } catch (PDOException $e) {
                echo "Error al intentar borrar en Usuarios: " . $e->getMessage();
            }
        }

        ?>
    </body>
</html>
