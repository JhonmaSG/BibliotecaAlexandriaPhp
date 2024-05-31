<?php
//session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_cuenta'] != 'empleado') {
    header("Location: ../../NoUser/MensajeCerrarSesion.php");
    exit();
}
require("../../ConfiguracionBD/ConexionBDPDO.php");
$libro = [];
$resultados = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $consulta = "SELECT * FROM libro WHERE id_libro = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->execute([$id]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);
}
try {
    $consultaBusqueda = "SELECT * FROM libro";
    if (!empty($_GET['busqueda'])) {
        $busqueda = $_GET['busqueda'];
        if (isset($_GET['titulo'])) {
            $consultaBusqueda .= " WHERE titulo LIKE '%$busqueda%'";
        } elseif (isset($_GET['autor'])) {
            $consultaBusqueda .= " WHERE autor LIKE '%$busqueda%'";
        } elseif (isset($_GET['sinopsis'])) {
            $consultaBusqueda .= " WHERE sinopsis LIKE '%$busqueda%'";
        } elseif (isset($_GET['estado'])) {
            $consultaBusqueda .= " WHERE estado LIKE '%$busqueda%'";
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
        <title>Búsqueda de Libros</title>
    </head>
    <body>
        <div style="margin: 0 auto; width: 80%;">
            <h2 class="mt-4 text-center">Búsqueda de Libros</h2><br>
            <form action="" method="get" style="margin: 0 auto; width: 75%;">
                <div class="form-group">
                    <label for="busqueda">Buscar:</label><br>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese la búsqueda">
                </div><br>
                <a class="btn btn-warning" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">Actualizar</a>
                <button type="submit" name="titulo" class="btn btn-primary">Buscar por Título</button>
                <button type="submit" name="autor" class="btn btn-primary">Buscar por Autor</button>
                <button type="submit" name="sinopsis" class="btn btn-primary">Buscar por Sinopsis</button>
                <button type="submit" name="estado" class="btn btn-primary">Buscar por estado</button>
            </form><br>

            <div class="card" style="margin: 0 200px;">
                <div class="card-body">
                    <form action="./Libros.php" method="POST">
                        <div class="form-group">
                            <label>Id Libro</label>
                            <input type="number" value="<?php echo isset($libro['id_libro']) ? htmlspecialchars($libro['id_libro']) : ''; ?>" name="txtid" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Titulo</label>
                            <input type="text" value="<?php echo isset($libro['titulo']) ? htmlspecialchars($libro['titulo']) : ''; ?>" name="txttitulo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Autor</label>
                            <input type="text" value="<?php echo isset($libro['autor']) ? htmlspecialchars($libro['autor']) : ''; ?>" name="txtautor" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Sinopsis</label>
                            <input type="text" value="<?php echo isset($libro['sinopsis']) ? htmlspecialchars($libro['sinopsis']) : ''; ?>" name="txtsinopsis" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" value="<?php echo isset($libro['stock']) ? htmlspecialchars($libro['stock']) : ''; ?>" name="txtstock" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Categoria</label>
                            <input type="text" value="<?php echo isset($libro['categoria']) ? htmlspecialchars($libro['categoria']) : ''; ?>" name="txtcategoria" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" value="<?php echo isset($libro['estado']) ? htmlspecialchars($libro['estado']) : ''; ?>" name="txtestado" class="form-control">
                        </div><br>
                        <input type="submit" name="Agregar" value="Agregar" class="btn btn-info">
                        <input type="submit" name="Actualizar" value="Actualizar" class="btn btn-success">
                        <input type="reset" name="Limpiar" value="Limpiar" class="btn btn-warning">
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

            <?php if (!empty($resultados)):?>
                <div class="mt-4">
                    <h4>Libros:</h4>
                    <table class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID LIBRO</th>
                                <th>TITULO</th>
                                <th>AUTOR</th>
                                <th>SINOPSIS</th>
                                <th>STOCK</th>
                                <th>CATEGORIA</th>
                                <th>ESTADO</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $resultado): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($resultado['id_libro']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['autor']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['sinopsis']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['stock']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['categoria']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['estado']); ?></td>
                                    <td>
                                        <a class="btn btn-warning" href="?id=<?php echo htmlspecialchars($resultado['id_libro']); ?>">Editar</a>
                                        <a class="btn btn-danger" href="?borrar_id=<?php echo htmlspecialchars($resultado['id_libro']); ?>">Borrar</a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            <?php elseif( empty($resultados)): ?>
                <div class="mt-4">
                    <?php
                    //$_SESSION['message'] = "No se encontraron Resultados";
                    //$_SESSION['message_type'] = "alert-danger";
                    ?>
                </div>
            <?php endif;;?>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Agregar"])) {
            try {
                // Obtener los valores de los campos del formulario
                $titulo = $_POST["txttitulo"];
                $autor = $_POST["txtautor"];
                $sinopsis = $_POST["txtsinopsis"];
                $stock = $_POST["txtstock"];
                $categoria = $_POST["txtcategoria"];
                $estado = $_POST["txtestado"];

                $consulta = "INSERT INTO libro (titulo, autor, sinopsis, stock, categoria, estado) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conexion->prepare($consulta);
                $stmt->bindParam(1, $titulo);
                $stmt->bindParam(2, $autor);
                $stmt->bindParam(3, $sinopsis);
                $stmt->bindParam(4, $stock);
                $stmt->bindParam(5, $categoria);
                $stmt->bindParam(6, $estado);

                $stmt->execute();
                $_SESSION['message'] = "Dato Agregado Correctamente";
                $_SESSION['message_type'] = "success";
                echo '<script>window.location="./Libros.php"</script>';
                //echo "Los datos se han insertado correctamente en la tabla libro.";
            } catch (PDOException $e) {
                echo "Error al insertar datos en la tabla libro: " . $e->getMessage();
            }
        }
        ?>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Actualizar"])) {
            try {
                $id_libro = $_POST["txtid"];
                $titulo = $_POST["txttitulo"];
                $autor = $_POST["txtautor"];
                $sinopsis = $_POST["txtsinopsis"];
                $stock = $_POST["txtstock"];
                $categoria = $_POST["txtcategoria"];
                $estado = $_POST["txtestado"];

                $consulta = "UPDATE libro SET titulo = ?, autor = ?, sinopsis = ?, stock = ?, categoria = ?, estado = ? WHERE id_libro = ?";
                $stmt = $conexion->prepare($consulta);
                $stmt->bindParam(1, $titulo);
                $stmt->bindParam(2, $autor);
                $stmt->bindParam(3, $sinopsis);
                $stmt->bindParam(4, $stock);
                $stmt->bindParam(5, $categoria);
                $stmt->bindParam(6, $estado);
                $stmt->bindParam(7, $id_libro);

                $stmt->execute();
                $_SESSION['message'] = "Dato Actualizado Correctamente";
                $_SESSION['message_type'] = "success";
                echo '<script>window.location="./Libros.php"</script>';
                //echo "Los datos se han actualizado correctamente en la tabla libro.";
            } catch (PDOException $e) {
                echo "Error al actualizar datos en la tabla libro: " . $e->getMessage();
            }
        }

        if (isset($_GET['borrar_id'])) {
            $id_libro_borrar = $_GET['borrar_id'];
            try {
                $consulta_borrar = "DELETE FROM libro WHERE id_libro = ?";
                $stmt = $conexion->prepare($consulta_borrar);
                $stmt->execute([$id_libro_borrar]);
                $_SESSION['message'] = "Borrado correctamente";
                $_SESSION['message_type'] = "success";
                echo '<script>window.location="./Libros.php"</script>';
            } catch (PDOException $e) {
                echo "Error al intentar borrar el libro: " . $e->getMessage();
            }
        }
        ?>
    </body>
</html>
