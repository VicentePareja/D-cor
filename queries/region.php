<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../config/conexion.php");
include('../templates/header.html');

$region = $_POST["region"];
$region = htmlspecialchars($region);

$query = "SELECT Tiendas.id, Tiendas.num_telefono, Tiendas.capacidad
FROM Tiendas
JOIN TiendaDireccion ON Tiendas.id = TiendaDireccion.id_tienda
JOIN DireccionComuna ON TiendaDireccion.id_direccion = DireccionComuna.id_direccion
JOIN ComunaRegion ON DireccionComuna.id_comuna = ComunaRegion.id_comuna
JOIN Regiones ON ComunaRegion.id_region = Regiones.id
WHERE Regiones.nombre = ?";

$result = $db2->prepare($query);
$result->execute([$region]);
$tiendas = $result->fetchAll();
?>

<body>
    <h3> Tiendas en la región <?php echo $region; ?> </h3>
    <?php if (empty($tiendas)): ?>
        <p>No se encontraron tiendas en la región especificada.</p>
    <?php else: ?>
        <?php
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr><th>ID Tienda</th><th>Teléfono</th><th>Capacidad</th><th>Seleccionar categoría</th></tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($tiendas as $tienda) {
                echo "<tr>";
                echo "<td>" . $tienda[0] . "</td>";
                echo "<td>" . $tienda[1] . "</td>";
                echo "<td>" . $tienda[2] . "</td>";
                echo "<td>";

                echo "<form action='productos_tienda.php' method='GET'>";
                echo "<input type='hidden' name='region' value='".$region."'>";
                echo "<input type='hidden' name='id_tienda' value='".$tienda[0]."'>";
                echo "<select name='categoria'>";
                echo "<option value='dormitorio'>Dormitorio</option>";
                echo "<option value='living'>Living</option>";
                echo "<option value='iluminacion'>Iluminación</option>";
                echo "</select>";
                echo "<button type='submit'>Ver productos</button>";
                echo "</form>";
                
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        ?>
    <?php endif; ?>
    <footer>
        <p>
        </p>
    </footer>
</body>
