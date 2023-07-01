<?php

# respaldo del 28-06

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("./config/conexion.php");
include('./templates/header.html');

# se obtiene el id de la tienda desde la url
$idTienda = $_GET["id_tienda"];
$idTienda = htmlspecialchars($idTienda);

# se obtiene la región desde la url
$region = $_GET["region"];
$region = htmlspecialchars($region);

# se obtiene la categoria desde la url
$categoria = $_GET["categoria"];
$categoria = htmlspecialchars($categoria);


$query = "SELECT stock_oferta.id_producto, producto.nombre, stock_oferta.cantidad_producto, 
stock_oferta.porcentaje_descuento
FROM stock_oferta
JOIN producto_$categoria ON stock_oferta.id_producto = producto_$categoria.id_producto
JOIN producto ON stock_oferta.id_producto = producto.id_producto
WHERE stock_oferta.id_tienda = '$idTienda';
";


$result = $db->prepare($query);
$result->execute();
$productos = $result->fetchAll();

?>

<head>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>

<body>
    <h1>Estás en la vista para ver los productos de la tienda</h1>
    <h3>Tienda <?php echo $idTienda; ?> en la región <?php echo $region; ?>, categoría <?php echo $categoria; ?></h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Id producto</th>
                <th>Nombre producto</th>
                <th>Cantidad producto</th>
                <th>Porcentaje descuento</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto) : ?>
                <tr>
                    <td><?php echo $producto['id_producto']; ?></td>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td><?php echo $producto['cantidad_producto']; ?></td>
                    <td><?php echo $producto['porcentaje_descuento']; ?></td>
                    <td>
                    <a href='seleccionar_producto.php?id_tienda=<?php echo $idTienda; ?>&id_producto=<?php echo $producto[0]; ?>' class='btn btn-primary'>Seleccionar producto</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <footer>
        <p></p>
    </footer>
</body>


</html>