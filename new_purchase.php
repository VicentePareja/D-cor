<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require("config/conexion.php");
include('./templates/header.html');

// Consulta a la base de datos para obtener la lista de productos disponibles
// Esta es solo una consulta de ejemplo, deberás ajustarla según tu esquema de base de datos
$query_productos = $db2->prepare("SELECT id, nombre, precio FROM Productos");
$query_productos->execute();
$productos = $query_productos->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <div class='main'>
        <h1 class='title'> Realizar nueva compra </h1>

        <?php if (isset($_SESSION['username'])) { ?>
        <div>
        <h1>¡Hola <?php echo $_SESSION['username']; ?>!</h1>

        <div class='container'>
            <form method="POST" action="./queries/perform_purchase.php">
                <h3>Seleccione un producto:</h3>
                <select name="producto_id">
                    <?php foreach($productos as $producto) { ?>
                    <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombre'] . " - " . $producto['precio']; ?></option>
                    <?php } ?>
                </select>

                <button type="submit" name="confirmar_compra">Confirmar compra</button>
            </form>
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
