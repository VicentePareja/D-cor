<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("../config/conexion.php");
include('../templates/header.html');

$idTienda = $_GET["id_tienda"];
$idProducto = $_GET["id_producto"];

$idTienda = intval($idTienda);
$idProducto = intval($idProducto);
$query = "SELECT so.id_producto, p.nombre, so.cantidad_producto AS stock, so.porcentaje_descuento AS oferta
          FROM stock_oferta AS so
          JOIN producto AS p ON so.id_producto = p.id_producto
          WHERE so.id_tienda = :idTienda AND so.id_producto = :idProducto";

$result = $db->prepare($query);
$result->bindParam(':idTienda', $idTienda, PDO::PARAM_INT);
$result->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
$result->execute();
$productos_stock = $result->fetch(PDO::FETCH_ASSOC);

?>

<body>
    <h1>Actualizar información del producto.</h1>
    <br>
        <label>Stock del producto: <?php echo $productos_stock['stock']; ?></label>
        <br>
        <form action="actualizar_stock.php" method="POST">
            <input type="number" name="nuevo_stock" required min="0" pattern="[0-9]+" title="Ingrese un número entero positivo o cero">
            <input type="hidden" name="id_producto" value="<?php echo $idProducto; ?>">
            <input type="hidden" name="id_tienda" value="<?php echo $idTienda; ?>">
            <button class="btn btn-primary" type="submit">Actualizar</button>
        </form>
        <br>
        <br>
        <label>Porcentaje de descuento: <?php echo $productos_stock['oferta']; ?></label>
        <form action="actualizar_descuento.php" method="POST">
        <input type="number" name="nuevo_descuento" required min="0" max="99" pattern="[0-9]+" title="Ingrese un número entero entre 0 y 99">
        <input type="hidden" name="id_producto" value="<?php echo $idProducto; ?>">
        <input type="hidden" name="id_tienda" value="<?php echo $idTienda; ?>">
        <button class="btn btn-primary" type="submit">Actualizar</button>
        </form>

</body>

</html>
