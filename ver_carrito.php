<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('./templates/header.html');

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo '<h2>No hay productos en el carrito.</h2>';
    echo '<a href="new_purchase.php" class="btn btn-primary">Volver</a>';
    exit();
} else {
    if (isset($_POST['eliminar_producto'])) {
        $id_producto = $_POST['id_producto'];
        $index = array_search($id_producto, array_column($_SESSION['carrito'], 'id_producto'));
    
        if ($index !== false) {
            unset($_SESSION['carrito'][$index]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar los elementos del array
    
            $_SESSION['mensaje'] = "Producto eliminado del carrito.";
    
            header("Location: ver_carrito.php");
            exit();
        }
    }
    if (isset($_POST['vaciar_carrito'])) {
        unset($_SESSION['carrito']);
        header("Location: client_index.php");
        exit();
    }

    $productos = $_SESSION['carrito'];
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>

<body>
    <div class='main'>
        <h1 class='title'>Ver Carrito</h1>

        <div class='container'>
            <?php
            // Mostrar el mensaje si existe
            if (isset($_SESSION['mensaje'])) {
                echo "<p class='mensaje'>" . $_SESSION['mensaje'] . "</p>";
                unset($_SESSION['mensaje']); // Limpiar el mensaje de la sesión
            }
            ?>

            <h3>Productos en el carrito:</h3>
            <table class='table'>
                <thead>
                    <tr>
                        <th>ID tienda</th>
                        <th>ID producto</th>
                        <th>Nombre producto</th>
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
                            <td>
                                <form class="eliminar-producto-form" method="POST" action="">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                    <button type="submit" name="eliminar_producto">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <form method="POST" action="">
                <button type="submit" name="vaciar_carrito">Vaciar carrito</button>
            </form>
        </div>

        <a href="new_purchase.php" class="btn btn-primary">Volver</a>
        <a href="concretar_compra.php" class="btn btn-primary">Concretar compra</a>
    </div>
</body>


