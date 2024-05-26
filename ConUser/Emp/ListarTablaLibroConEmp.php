<?php
try {
    require("../../ConfiguracionBD/ConexionBDPDO.php");

    $consultaBusqueda = "SELECT * FROM libro";

    if (!empty($_GET['busqueda'])) {
        $busqueda = $_GET['busqueda'];
        if (isset($_GET['titulo'])) {
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
        <title>Búsqueda de Libros</title>
    </head>
    <body>
        <div class="container">
            <h2 class="mt-4">Búsqueda de Libros</h2><br>
            <form action="" method="get">
                <div class="form-group">
                    <label for="busqueda">Buscar:</label><br>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese la búsqueda" style="width: 70%;">
                </div><br>
                <button type="submit" name="enviar" class="btn btn-primary">Mostrar Todos</button>
                <button type="submit" name="titulo" class="btn btn-primary">Buscar por Título</button>
                <button type="submit" name="autor" class="btn btn-primary">Buscar por Autor</button>
                <button type="submit" name="sinopsis" class="btn btn-primary">Buscar por Sinopsis</button>
            </form>

            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Id Libro</label>
                            <input type="text" value="" name="txtid" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Titulo</label>
                            <input type="text" value="" name="txttitulo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Autor</label>
                            <input type="text" value="" name="txtautor" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Sinopsis</label>
                            <input type="text" value="" name="txtsinopsis" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="text" value="" name="txtstock" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Categoria</label>
                            <input type="text" value="" name="txtcategoria" class="form-control">
                        </div>

                        <input type="submit" name="" value="Agregar" class="btn btn-info">
                        <input type="submit" name="" value="Actualizar" class="btn btn-success">
                    </form>
                </div>
            </div>


            <?php if ((isset($_GET['enviar'])) && !empty($resultados)): ?>
                <div class="mt-4">
                    <h4>Libros:</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID LIBRO</th>
                                <th>TITULO</th>
                                <th>AUTOR</th>
                                <th>SINOPSIS</th>
                                <th>STOCK</th>
                                <th>CATEGORIA</th>
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
                                    <td>
                                        <a class="btn btn-warning" href="">Editar</a>
                                        <a class="btn btn-danger" href="">Borrar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif (isset($_GET['enviar']) && empty($resultados)): ?>
                <div class="mt-4">
                    <p>No se encontraron resultados.</p>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>
