<?php
require("../../ConfiguracionBD/ConexionBDPDO.php");
$empleado = [];
$resultados = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $consulta = "SELECT * FROM empleado WHERE id_empleado = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->execute([$id]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);
}
try {
    $consultaBusqueda = "SELECT * FROM empleado";
    if (!empty($_GET['busqueda'])) {
        $busqueda = $_GET['busqueda'];
        if (isset($_GET['id_empleado'])) {
            $consultaBusqueda .= " WHERE id_empleado = '$busqueda'";
        } elseif (isset($_GET['nombre_emp'])) {
            $consultaBusqueda .= " WHERE nombre_emp LIKE '%$busqueda%' OR apellido_emp LIKE '%$busqueda%'";
        } elseif (isset($_GET['cedula'])) {
            $consultaBusqueda .= " WHERE cedula = '$busqueda'";
        }
    } else {
        $consultaBusqueda .= " WHERE id_empleado > 1;";// WHERE id_empleado > 1
    }
    $ejecutar = $conexion->prepare($consultaBusqueda);
    $ejecutar->execute();
    $resultados = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al listar la tabla Empleado<br/>" . $e->getMessage();
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
            <h2 class="mt-4 text-center">Búsqueda de Empleados</h2><br>
            <form action="" method="get" style="margin: 0 200px;">
                <div class="form-group">
                    <label for="busqueda">Buscar:</label><br>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" 
                           placeholder="Ingrese la búsqueda" style="width: 100%;">
                </div><br>
                <button type="submit" name="enviar" class="btn btn-warning">Mostrar Todos</button>
                <button type="submit" name="id_empleado" class="btn btn-primary">Buscar por Id Empleado</button>
                <button type="submit" name="nombre_emp" class="btn btn-primary">Buscar por Nombre Empleado</button>
                <button type="submit" name="cedula" class="btn btn-primary">Buscar por Cedula</button>
            </form><br>

            <div class="card" style="margin: 0 200px;">
                <div class="card-body">
                    <form action="./Empleados.php" method="POST">
                        <div class="form-group">
                            <label>Id Emp</label>
                            <input type="number" value="<?php echo isset($empleado['id_empleado']) ? htmlspecialchars($empleado['id_empleado']) : ''; ?>"
                                   name="txtidempleado" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" value="<?php echo isset($empleado['usuario']) ? htmlspecialchars($empleado['usuario']) : ''; ?>"
                                   name="txtusuario" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="text" value="<?php echo isset($empleado['contraseña']) ? htmlspecialchars($empleado['contraseña']) : ''; ?>"
                                   name="txtcontraseña" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Correo</label>
                            <input type="text" value="<?php echo isset($empleado['correo']) ? htmlspecialchars($empleado['correo']) : ''; ?>"
                                   name="txtcorreo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Cedula</label>
                            <input type="number" value="<?php echo isset($empleado['cedula']) ? htmlspecialchars($empleado['cedula']) : ''; ?>"
                                   name="txtcedula" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Respuesta</label>
                            <input type="text" value="<?php echo isset($empleado['respuesta']) ? htmlspecialchars($empleado['respuesta']) : ''; ?>"
                                   name="txtrespuesta" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nombre Emp</label>
                            <input type="text" value="<?php echo isset($empleado['nombre_emp']) ? htmlspecialchars($empleado['nombre_emp']) : ''; ?>"
                                   name="txtnombreemp" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Apellido Emp</label>
                            <input type="text" value="<?php echo isset($empleado['apellido_emp']) ? htmlspecialchars($empleado['apellido_emp']) : ''; ?>"
                                   name="txtapellidoemp" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Fecha Inicio</label>
                            <input type="text" value="<?php echo isset($empleado['fecha_inicio']) ? htmlspecialchars($empleado['fecha_inicio']) : ''; ?>"
                                   name="txtfechainicio" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Fecha Fin</label>
                            <input type="text" value="<?php echo isset($empleado['fecha_fin']) ? htmlspecialchars($empleado['fecha_fin']) : ''; ?>"
                                   name="txtfechafin" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <input type="text" value="<?php echo isset($empleado['rol']) ? htmlspecialchars($empleado['rol']) : ''; ?>"
                                   name="txtrol" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" value="<?php echo isset($empleado['estado']) ? htmlspecialchars($empleado['estado']) : ''; ?>"
                                   name="txtestado" class="form-control">
                        </div><br>
                        <input type="submit" name="Agregar" value="Agregar" class="btn btn-info">
                        <input type="submit" name="Actualizar" value="Actualizar" class="btn btn-success">
                    </form>
                </div>
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
                            <th>ID EMP</th>
                            <th>USUARIO</th>
                            <th>CONTRASEÑA</th>
                            <th>CORREO</th>
                            <th>CEDULA</th>
                            <th>RESPUESTA</th>
                            <th>NOMBRE EMP</th>
                            <th>APELLIDO EMP</th>
                            <th>FECHA INICIO</th>
                            <th>FECHA FIN</th>
                            <th>ROL</th>
                            <th>ESTADO</th>
                            <th>ACCION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $resultado): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($resultado['id_empleado']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['usuario']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['contraseña']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['correo']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['cedula']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['respuesta']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['nombre_emp']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['apellido_emp']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['fecha_inicio']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['fecha_fin']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['rol']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['estado']); ?></td>
                                <td>
                                    <a class="btn btn-warning" href="?id=<?php echo htmlspecialchars($resultado['id_empleado']); ?>">Editar</a>
                                    <a class="btn btn-danger" href="?borrar_id=<?php echo htmlspecialchars($resultado['id_empleado']); ?>">Borrar</a>
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
            $cedula = $_POST["txtcedula"];
            $correo = $_POST["txtcorreo"];
            $respuesta = $_POST["txtrespuesta"];
            $nombreEmp = $_POST["txtnombreemp"];
            $apellidoEmp = $_POST["txtapellidoemp"];
            $fechaFin = $_POST["txtfechafin"];
            $rol = $_POST["txtrol"];
            $estado = $_POST["txtestado"];

            $consulta = "INSERT INTO empleado (usuario, contraseña, cedula, respuesta, correo, nombre_emp, apellido_emp, fecha_fin, rol, estado) "
                    . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(1, $usuario);
            $stmt->bindParam(2, $contraseña_hash);
            $stmt->bindParam(3, $cedula);
            $stmt->bindParam(4, $respuesta);
            $stmt->bindParam(5, $correo);
            $stmt->bindParam(6, $nombreEmp);
            $stmt->bindParam(7, $apellidoEmp);
            $stmt->bindParam(8, $fechaFin);
            $stmt->bindParam(9, $rol);
            $stmt->bindParam(10, $estado);

            $stmt->execute();
            $_SESSION['message'] = "Usuario Agregado Correctamente";
            $_SESSION['message_type'] = "success";
            echo '<script>window.location="./Empleados.php"</script>';
            //echo "Los datos se han insertado correctamente en la tabla libro.";
        } catch (PDOException $e) {
            echo "Error al insertar datos en la tabla Empleados: " . $e->getMessage();
        }
    }
    ?>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Actualizar"])) {
        try {
            $idEmpleado = $_POST["txtidempleado"];
            $usuario = $_POST["txtusuario"];
            $contraseña = $_POST["txtcontraseña"];
            $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

            if (password_verify($contraseña, $passwordHash)) { //Entra si no se cambio desde txt
                $contraseña_hash = $contraseña; //contraHash es la contra encriptada
            }

            $cedula = $_POST["txtcedula"];
            $correo = $_POST["txtcorreo"];
            $respuesta = $_POST["txtrespuesta"];
            $nombreEmp = $_POST["txtnombreemp"];
            $apellidoEmp = $_POST["txtapellidoemp"];
            $fechaFin = $_POST["txtfechafin"];
            $rol = $_POST["txtrol"];
            $estado = $_POST["txtestado"];

            $consulta = "UPDATE empleado SET usuario = ?, contraseña = ?, cedula = ?, respuesta = ?, correo = ?, nombre_emp = ?, apellido_emp = ?,"
                    . " fecha_fin = ?, rol = ?, estado = ? WHERE id_empleado = ?";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(1, $usuario);
            $stmt->bindParam(2, $contraseña_hash);
            $stmt->bindParam(3, $cedula);
            $stmt->bindParam(4, $respuesta);
            $stmt->bindParam(5, $correo);
            $stmt->bindParam(6, $nombreEmp);
            $stmt->bindParam(7, $apellidoEmp);
            $stmt->bindParam(8, $fechaFin);
            $stmt->bindParam(9, $rol);
            $stmt->bindParam(10, $estado);
            $stmt->bindParam(11, $idEmpleado);

            $stmt->execute();
            $_SESSION['message'] = "Usuario Actualizado Correctamente";
            $_SESSION['message_type'] = "success";
            echo '<script>window.location="./Empleados.php"</script>';
            //echo "Los datos se han actualizado correctamente en la tabla libro.";
        } catch (PDOException $e) {
            echo "Error al actualizar datos en la tabla Empleados: " . $e->getMessage();
        }
    }

    if (isset($_GET['borrar_id'])) {
        $id_libro_borrar = $_GET['borrar_id'];
        try {
            $consulta_borrar = "DELETE FROM empleado WHERE id_empleado != 1 AND id_empleado = ?";
            $stmt = $conexion->prepare($consulta_borrar);
            $stmt->execute([$id_libro_borrar]);
            $_SESSION['message'] = "Usuarios Borrado correctamente";
            $_SESSION['message_type'] = "success";
            echo '<script>window.location="./Empleados.php"</script>';
        } catch (PDOException $e) {
            $_SESSION['message'] = "Error en Consulta";
            $_SESSION['message_type'] = "error";
            echo "Error al intentar borrar en Usuarios: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
