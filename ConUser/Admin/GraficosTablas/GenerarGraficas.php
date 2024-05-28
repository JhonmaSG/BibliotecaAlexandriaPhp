<?php
require("../../../ConfiguracionBD/ConexionBDPDO.php");
require_once '../../../../phplot-6.2.0/phplot.php';
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
                $consulta = "SELECT usuario, estado FROM cliente";
                $ejeX = 'usuario';
                $ejeY = 'estado';
                break;
            case 'empleado':
                $consulta = "SELECT id_empleado, estado FROM empleado";
                $ejeX = 'id_empleado';
                $ejeY = 'estado';
                break;
            case 'libro':
                $consulta = "SELECT categoria, stock FROM libro";
                $ejeX = 'categoria';
                $ejeY = 'stock';
                break;
            case 'prestamo':
                $consulta = "SELECT id_cliente, retraso_dias FROM prestamo";
                $ejeX = 'id_cliente';
                $ejeY = 'retraso_dias';
                break;
            case 'multa':
                $consulta = "SELECT id_multa, valor FROM multa";
                $ejeX = 'id_multa';
                $ejeY = 'valor';
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

    $plot = new PHPlot(1280, 720);
    $plot->SetImageBorderType('plain');
    $plot->SetPlotType($tipo);
    $plot->SetDataValues($datos);
    $plot->SetTitle('Graficos estadisticos con Php - CLIENTES');
    if ($tipo == 'pie') {
        $plot->SetDataType('text-data-single');
        foreach ($datos as $fila)
            $plot->SetLegend(implode(':', $fila));
    } else {
        $plot->SetDataType('text-data');
        $plot->SetDataColors('gray');
        $plot->SetPrecisionY(0);
        $plot->SetXTitle($ejeX);
        $plot->SetYTitle($ejeY);
    }
    $conexion = null;
    $plot->DrawGraph();
}
?>

