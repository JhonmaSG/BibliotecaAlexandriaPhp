<?php
require("../../ConfiguracionBD/ConexionBDPDO.php");
$resultados = array();
$tipo_grafico = '';
$tipo_de_reporte = '';
$tabla = '';
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Guardar los valores previos de los SELECTs
        if (isset($_POST['tipo_de_reporte']) || isset($_POST['tipo_grafico']) || isset($_POST['tabla'])) {
            $tipo_de_reporte = $_POST['tipo_de_reporte'];
            $tipo_grafico = $_POST['tipo_grafico'];
        }

        if (isset($_POST['enviar'])) {
            $tabla = $_POST['tabla'];
            $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

            $consultaBusqueda = "SELECT * FROM $tabla";
            $consultaAdmin = "SELECT * FROM empleado WHERE id_empleado > 1";

            if ($tabla == 'empleado') {
                $ejecutar = $conexion->prepare($consultaAdmin);
                $ejecutar->execute();
                $resultados = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Agregar condición de búsqueda si se proporciona un término de búsqueda
                if (!empty($busqueda) && !empty($tabla)) {
                    $column = '';
                    switch ($tabla) {
                        case 'cliente':
                            $column = 'nombre_usuario';
                            break;
                        case 'libro':
                            $column = 'titulo';
                            break;
                        default:
                            break;
                    }
                    if ($column) {
                        $consultaBusqueda .= " WHERE $column LIKE :busqueda";
                    }
                    if (!empty($busqueda) && $column) {
                        $ejecutar->bindValue(':busqueda', '%' . $busqueda . '%');
                    }
                    $ejecutar->execute();
                    $resultados = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
                } else if (!empty($tabla)) {
                    $ejecutar = $conexion->prepare($consultaBusqueda);
                    $ejecutar->execute();
                    $resultados = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        } elseif (isset($_POST['reporte']) && $_POST['tipo_reporte'] == 'pdf' && !empty($_POST['tabla'])) {
            echo '<script>window.location="./PDFTablas/CrearPDFTablas.php"</script>';
            //header("Location: ./PDFTablas/CrearPDFTablas.php?tabla={$_POST['tabla']}&busqueda={$_POST['busqueda']}");
            exit;
        }/* else{
          echo '<script>window.location="./Reportes.php"</script>';
          } */
    }
} catch (PDOException $e) {
    echo "Error al listar la tabla $tabla<br/>" . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema de Reportes</title>
        <style>
            #tipo_grafico_container {
                display: none;
            }
        </style>
    </head>
    <body>
        <div class="" style="margin: 0 80px; width: 90%;">
            <div class="mt-4 text-center">
                <h2>Sistema de Reportes</h2><br>
                <p>Seleccione el tipo de Reporte a generar (Tipo de Reporte)<br>
                    Y la tabla a elegir (Datos a Reportar)</p>
            </div>
            <!-- Formulario de selección de tabla -->
            <form action="" method="POST" style="margin: 0 300px;">
                <div class="form-group">
                    <label>Tipo de Reporte:</label>
                    <select class="form-control" name="tipo_de_reporte" id="tipo_de_reporte">
                        <option value="">Selecciona un tipo de Reporte</option>
                        <option value="pdf" <?php if ($tipo_de_reporte === 'pdf') echo 'selected'; ?>>PDF</option>
                        <option value="grafico" <?php if ($tipo_de_reporte === 'grafico') echo 'selected'; ?>>Gráfico</option>
                    </select>


                    <div id="tipo_grafico_container" class="form-group"><br>
                        <label for="tipo_grafico">Tipo de Gráfico:</label>
                        <select class="form-control" name="tipo_grafico">
                            <option value="">Selecciona un tipo de gráfico</option>
                            <option value="lineas" <?php if ($tipo_grafico == 'lineas') echo 'selected'; ?>>Gráfico de Líneas</option>
                            <option value="area" <?php if ($tipo_grafico == 'area') echo 'selected'; ?>>Gráfico de Área</option>
                            <option value="barras" <?php if ($tipo_grafico == 'barras') echo 'selected'; ?>>Gráfico de Barras</option>
                            <option value="torta" <?php if ($tipo_grafico == 'torta') echo 'selected'; ?>>Gráfico de Torta</option>
                        </select>
                    </div><br>

                    <label>Datos a Reportar:</label>
                    <select class="form-control" name="tabla">
                        <option value="">Seleccione los datos a mostrar</option>
                        <option value="cliente" <?php if ($tabla == 'cliente') echo 'selected'; ?>>Cliente</option>
                        <option value="empleado" <?php if ($tabla == 'empleado') echo 'selected'; ?>>Empleado</option>
                        <option value="libro" <?php if ($tabla == 'libro') echo 'selected'; ?>>Libro</option>
                        <option value="prestamo" <?php if ($tabla == 'prestamo') echo 'selected'; ?>>Préstamo</option>
                        <option value="multa" <?php if ($tabla == 'multa') echo 'selected'; ?>>Multa</option>
                        <option value="historial_multas_borradas" <?php if ($tabla == 'historial_multas_borradas') echo 'selected'; ?>>Historial de Multas</option>
                    </select><br>

                </div>
                <div class="form-group">
                    <label for="busqueda">Buscar:</label><br>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese la búsqueda" style="width: 100%;">
                </div><br>
                <button type="submit" name="enviar" class="btn btn-warning">Generar Tabla</button>
            </form><br>
            <div style="margin: 0 300px; width: 30%;"><!-- PDF -->
                <form action="./PDFTablas/CrearPDFTablas.php" method="POST">
                    <input type="hidden" name="tabla" value="<?php echo htmlspecialchars($tabla); ?>">
                    <?php if ($tipo_de_reporte == 'pdf' && !empty($tabla)): ?>
                        <button type = "submit" name = "reporte" class = "btn btn-primary">Generar Reporte</button>
                    <?php endif; ?>
                </form>
                <form action="./GraficosTablas/GenerarGraficas.php" method="POST"><!-- GRAFICOS  -->
                    <input type="hidden" name="tabla" value="<?php echo htmlspecialchars($tabla); ?>">
                    <?php if ($tipo_de_reporte == 'grafico' && $tipo_grafico == 'lineas' && !empty($tabla)): ?>
                        <button type = "submit" name = "graficolinea" class = "btn btn-primary">Generar Gráfico Lineas</button>
                    <?php endif; ?>
                    <?php if ($tipo_de_reporte == 'grafico' && $tipo_grafico == 'area' && !empty($tabla)): ?>
                        <button type = "submit" name = "graficoarea" class = "btn btn-primary">Generar Gráfico Area</button>
                    <?php endif; ?>
                    <?php if ($tipo_de_reporte == 'grafico' && $tipo_grafico == 'barras' && !empty($tabla)): ?>
                        <button type = "submit" name = "graficobarra" class = "btn btn-primary">Generar Gráfico Barras</button>
                    <?php endif; ?>
                    <?php if ($tipo_de_reporte == 'grafico' && $tipo_grafico == 'torta' && !empty($tabla)): ?>
                        <button type = "submit" name = "graficopie" class = "btn btn-primary">Generar Gráfico Torta</button>
                    <?php endif; ?>
                </form>
            </div>
            <br>

            <script>
                document.getElementById('tipo_de_reporte').addEventListener('change', function () {
                    var tipoGraficoContainer = document.getElementById('tipo_grafico_container');
                    if (this.value === 'grafico') {
                        tipoGraficoContainer.style.display = 'block';
                    } else {
                        tipoGraficoContainer.style.display = 'none';
                    }
                });
            </script>

            <?php if (!empty($resultados)): ?>
                <div class="mt-4">
                    <h4>Resultados de la búsqueda:</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <?php foreach (array_keys($resultados[0]) as $key): ?>
                                    <th><?php echo htmlspecialchars(strtoupper($key)); ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $resultado): ?>
                                <tr>
                                    <?php foreach ($resultado as $value): ?>
                                        <td><?php echo htmlspecialchars($value); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif (isset($_POST['enviar']) && empty($resultados)): ?>
                <div class="mt-4 text-center">
                    <h4>No se encontraron Resultados</h4><br><br><br>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>
