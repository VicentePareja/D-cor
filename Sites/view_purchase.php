<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require("config/conexion.php");
include('./templates/header.html');

$id_compra = $_GET['id'];

$query_productos = $db2->prepare("SELECT Productos.nombre AS \"Nombre Producto\", Productos.precio AS \"Precio Producto\", Productos.numero_cajas AS \"Número de Cajas\" FROM CompraProducto JOIN Productos ON CompraProducto.id_producto = Productos.id WHERE CompraProducto.id_compra = ?");
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

<body>
    <div class='main'>
        <h1 class='title'> Detalles de la Compra </h1>

        <?php if (isset($_SESSION['username'])) { ?>
        <div>
        <h1>¡Hola <?php echo $_SESSION['username']; ?>!</h1>

        <div class='container'>
            <h3>Detalles de la compra:</h3>
            <table class='table'>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cajas</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($detalles_productos as $producto) { ?>
                    <tr>
                        <td><?php echo $producto['Nombre Producto']; ?></td>
                        <td><?php echo $producto['Precio Producto']; ?></td>
                        <td><?php echo $producto['Número de Cajas']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <h4>Precio total: <?php echo $precio_total; ?></h4>
            <?php if ($fecha_despacho) { ?>
            <h4>Fecha de despacho: <?php echo $fecha_despacho; ?></h4>
            <?php } else { ?>
            <h4>El cliente retiró los productos personalmente.</h4>
            <?php } ?>
        </div>

        <form method="POST" action="./queries/logout.php">
            <button name="logout">Logout</button>
        </form>
        <?php } ?>
    </div>
    <footer>
        <p>
        </p>
    </footer>
</body>
</html>
