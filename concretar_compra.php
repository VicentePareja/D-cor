<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require("config/conexion.php");

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo '<h2>No hay productos en el carrito.</h2>';
} else {
    $productos = $_SESSION['carrito'];
    // Calcular el costo de despacho
    $tiendas = array_unique(array_column($productos, 'id_tienda'));
    $costo_despacho = 2000 + (count($tiendas) - 1) * 3000;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Resumen de la Compra</title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>
<body>
    <div class='main'>
        <h3 class='title'>Resumen de la Compra</h3>
        <div class='container'>
            <h3>Productos en el carrito:</h3>
            <table class='table'>
                <thead>
                    <tr>
                        <th>ID tienda</th>
                        <th>ID producto</th>
                        <th>Nombre roducto</th>
                        <th>Precio original</th>
                        <th>Porcentaje descuento (%)</th>
                        <th>Precio con descuento</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) { ?>
                        <tr>
                            <td><?php echo $producto['id_tienda']; ?></td>
                            <td><?php echo $producto['id_producto']; ?></td>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['precio_original']; ?></td>
                            <td><?php echo $producto['porcentaje_descuento']; ?></td>
                            <td><?php echo $producto['precio_con_oferta']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h3>Costo de despacho: <?php echo $costo_despacho; ?></h3>
            <form method="POST" action="procesar_compra.php">
                <h3>Seleccionar fecha de despacho:</h3>
                <input type="date" name="fecha_despacho" required>  
                <br>
                <br>
                <button type="submit" name="procesar_compra">Concretar Compra</button>
            </form>
            
        </div>
        <a href="ver_carrito.php"><button>Volver</button></a>
    </div>
</body>
</html>
<?php } ?>