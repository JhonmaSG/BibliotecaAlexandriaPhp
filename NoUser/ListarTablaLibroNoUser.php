<?php

try {
    require("../ConfiguracionBD/ConexionBDPDO.php");

    $mostra_tabla = "SELECT titulo, autor, sinopsis, stock, categoria FROM libro";
    $resultado = $conexion->prepare($mostra_tabla);
    $resultado->execute();
    $tablas = $resultado->fetchAll(PDO::FETCH_ASSOC);

    echo '<br><div style="text-align: center; margin: 50px; width:100%;"><h2>LIBROS DE NUESTRA BIBLIOTECA</h2></div>';
    echo'<table class="table table-hover" style="margin:0 100px;">';
    echo'<thead><tr>';
    echo'<th>TITULO</th><th>AUTOR</th><th>SINOPSIS</th><th>STOCK</th><th>CATEGORIA</th>';
    echo'</tr></thead>';
    echo '<tbody>';
    
    if ($tablas) {
        foreach ($tablas as $tabla) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($tabla['titulo']) . '</td>';
        echo '<td>' . htmlspecialchars($tabla['autor']) . '</td>';
        echo '<td>' . htmlspecialchars($tabla['sinopsis']) . '</td>';
        echo '<td>' . htmlspecialchars($tabla['stock']) . '</td>';
        echo '<td>' . htmlspecialchars($tabla['categoria']) . '</td>';
        echo '</tr>';
    }
    }else {
        echo '<tr>';
        echo '<td colspan="5">No hay datos disponibles.</td>';
        echo '</tr>';
    }
        echo '</tbody></table>';

} catch (PDOException $e) {
    echo "Error al listar alguna de las tablas<br/>" . $e->getMessage();
}
?>