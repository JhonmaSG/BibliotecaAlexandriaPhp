<?php

require('../../../../fpdf186/fpdf.php');
require('../../../ConfiguracionBD/ConexionBDPDO.php');
$datetime = date('Y-m-d'); // Fecha y hora actuales en formato YYYY-MM-DD HH:MM:SS

class PDF extends FPDF {

    function Header() {
        $this->Image('../../../img/logoBiblioteca.png', 15, 12, 20, 20, 'PNG');
        $this->SetFont('Arial', 'B', 20);
        $this->SetTextColor('200', '0', '0');
        $this->Multicell(0, 12, "BIBLIOTECA ALEJANDRIA" . " \n Reporte en PDF", 1, 'C');
        $this->Image('../../../img/logoBiblioteca.png', 382, 12, 20, 20, 'PNG');
        $this->Ln(3);
        $this->Line(0, 35, 500, 35);
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 8);
        $this->AliasNbPages();
        $this->Cell(0, 10, utf8_decode('Página:') . $this->PageNo(), 0, 0, 'C');
    }

}

$pdf = new PDF('L', 'mm', 'A3');
$pdf->SetAutoPageBreak(true);
$pdf->AddPage();

if (isset($_POST['tabla'])) {
    $tabla = $_POST['tabla'];
    $tamCeldas = 0;

    //fecha de creacion:
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Multicell(0, 8, utf8_decode("Fecha de "
                    . "Creación de Reporte: " . $datetime."\n Reporte de tabla ".$tabla), 1, 'C');

    // Obtener los datos de la tabla seleccionada
    switch ($tabla) {
        case 'cliente':
            $consulta = "SELECT id_cliente, usuario, correo, cedula, nombre_usuario, fecha_inicio, "
                    . "estado FROM cliente";
            $tamCeldas = 57;
            break;
        case 'empleado':
            $consulta = "SELECT id_empleado, usuario, correo, cedula, nombre_emp, apellido_emp, "
                    . "fecha_inicio, rol, estado FROM empleado WHERE id_empleado > 1";
            $tamCeldas = 44;
            break;
        case 'libro':
            $consulta = "SELECT id_libro, titulo, autor, stock, categoria, estado FROM libro";
            $tamCeldas = 66;
            break;
        case 'prestamo':
            $consulta = "SELECT id_prestamo, fecha_inicio, fecha_limite_entrega, fecha_entrega, id_libro, "
                    . "id_cliente, id_empleado_presta, id_empleado_recibe, retraso_dias FROM prestamo";
            $tamCeldas = 44;
            break;
        case 'multa':
            $consulta = "SELECT id_multa, id_cliente, id_prestamo, id_libro, id_empleado_presta, valor, fecha_pago, "
                    . "demora, estado FROM multa";
            $tamCeldas = 44;
            break;
        case 'historial_multas_borradas':
            $consulta = "SELECT id_multa, id_cliente, id_prestamo, id_libro, id_empleado_presta, valor, fecha_pago, "
                    . "demora, estado FROM historial_multas_borradas";
            $tamCeldas = 38;
            break;
        default:
            $tamCeldas = 30;
            break;
    }
    $consultar_registros = $conexion->prepare($consulta);
    $consultar_registros->execute();
    $pdf->Ln();
    // Encabezados de la tabla
    $pdf->SetFillColor(230, 230, 230);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor('0', '0', '200');
    $num_columnas = $consultar_registros->columnCount();
    for ($i = 0; $i < $num_columnas; $i++) {
        $meta = $consultar_registros->getColumnMeta($i);
        $pdf->Cell($tamCeldas, 7, utf8_decode($meta['name']), 1, 0, 'C', 1);
    }
    $pdf->SetTextColor('0', '0', '0');
    $pdf->Ln();

    // Contenido de la tabla
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Arial', '', 10);
    $cont = 0;
    while ($fila = $consultar_registros->fetch(PDO::FETCH_ASSOC)) {
        foreach ($fila as $columna) {
            $pdf->Cell($tamCeldas, 7, utf8_decode($columna), 1, 0, 'C', 1);
            if ($cont > 25) {
                //$pdf->AddPage();
            }
        }
        $pdf->Ln();
    }

    // Cerrar la conexión a la base de datos
    $conexion = null;

    // Guardar el PDF como un archivo y abrirlo
    ob_end_clean(); // Limpia el buffer de salida para evitar el error de FPDF
    $pdf->Output("D", "tabla_$tabla.pdf");
    echo "<script language='javascript'>window.open('tabla_'.$tabla.'.pdf','_self');</script>";
} else {
    echo "No se ha especificado una tabla.";
}
?>
