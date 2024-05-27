<?php
require("../../ConfiguracionBD/ConexionBDPDO.php");
$prestamo = [];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $consulta = "SELECT * FROM movimientoslibros WHERE id_prestamo = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->execute([$id]);
    $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);
}
try {
    $consultaBusqueda = "SELECT * FROM movimientoslibros";
    if (!empty($_GET['busqueda'])) {
        $busqueda = $_GET['busqueda'];
        if (isset($_GET['id_prestamo'])) {
            $consultaBusqueda .= " WHERE id_prestamo LIKE '%$busqueda%'";
        } elseif (isset($_GET['titulo'])) {
            $consultaBusqueda .= " WHERE titulo LIKE '%$busqueda%'";
        } elseif (isset($_GET['autor'])) {
            $consultaBusqueda .= " WHERE autor LIKE '%$busqueda%'";
        } elseif (isset($_GET['sinopsis'])) {
            $consultaBusqueda .= " WHERE sinopsis LIKE '%$busqueda%'";
        }
    }
    $ejecutar = $conexion->prepare($consultaBusqueda);
    $ejecutar->execute();
    $resultados = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al listar la tabla<br/>" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Búsqueda de Movimiento Libros</title>
    </head>
    <body>
        <div style="margin: 0 auto; width: 80%;">
            <h2 class="mt-4 text-center">Búsqueda de Movimiento Libros</h2><br>
            <form action="" method="get" style="margin: 0 auto; width: 75%;">
                <div class="form-group">
                    <label for="busqueda">Buscar:</label><br>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese la búsqueda">
                </div><br>
                <a class="btn btn-warning" href="./MovimientoLibros.php">Actualizar</a>
                <button type="submit" name="id_prestamo" class="btn btn-primary">Buscar por id prestamo</button>
                <button type="submit" name="titulo" class="btn btn-primary">Buscar por titulo</button>
                <button type="submit" name="autor" class="btn btn-primary">Buscar por Autor</button>
                <button type="submit" name="sinopsis" class="btn btn-primary">Buscar por Sinopsis</button>
            </form><br>

            <div class="card" style="margin: 0 200px;">
                <div class="card-body">
                    <form action="./MovimientoLibros.php" method="POST">
                        <div class="form-group">
                            <label>Id Prestamo</label>
                            <input type="text" value="<?php echo isset($prestamo['id_prestamo']) ? htmlspecialchars($prestamo['id_prestamo']) : ''; ?>"
                                   name="txtidprestamo" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Id Libro</label>
                            <input type="text" value="<?php echo isset($prestamo['id_libro']) ? htmlspecialchars($prestamo['id_libro']) : ''; ?>"
                                   name="txtidlibro" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Id Cliente</label>
                            <input type="text" value="<?php echo isset($prestamo['id_cliente']) ? htmlspecialchars($prestamo['id_cliente']) : ''; ?>"
                                   name="txtidcliente" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Id Empleado Presta</label>
                            <input type="text" value="<?php echo isset($prestamo['id_empleado_presta']) ? htmlspecialchars($prestamo['id_empleado_presta']) : ''; ?>"
                                   name="txtidempleadopresta" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Id Empleado Recibe</label>
                            <input type="text" value="<?php echo isset($prestamo['id_empleado_recibe']) ? htmlspecialchars($prestamo['id_empleado_recibe']) : ''; ?>"
                                   name="txtidempleadorecibe" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Titulo</label>
                            <input type="text" value="<?php echo isset($prestamo['titulo']) ? htmlspecialchars($prestamo['titulo']) : ''; ?>"
                                   name="txttitulo" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Autor</label>
                            <input type="text" value="<?php echo isset($prestamo['autor']) ? htmlspecialchars($prestamo['autor']) : ''; ?>"
                                   name="txtautor" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Sinopsis</label>
                            <input type="text" value="<?php echo isset($prestamo['sinopsis']) ? htmlspecialchars($prestamo['sinopsis']) : ''; ?>"
                                   name="txtsinopsis" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Categoria</label>
                            <input type="text" value="<?php echo isset($prestamo['categoria']) ? htmlspecialchars($prestamo['categoria']) : ''; ?>"
                                   name="txtcategoria" class="form-control" readonly>
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

            <?php if ( !empty($resultados)): ?>
                <div class="mt-4">
                    <h4>Movimiento Libros:</h4>
                    <table class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID PRESTAMO</th>
                                <th>ID LIBRO</th>
                                <th>ID CLIENTE</th>
                                <th>ID EMPLEADO PRESTA</th>
                                <th>ID EMPLEADO RECIBE</th>
                                <th>TITULO</th>
                                <th>AUTOR</th>
                                <th>SINOPSIS</th>
                                <th>CATEGORIA</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $resultado): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($resultado['id_prestamo']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_libro']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_cliente']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_empleado_presta']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['id_empleado_recibe']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['autor']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['sinopsis']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['categoria']); ?></td>
                                    <td>
                                        <a class="btn btn-warning" href="?id=<?php echo htmlspecialchars($resultado['id_prestamo']); ?>">Editar</a>
                                        <!--<a class="btn btn-danger" href="?borrar_id=<?php echo htmlspecialchars($resultado['id_prestamo']); ?>">Borrar</a>-->
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
                $idPrestamo = $_POST["txtidprestamo"];
                $idLibro = $_POST["txtidlibro"];
                $idCliente = $_POST["txtidcliente"];

                $consulta = "UPDATE prestamo SET id_libro = ?, id_cliente = ? WHERE id_prestamo = ?;";
                $stmt = $conexion->prepare($consulta);
                $stmt->bindParam(1, $idLibro);
                $stmt->bindParam(2, $idCliente);
                $stmt->bindParam(3, $idPrestamo);
                $stmt->execute();

                if ($stmt->rowCount() == 0) {
                    $_SESSION['message'] = "Error en datos";
                    
                    $_SESSION['message_type'] = "error";
                } else {
                    $_SESSION['message'] = "Movimiento Actualizado exitosamente";
                    $_SESSION['message_type'] = "success";
                }
                echo '<script>window.location="./MovimientoLibros.php"</script>';
                //echo "Los datos se han actualizado correctamente en la tabla libro.";
            } catch (PDOException $e) {
                echo "Error al actualizar datos en la tabla libro: " . $e->getMessage();
            }
        }
        ?>
    </body>
</html>
