<?php
//session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_cuenta'] != 'cliente') {
    header("Location: ../NoUser/MensajeCerrarSesion.php");
    exit();
}

require("../ConfiguracionBD/ConexionBDPDO.php");
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

            <?php if ( ( (isset($_GET['enviar'])) || (isset($_GET['titulo']))
                    || (isset($_GET['autor'])) || (isset($_GET['sinopsis']))) && !empty($resultados)): ?>
                <div class="mt-4">
                    <h4>Resultados de la búsqueda:</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>TITULO</th>
                                <th>AUTOR</th>
                                <th>SINOPSIS</th>
                                <th>STOCK</th>
                                <th>CATEGORIA</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $resultado): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($resultado['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['autor']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['sinopsis']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['stock']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['categoria']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['estado']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ( ( isset($_GET['enviar']) || isset($_GET['titulo'])
                    || isset($_GET['autor']) || isset($_GET['sinopsis'])) && empty($resultados)): ?>
                <div class="mt-4">
                    <h3>No se encontraron Resultados</h3>
                </div>
            <?php endif; ?>
            <br><br><br><br><br><br><br><br><br><br><br>
        </div>
    </body>
</html>
