<?php
require("../../../ConfiguracionBD/ConexionBDPDO.php");
require_once '../../../../phplot-6.2.0/phplot.php';
$datetime = date('Y-m-d'); // Fecha y hora actuales en formato YYYY-MM-DD HH:MM:SS
$consulta = '';
$tipo = '';
$ejeX = '';
$ejeY = '';
if (isset($_POST['tabla'])) {
    $tabla = $_POST['tabla'];
    if (isset($_POST['graficolinea']))
        $tipo = 'lines';
    elseif (isset($_POST['graficoarea']))
        $tipo = 'area';
    elseif (isset($_POST['graficobarra']))
        $tipo = 'bars';
    elseif (isset($_POST['graficopie']))
        $tipo = 'pie';
    try {
        switch ($tabla) {
            case 'cliente':
                $consulta = "SELECT DATE_FORMAT(fecha_inicio, '%m') AS mes, COUNT(*) AS cantidad_clientes FROM cliente GROUP BY mes ORDER BY mes";
                $ejeX = 'Usuarios';
                $ejeY = 'Meses';
                break;
            case 'empleado':
                $consulta = "SELECT DATE_FORMAT(fecha_inicio, '%m') AS mes, COUNT(*) AS cantidad_empleado FROM empleado GROUP BY mes ORDER BY mes";
                $ejeX = 'Empleados';
                $ejeY = 'Meses';
                break;
            case 'libro':
                $consulta = "SELECT categoria, SUM(stock) FROM libro GROUP BY categoria";
                $ejeX = 'categoria';
                $ejeY = 'stock';
                break;
            case 'prestamo':
                $consulta = "SELECT DATE_FORMAT(fecha_inicio, '%m') AS mes, COUNT(*) AS cantidad_prestamo FROM prestamo GROUP BY mes ORDER BY mes";
                $ejeX = 'Prestamos';
                $ejeY = 'Meses';
                break;
            case 'multa':
                $consulta = "SELECT valor, COUNT(*) AS cantidad_multas FROM multa GROUP BY valor ORDER BY cantidad_multas DESC;";
                $ejeX = 'Valor multa';
                $ejeY = 'Cantidad Deudores';
                break;
            case 'historial_multas_borradas':
                $consulta = "SELECT id_multa, valor FROM historial_multas_borradas";
                $ejeX = 'id_multa';
                $ejeY = 'valor';
                break;
            default:
                break;
        }
        $consultar_registros = $conexion->prepare($consulta);
        $consultar_registros->execute();
        $resultado = $consultar_registros->fetchAll();
        foreach ($resultado as $fila) {
            $datos[] = array($fila[0], $fila[1]);
            //echo 'Dato 1: '.$fila[0].' - Dato 2: '.$fila[1].'<br>';
        }
        $conexion = null;
    } catch (PDOException $e) {
        echo ("Error....:" . $e->getMessage());
    }
    $plot = new PHPlot(1400, 700);
    $plot->SetImageBorderType('plain');
    $plot->SetPlotType($tipo);
    $plot->SetDataValues($datos);
    $plot->SetTitle('Graficos estadisticos de '.$tabla.' - Fecha de Grafico: '.$datetime);
    if ($tipo == 'pie') {
        $plot->SetDataType('text-data-single');
        foreach ($datos as $fila)
            $plot->SetLegend(implode(':', $fila));
    } else {
        $plot->SetDataType('text-data');
        $plot->SetDataColors('purple');
        $plot->SetPrecisionY(0);
        $plot->SetXTitle($ejeX);
        $plot->SetYTitle($ejeY);
    }
    $conexion = null;
    $plot->DrawGraph();
}
?>

