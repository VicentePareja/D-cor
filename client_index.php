<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require("config/conexion.php");
include('./templates/header.html');
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>
<body>
    <div class="title">
        <h1> Décor </h1>
    </div>
    <div class='container'>
        
        <?php if (isset($_SESSION['username'])) { ?>
        <div>
        <h1 class='welcome'>¡Hola <?php echo $_SESSION['username']; ?>!</h1>
        <?php
        $query_direccion = $db2->prepare("SELECT Direcciones.calle AS \"Calle\", Direcciones.numero AS \"Número\" FROM Clientes JOIN DireccionCliente ON Clientes.id = DireccionCliente.id_cliente JOIN Direcciones ON DireccionCliente.id_direccion = Direcciones.id WHERE Clientes.nombre = ?");
        if ($query_direccion) {
            $query_direccion->bindParam(1, $_SESSION['username']);
            $query_direccion->execute();
            $direccion = $query_direccion->fetch(PDO::FETCH_ASSOC);
            echo "<h2 class='details'>Dirección: " . $direccion['Calle'] . " " . $direccion['Número'] . "</h2>";
        } else {
            echo "Error preparando la consulta de la dirección: " . $db2->errorInfo()[2];
        }
        ?>

        <?php
        $query = $db2->prepare("SELECT Compras.id AS \"ID Compra\", Compras.fecha AS \"Fecha Compra\" FROM Compras JOIN CompraCliente ON Compras.id = CompraCliente.id_compra JOIN Clientes ON CompraCliente.id_cliente = Clientes.id WHERE Clientes.nombre = ?");
        if ($query) {
            $query->bindParam(1, $_SESSION['username']);
            $query->execute();
            $compras = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($compras) > 0) {
                echo "<h3 class='subheading'>A continuación se muestra un listado con las compras que has realizado:</h3>";
                echo "<table class='table'>";
                echo "<thead>";
                echo "<tr><th>ID compra</th><th>Fecha compra</th><th>Detalles compra</th><th></th></tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($compras as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['ID Compra'] . "</td>";
                    echo "<td>" . $row['Fecha Compra'] . "</td>";
                    echo "<td>";
                    $query_detalle = $db2->prepare("SELECT Productos.nombre, Productos.precio FROM Productos JOIN CompraProducto ON Productos.id = CompraProducto.id_producto JOIN Compras ON CompraProducto.id_compra = Compras.id WHERE Compras.id = ?");
                    if ($query_detalle) {
                        $query_detalle->bindParam(1, $row['ID Compra']);
                        $query_detalle->execute();
                        $detalles = $query_detalle->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($detalles as $detalle) {
                            echo "Producto: " . $detalle['nombre'] . ", Precio: " . $detalle['precio'] . "<br>";
                        }
                    } else {
                        echo "Error preparando la consulta: " . $db2->errorInfo()[2];
                    }
                    echo "</td>";
                    echo "<td><button class='btn' type='button' onClick=\"location.href='./view_purchase.php?id=".$row['ID Compra']."'\">Ver compra</button></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<button class='btn' type='button' onClick=\"location.href='./new_purchase.php'\">Realizar nueva compra</button>";
            } else {
                echo "<p>No has realizado ninguna compra aún.</p>";
                echo "<button class='btn' type='button' onClick=\"location.href='./new_purchase.php'\">Realizar primera compra</button>";
            }

            $query = null;
        } else {
            echo "Error preparando la consulta: " . $db2->errorInfo()[2];
        }
        ?>
        </div>
        <form method="POST" action="./queries/logout.php">
            <br>
            <button class="btn" name="logout">Logout</button>
        </form>
        <?php } ?>
    </div>
    <footer>
        <p>
        </p>
    </footer>
</body>
<div class="logo">
    <img src="images/logo2.jpg" alt="">
</div>
</html>
