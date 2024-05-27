<?php
require("../../ConfiguracionBD/ConexionBDPDO.php");
$multa = [];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $consulta = "SELECT multa.id_multa , multa.id_cliente , cliente.nombre_usuario , multa.id_prestamo , 
        multa.id_libro , multa.id_empleado_presta , multa.valor , multa.fecha_pago , multa.demora , 
        multa.estado FROM multa 
        INNER JOIN cliente ON multa.id_cliente = cliente.id_cliente 
        WHERE id_multa = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->execute([$id]);
    $multa = $stmt->fetch(PDO::FETCH_ASSOC);
}
try {
    $consultaBusqueda = "SELECT multa.id_multa , multa.id_cliente , cliente.nombre_usuario , multa.id_prestamo , multa.id_libro , multa.id_empleado_presta , 
        multa.valor , multa.fecha_pago , multa.demora , multa.estado FROM multa 
        INNER JOIN prestamo ON multa.id_prestamo = prestamo.id_prestamo 
        INNER JOIN libro ON multa.id_libro = libro.id_libro 
        INNER JOIN cliente ON multa.id_cliente = cliente.id_cliente 
        INNER JOIN empleado ON multa.id_empleado_presta = empleado.id_empleado";
    if (!empty($_GET['busqueda'])) {
        $busqueda = $_GET['busqueda'];
        if (isset($_GET['id_cliente'])) {
            $consultaBusqueda .= " WHERE cliente.id_cliente = '$busqueda'";
        } elseif (isset($_GET['id_dni_cliente'])) {
            $consultaBusqueda .= " WHERE cliente.cedula = '$busqueda'";
        } elseif (isset($_GET['nombre_cliente'])) {
            $consultaBusqueda .= " WHERE cliente.nombre_usuario = '$busqueda'";
        } elseif (isset($_GET['estado'])) {
            $consultaBusqueda .= " WHERE multa.estado = '$busqueda'";
        }
    }
    $ejecutar = $conexion->prepare($consultaBusqueda);
    $ejecutar->execute();
    $resultados = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Error al listar la tabla</p><br/>" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Búsqueda de Multas</title>
    </head>
    <body>
        <div style="margin: 0 auto; width: 80%;">
            <h2 class="mt-4 text-center">Búsqueda de Multas</h2><br>
            <form action="" method="get" style="margin: 0 auto; width: 75%;">
                <div class="form-group">
                    <label for="busqueda">Buscar:</label><br>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese la búsqueda">
                </div><br>
                <a class="btn btn-warning" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">Actualizar</a>
                <!--<a class="btn btn-warning" href="./Multas.php">Actualizar</a>-->
                <button type="submit" name="id_cliente" class="btn btn-primary">Buscar por id Cliente</button>
                <button type="submit" name="id_dni_cliente" class="btn btn-primary">Buscar por Dni Cliente</button>
                <button type="submit" name="nombre_cliente" class="btn btn-primary">Buscar por Nombre Cliente</button>
                <button type="submit" name="estado" class="btn btn-primary">Buscar por Estado</button>
            </form><br>

            <div class="card" style="margin: 0 200px;">
                <div class="card-body">
                    <form action="./Multas.php" method="POST">
                        <div class="form-group">
                            <label>Id Multa</label>
                            <input type="number" value="<?php echo isset($multa['id_multa']) ? htmlspecialchars($multa['id_multa']) : ''; ?>"
                                   name="txtidmulta" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Id Cliente</label>
                            <input type="number" value="<?php echo isset($multa['id_cliente']) ? htmlspecialchars($multa['id_cliente']) : ''; ?>"
                                   name="txtidcliente" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nombre Cliente</label>
                            <input type="text" value="<?php echo isset($multa['nombre_usuario']) ? htmlspecialchars($multa['nombre_usuario']) : ''; ?>"
                                   name="txtnombreusuario" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Id Prestamo</label>
                            <input type="number" value="<?php echo isset($multa['id_prestamo']) ? htmlspecialchars($multa['id_prestamo']) : ''; ?>"
                                   name="txtidprestamo" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Id Libro</label>
                            <input type="number" value="<?php echo isset($multa['id_libro']) ? htmlspecialchars($multa['id_libro']) : ''; ?>"
                                   name="txtidlibro" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Id Empleado Presta</label>
                            <input type="number" value="<?php echo isset($multa['id_empleado_presta']) ? htmlspecialchars($multa['id_empleado_presta']) : ''; ?>"
                                   name="txtidempleadpresta" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="number" value="<?php echo isset($multa['valor']) ? htmlspecialchars($multa['valor']) : ''; ?>"
                                   name="txtvalor" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Fecha Pago</label>
                            <input type="text" value="<?php echo isset($multa['fecha_pago']) ? htmlspecialchars($multa['fecha_pago']) : ''; ?>"
                                   name="txtfechapago" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Demora</label>
                            <input type="number" value="<?php echo isset($multa['demora']) ? htmlspecialchars($multa['demora']) : ''; ?>"
                                   name="txtdemora" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="txtestado" class="form-control">
                                <option value="PENDIENTE">PENDIENTE</option>
                                <option value="PAGO">PAGO</option>
                            </select>
                        </div><br>
                        <!--<input type="submit" name="Agregar" value="Agregar" class="btn btn-info">-->
                        <input type="submit" name="Actualizar" value="Actualizar" class="btn btn-success">
                    </form>
                </div>
            </div>

            <?php
            // Mostrar mensaje de éxito o error si existe
            if (isset($_SESSION['message'])) {
                $alert_type = $_SESSION['message_type'] === 'error' ? 'alert-danger' : 'alert-success';
                echo '<div class="alert ' . $alert_type . '" role="alert">';
                echo '<h2 class="text-center">' . $_SESSION['message'] . '</h2>';
                echo '</div>';
                // Eliminar el mensaje después de mostrarlo
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>

            <?php if (!empty($resultados)): ?>
                <div class="mt-4">
                    <h4>Multas:</h4>
                    <table class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID MULTA</th>
                                <th>ID CLIENTE</th>
                                <th>NOMBRE CLIENTE</th>
                                <th>ID PRESTAMO</th>
                                <th>ID LIBRO</th>
                                <th>ID EMPLEADO PRESTA</th>
                                <th>VALOR</th>
                                <th>FECHA PAGO</th>
                                <th>DEMORA</th>
                                <th>ESTADO</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $resultado): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($resultado['id_multa']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_cliente']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['nombre_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_prestamo']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_libro']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_empleado_presta']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['valor']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['fecha_pago']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['demora']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['estado']); ?></td>
                                    <td>
                                        <a class="btn btn-warning" href="?id=<?php echo htmlspecialchars($resultado['id_multa']); ?>">Editar</a>
                                        <a class="btn btn-danger" href="?borrar_id=<?php echo htmlspecialchars($resultado['id_multa']); ?>">Borrar</a>
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
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Actualizar"])) {
            try {
                $estado = $_POST["txtestado"];
                $idMulta = $_POST["txtidmulta"];

                $consulta = "UPDATE multa SET estado = ? WHERE id_multa = ?;";
                $stmt = $conexion->prepare($consulta);
                $stmt->bindParam(1, $estado);
                $stmt->bindParam(2, $idMulta);
                $stmt->execute();

                if ($stmt->rowCount() == 0) {
                    $_SESSION['message'] = "Error en datos";

                    $_SESSION['message_type'] = "error";
                } else {
                    $_SESSION['message'] = "Multa Actualizado exitosamente";
                    $_SESSION['message_type'] = "success";
                }
                echo '<script>window.location="./Multas.php"</script>';
                //echo "Los datos se han actualizado correctamente en la tabla libro.";
            } catch (PDOException $e) {
                echo "Error al actualizar datos en la tabla libro: " . $e->getMessage();
            }
        }


        if (isset($_GET['borrar_id'])) {
            $id_libro_borrar = $_GET['borrar_id'];
            try {
                $consulta_borrar = "DELETE FROM multa WHERE id_multa = ?";
                $stmt = $conexion->prepare($consulta_borrar);
                $stmt->execute([$id_libro_borrar]);
                $_SESSION['message'] = "Multa Borrada correctamente";
                $_SESSION['message_type'] = "success";
                echo '<script>window.location="./Multas.php"</script>';
            } catch (PDOException $e) {
                echo "Error al intentar borrar el libro: " . $e->getMessage();
            }
        }
        ?>
    </body>
</html>
