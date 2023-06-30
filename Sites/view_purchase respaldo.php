<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require("config/conexion.php");
include('./templates/header.html');

$id_compra = $_GET['id'];

$query = $db2->prepare("SELECT Productos.nombre, Productos.precio FROM Productos JOIN CompraProducto ON Productos.id = CompraProducto.id_producto JOIN Compras ON CompraProducto.id_compra = Compras.id WHERE Compras.id = ?");
$query->bindParam(1, $id_compra);
$query->execute();
$detalles_compra = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <div class='main'>
        <h1 class='title'> Detalles de la Compra </h1>

        <?php if (isset($_SESSION['username'])) { ?>
        <div>
        <h1>¡Hola <?php echo $_SESSION['username']; ?>!</h1>

        <div class='container'>
            <h3>Detalles de la compra:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($detalles_compra as $detalle) { ?>
                    <tr>
                        <td><?php echo $detalle['nombre']; ?></td>
                        <td><?php echo $detalle['precio']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
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
