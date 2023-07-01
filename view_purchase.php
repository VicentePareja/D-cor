<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require("config/conexion.php");
include('./templates/header.html');

$id_compra = $_GET['id'];

$query_productos = $db2->prepare("SELECT Productos.id AS \"ID Producto\", Productos.nombre AS \"Nombre Producto\", Productos.precio AS \"Precio Producto\", CompraProducto.cantidad AS \"Unidades\", Productos.numero_cajas AS \"Número de Cajas\" FROM CompraProducto JOIN Productos ON CompraProducto.id_producto = Productos.id WHERE CompraProducto.id_compra = ?");
$query_precio_total = $db2->prepare("SELECT SUM(Productos.precio * CompraProducto.cantidad) AS \"Precio Total\" FROM CompraProducto JOIN Productos ON CompraProducto.id_producto = Productos.id WHERE CompraProducto.id_compra = ?");
$query_fecha_despacho = $db2->prepare("SELECT Despachos.fecha_entrega AS \"Fecha de Despacho\" FROM Despachos JOIN CompraDespacho ON Despachos.id = CompraDespacho.id_despacho WHERE CompraDespacho.id_compra = ?");

$query_productos->bindParam(1, $id_compra);
$query_precio_total->bindParam(1, $id_compra);
$query_fecha_despacho->bindParam(1, $id_compra);

$query_productos->execute();
$query_precio_total->execute();
$query_fecha_despacho->execute();

$detalles_productos = $query_productos->fetchAll(PDO::FETCH_ASSOC);
$precio_total = $query_precio_total->fetch(PDO::FETCH_ASSOC)['Precio Total'];
$fecha_despacho = $query_fecha_despacho->fetch(PDO::FETCH_ASSOC)['Fecha de Despacho'];
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>
<body>
    <div class='container'>
        <h1 class='title'> Detalle de la compra: <?php echo $id_compra; ?></h1>

        <?php if (isset($_SESSION['username'])) { ?>
        <div>

        <h3 class='subheading'>Detalle de los productos comprados:</h3>
            <table class='table'>
                <thead>
                    <tr>
                        <th>Id producto</th>
                        <th>Nombre producto</th>
                        <th>Precio</th>
                        <th>Número cajas</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($detalles_productos as $producto) { ?>
                    <tr>
                        <td><?php echo $producto['ID Producto']; ?></td> 
                        <td><?php echo $producto['Nombre Producto']; ?></td>
                        <td><?php echo $producto['Precio Producto']; ?></td>
                        <td><?php echo $producto['Número de Cajas']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <h3 class='details'>Precio total: <?php echo $precio_total; ?></h3>
            <?php if ($fecha_despacho) { ?>
            <h3 class='details'>Fecha despacho: <?php echo $fecha_despacho; ?></h3>
            <?php } else { ?>
            <h3 class='details'>El cliente retiró los productos personalmente.</h3>
            <?php } ?>
        </div>
        <button class='btn' type='button' onClick="location.href='./client_index.php'">Volver</button>
        <br><br>
        <form method="POST" action="./queries/logout.php">
            <button class='btn' name="logout">Logout</button>
        </form>
        <?php } ?>
    </div>
    <footer>
        <p>
        </p>
    </footer>
</body>

</html>