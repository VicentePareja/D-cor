<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require("config/conexion.php");
include('./templates/header.html');

$nombre_producto = isset($_POST['nombre_producto']) ? $_POST['nombre_producto'] : '';

$query_productos = $db->prepare("WITH ofertas AS (
    SELECT DISTINCT
        producto.id_producto, 
        producto.nombre, 
        producto.precio AS precio_original,
        stock_oferta.porcentaje_descuento AS oferta_aplicada,
        producto.precio - producto.precio * stock_oferta.porcentaje_descuento / 100 AS precio_con_oferta,
        stock_oferta.id_tienda
    FROM 
        producto 
    INNER JOIN 
        stock_oferta ON producto.id_producto = stock_oferta.id_producto
)
SELECT DISTINCT
    nombre, 
    id_producto,
    precio_original,
    oferta_aplicada,
    precio_con_oferta,
    id_tienda
FROM 
    ofertas
WHERE 
    LOWER(nombre) LIKE LOWER(?)
ORDER BY precio_con_oferta ASC
LIMIT 10");

$query_productos->execute(array('%' . $nombre_producto . '%'));
$productos = $query_productos->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['agregar_al_carrito']) && isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    $id_tienda = $_POST['id_tienda'];
    $nombre = $_POST['nombre'];
    $precio_original = $_POST['precio_original'];
    $porcentaje_descuento = $_POST['oferta_aplicada'];
    $precio_con_oferta = $_POST['precio_con_oferta'];
    $_SESSION['carrito'][] = array('id_producto' => $id_producto, 'id_tienda' => $id_tienda, 'nombre' => $nombre, 'precio_original' => $precio_original, 'porcentaje_descuento' => $porcentaje_descuento, 'precio_con_oferta' => $precio_con_oferta);
    $mensaje = "El producto $id_producto de la tienda $id_tienda ha sido agregado al carrito.";
}
?>
<head>
<link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>
<body>
    <div class="title">
        <h1> Realizar nueva compra </h1>
    </div>
    <div class='main'>
        

        <?php if (isset($_SESSION['username'])) { ?>
        <div>
        <div class='container'>
            <?php if (isset($mensaje)) { ?>
            <p><?php echo $mensaje; ?></p>
            <?php } ?>

            <form method="POST" action="">
                <h3 style="text-align:left;">Buscar producto:</h3>
                <div class="input-container">
                    <input type="text" name="nombre_producto" value="<?php echo htmlspecialchars($nombre_producto); ?>">
                </div>
                <button class="button" type="submit">Buscar</button>
            </form>

            <?php if (!empty($nombre_producto) && $productos) { ?>
            <h3 style="text-align:left;">Resultados:</h3>
            <table class='table' style="margin-left:auto;margin-right:auto;">
                <thead>
                    <tr>
                        <th>ID tienda</th>
                        <th>ID producto</th>
                        <th>Nombre producto</th>
                        <th>Precio original</th>
                        <th>Porcentaje descuento (%)</th>
                        <th>Precio con descuento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($productos as $producto) { ?>
                    <tr>
                        <td><?php echo $producto['id_tienda']; ?></td>
                        <td><?php echo $producto['id_producto']; ?></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['precio_original']; ?></td>
                        <td><?php echo $producto['oferta_aplicada']; ?></td>
                        <td><?php echo $producto['precio_con_oferta']; ?></td>
                        <td>
                            <form class="agregar-carrito-form" method="POST" action="">
                                <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                <input type="hidden" name="id_tienda" value="<?php echo $producto['id_tienda']; ?>"> 
                                <input type="hidden" name="nombre" value="<?php echo $producto['nombre']; ?>">
                                <input type="hidden" name="precio_original" value="<?php echo $producto['precio_original']; ?>"> 
                                <input type="hidden" name="oferta_aplicada" value="<?php echo $producto['oferta_aplicada']; ?>">
                                <input type="hidden" name="precio_con_oferta" value="<?php echo $producto['precio_con_oferta']; ?>"> 
                                <button type="submit" name="agregar_al_carrito">Agregar al carrito</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
        <div class="button-container">
            <a href="new_purchase.php" class="btn btn-primary">Volver</a>
            <a href="ver_carrito.php"><button>Ver carrito</button></a>
            <form method="POST" action="./queries/logout.php">
                <button name="logout">Logout</button>
            </form>
        </div>
        <?php } ?>
    </div>
    <footer>
        <p>
        </p>
    </footer>
</body>

</html>
