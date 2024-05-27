<?php
require("../../ConfiguracionBD/ConexionBDPDO.php");
$libro = [];
$resultados = [];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $consulta = "SELECT * FROM prestamo WHERE id_prestamo = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->execute([$id]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);
}

try {
    $consultaBusqueda = "SELECT * FROM prestamo";
    if (!empty($_GET['busqueda'])) {
        $busqueda = $_GET['busqueda'];
        if (isset($_GET['id_libro'])) {
            $consultaBusqueda .= " WHERE id_libro LIKE '%$busqueda%'";
        } elseif (isset($_GET['id_cliente'])) {
            $consultaBusqueda .= " WHERE id_cliente LIKE '%$busqueda%'";
        } elseif (isset($_GET['id_empleado_presta'])) {
            $consultaBusqueda .= " WHERE id_empleado_presta LIKE '%$busqueda%'";
        }
    }
    $ejecutar = $conexion->prepare($consultaBusqueda);
    $ejecutar->execute();
    $resultados = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al listar los préstamos<br/>" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Búsqueda de Prestamos</title>
    </head>
    <body>
        <div style="margin: 0 auto; width: 80%;">
            <h2 class="mt-4 text-center">Búsqueda de Préstamos</h2><br>
            <form action="" method="get" style="margin: 0 auto; width: 75%;">
                <div class="form-group">
                    <label for="busqueda">Buscar:</label><br>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese la búsqueda">
                </div><br>
                <a class="btn btn-warning" href="./Prestamos.php">Actualizar</a>
                <button type="submit" name="id_libro" class="btn btn-primary">Buscar por No. Libro</button>
                <button type="submit" name="id_cliente" class="btn btn-primary">Buscar por Cliente</button>
                <button type="submit" name="id_empleado_presta" class="btn btn-primary">Buscar por No. Empleado</button>
            </form><br>

            <div class="card" style="margin: 0 200px;">
                <div class="card-body">
                    <form action="./Prestamos.php" method="POST">
                        <div class="form-group">
                            <label>Id Préstamo</label>
                            <input type="number" value="<?php echo isset($libro['id_prestamo']) ? htmlspecialchars($libro['id_prestamo']) : ''; ?>"
                                   name="txtidprestamo" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Fecha Inicio (AAAA-MM-DD):</label>
                            <input type="text" value="<?php echo isset($libro['fecha_inicio']) ? htmlspecialchars($libro['fecha_inicio']) : ''; ?>"
                                   name="txtfechainicio" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Fecha Limite (AAAA-MM-DD):</label>
                            <input type="text" value="<?php echo isset($libro['fecha_limite_entrega']) ? htmlspecialchars($libro['fecha_limite_entrega']) : ''; ?>"
                                   name="txtfechalimiteentrega" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Fecha Entregada (AAAA-MM-DD):</label>
                            <input type="text" value="<?php echo isset($libro['fecha_entrega']) ? htmlspecialchars($libro['fecha_entrega']) : ''; ?>"
                                   name="txtfechaentrega" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Id Libro</label>
                            <input type="number" value="<?php echo isset($libro['id_libro']) ? htmlspecialchars($libro['id_libro']) : ''; ?>"
                                   name="txtidlibro" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label>Id Cliente</label>
                            <input type="number" value="<?php echo isset($libro['id_cliente']) ? htmlspecialchars($libro['id_cliente']) : ''; ?>"
                                   name="txtidcliente" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label>Id empleado que presta</label>
                            <input type="number" value="<?php echo isset($libro['id_empleado_presta']) ? htmlspecialchars($libro['id_empleado_presta']) : ''; ?>"
                                   name="txtidempleadopresta" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label>Id empleado que recibe</label>
                            <input type="number" value="<?php echo isset($libro['id_empleado_recibe']) ? htmlspecialchars($libro['id_empleado_recibe']) : ''; ?>"
                                   name="txtidempleadorecibe" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Retraso en Días</label>
                            <input type="text" value="<?php echo isset($libro['retraso_dias']) ? htmlspecialchars($libro['retraso_dias']) : NULL; ?>"
                                   name="txtretrasodias" class="form-control" readonly>
                        </div><br>
                        <input type="submit" name="Agregar" value="Agregar" class="btn btn-info">
                        <input type="submit" name="Actualizar" value="Actualizar" class="btn btn-success">
                        <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-warning">
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
                    <h4>Prestamos:</h4>
                    <table class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID PRESTAMO</th>
                                <th>FECHA INICIO</th>
                                <th>FECHA LIMITE</th>
                                <th>FECHA ENTREGADA</th>
                                <th>ID LIBRO</th>
                                <th>ID CLIENTE</th>
                                <th>ID EMPLEADO PRESTO</th>
                                <th>ID EMPLEADO RECIBE</th>
                                <th>RETRASO DÍAS</th>
                                <th>ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $resultado): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($resultado['id_prestamo']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['fecha_inicio']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['fecha_limite_entrega']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['fecha_entrega']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_libro']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_cliente']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_empleado_presta']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_empleado_recibe']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['retraso_dias']); ?></td>
                                    <td>
                                        <a class="btn btn-warning" href="?id=<?php echo htmlspecialchars($resultado['id_prestamo']); ?>">Editar</a>
                                        <a class="btn btn-danger" href="?borrar_id=<?php echo htmlspecialchars($resultado['id_prestamo']); ?>">Borrar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif (isset($_GET['busqueda']) && empty($resultados)): ?>
                <div class="mt-4">
                    <?php
                    //$_SESSION['message'] = "No se encontraron Resultados";
                    //$_SESSION['message_type'] = "alert-danger";
                    ?>
                </div>
            <?php endif; ?>
        </div><br>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Agregar"])) {
            try {
                $fechaInicio = $_POST["txtfechainicio"];
                $fechaEntrega = !empty($_POST["txtfechaentrega"]) ? $_POST["txtfechaentrega"] : NULL;
                $idLibro = $_POST["txtidlibro"];
                $idCliente = $_POST["txtidcliente"];
                $empleadoPresta = $_POST["txtidempleadopresta"];
                $empleadoRecibe = !empty($_POST["txtidempleadorecibe"]) ? $_POST["txtidempleadorecibe"] : NULL;
                $retrasoDias = !empty($_POST["txtretrasodias"]) ? $_POST["txtretrasodias"] : NULL;

                $consulta = "INSERT INTO prestamo (fecha_inicio, fecha_limite_entrega, fecha_entrega, id_libro, id_cliente, id_empleado_presta, id_empleado_recibe, retraso_dias) "
                        . "SELECT ?, DATE_ADD(?, INTERVAL 8 DAY), ?, ?, ?, ?, ?, ? "
                        . "FROM dual WHERE EXISTS (SELECT 1 FROM libro WHERE id_libro = ? AND estado = 'activo')";

                $stmt = $conexion->prepare($consulta);
                $stmt->execute([$fechaInicio, $fechaInicio, $fechaEntrega, $idLibro, $idCliente, $empleadoPresta, $empleadoRecibe, $retrasoDias, $idLibro]);

                if ($stmt->rowCount() == 0) {
                    $_SESSION['message'] = "El libro no está activo";
                    $_SESSION['message_type'] = "error";
                } else {
                    $_SESSION['message'] = "Dato Ingresado exitosamente";
                    $_SESSION['message_type'] = "success";
                }
                echo '<script>window.location="./Prestamos.php"</script>';
            } catch (PDOException $e) {
                echo "Error al insertar datos en la tabla préstamos: " . $e->getMessage();
                $_SESSION['message'] = "Error al insertar datos en la tabla préstamos";
                $_SESSION['message_type'] = "error";
                echo '<script>window.location="./Prestamos.php"</script>';
            }
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Actualizar"])) {
            try {
                $idPrestamo = $_POST["txtidprestamo"];
                $fechaInicio = $_POST["txtfechainicio"];
                $fechaLimite = $_POST["fecha_limite_entrega"];
                $fechaEntrega = !empty($_POST["txtfechaentrega"]) ? $_POST["txtfechaentrega"] : NULL;
                $idLibro = $_POST["txtidlibro"];
                $idCliente = $_POST["txtidcliente"];
                $empleadoPresta = $_POST["txtidempleadopresta"];
                $empleadoRecibe = !empty($_POST["txtidempleadorecibe"]) ? $_POST["txtidempleadorecibe"] : NULL;
                $retrasoDias = !empty($_POST["txtretrasodias"]) ? $_POST["txtretrasodias"] : NULL;

                $consulta = "UPDATE prestamo SET fecha_inicio = ?, fecha_entrega = ?, id_libro = ?, id_cliente = ?, id_empleado_presta = ?, id_empleado_recibe = ?, retraso_dias = ? WHERE id_prestamo = ?";
                $stmt = $conexion->prepare($consulta);
                $stmt->execute([$fechaInicio, $fechaLimite, $fechaEntrega, $idLibro, $idCliente, $empleadoPresta, $empleadoRecibe, $retrasoDias, $idPrestamo]);
                $_SESSION['message'] = "Dato Actualizado exitosamente";
                $_SESSION['message_type'] = "success";
                echo '<script>window.location="./Prestamos.php"</script>';
            } catch (PDOException $e) {
                echo "Error al actualizar datos en la tabla préstamos: " . $e->getMessage();
            }
        }

        if (isset($_GET['borrar_id'])) {
            $id_libro_borrar = $_GET['borrar_id'];
            try {
                $consulta_borrar = "DELETE FROM prestamo WHERE id_prestamo = ?";
                $stmt = $conexion->prepare($consulta_borrar);
                $stmt->execute([$id_libro_borrar]);
                $_SESSION['message'] = "Borrado correctamente";
                $_SESSION['message_type'] = "success";

                echo '<script>window.location="./Prestamos.php"</script>';
            } catch (PDOException $e) {
                echo "Error al intentar borrar el préstamo: " . $e->getMessage();
            }
        }
        ?>
    </body>
</html>
