<?php
// Verifica si la sesión ya está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    require("../ConfiguracionBD/ConexionBDPDO.php");

    $resultados = [];
    if (isset($_GET['enviar']) || isset($_GET['pendientes'])) {
        // Verificar si el id_cliente está configurado en la sesión
        if (isset($_SESSION['id_cliente'])) {
            $idCliente = $_SESSION['id_cliente'];
            
            if (isset($_GET['enviar'])) {
                // Consulta para el historial de préstamos
                $consultaBusqueda = "SELECT prestamo.fecha_inicio, prestamo.fecha_entrega, libro.titulo AS nombre_libro, prestamo.retraso_dias
                                     FROM prestamo
                                     JOIN libro ON prestamo.id_libro = libro.id_libro
                                     WHERE prestamo.fecha_entrega IS NOT NULL
                                     AND prestamo.id_cliente = :id_cliente";
            } elseif (isset($_GET['pendientes'])) {
                // Consulta para los préstamos pendientes
                $consultaBusqueda = "SELECT prestamo.fecha_inicio, prestamo.fecha_entrega, libro.titulo AS nombre_libro, prestamo.retraso_dias
                                     FROM prestamo
                                     JOIN libro ON prestamo.id_libro = libro.id_libro
                                     WHERE prestamo.fecha_entrega IS NULL
                                     AND prestamo.id_cliente = :id_cliente";
            }

            $ejecutar = $conexion->prepare($consultaBusqueda);
            $ejecutar->bindParam(':id_cliente', $idCliente, PDO::PARAM_INT);
            $ejecutar->execute();
            $resultados = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Error: No se ha encontrado el ID del cliente en la sesión.";
        }
    }
} catch (PDOException $e) {
    echo "Error al listar la tabla<br/>" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de Préstamos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Búsqueda de Préstamos</h2><br>
        <form action="" method="get">
            <div class="form-group">
                <button type="submit" name="enviar" class="btn btn-primary">Historial de préstamos</button>
                <button type="submit" name="pendientes" class="btn btn-warning">Préstamos pendientes</button>
            </div>
        </form>

        <?php if ((isset($_GET['enviar']) || isset($_GET['pendientes'])) && !empty($resultados)): ?>
            <div class="mt-4">
                <h4>Resultados de la búsqueda:</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>FECHA INICIO</th>
                            <th>FECHA ENTREGA</th>
                            <th>TÍTULO LIBRO</th>
                            <th>RETRASO DÍAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $resultado): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($resultado['fecha_inicio']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['fecha_entrega']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['nombre_libro']); ?></td>
                                <td><?php echo htmlspecialchars($resultado['retraso_dias']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ((isset($_GET['enviar']) || isset($_GET['pendientes'])) && empty($resultados)): ?>
            <div class="mt-4">
                <p>No se encontraron resultados.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
