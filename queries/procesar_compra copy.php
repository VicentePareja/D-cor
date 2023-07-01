<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require("config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha seleccionado una fecha de despacho
    if (!empty($_POST['fecha_despacho'])) {
        $fecha_despacho = $_POST['fecha_despacho'];

        // Obtener productos del carrito
        $productos = $_SESSION['carrito'];

        // Obtener información del cliente (aquí debes obtener el id del cliente, puedes modificar esta línea)
        $id_cliente = 1;

        try {
            // Iniciar una transacción
            $pdo->beginTransaction();
            $pdo2->beginTransaction();

            // Iterar sobre los productos del carrito
            foreach ($productos as $producto) {
                $id_producto = $producto['id_producto'];
                $id_tienda = $producto['id_tienda'];

                // Llamar al procedimiento almacenado "nueva_compra" en $db2
                $stmt = $db2->prepare("SELECT nueva_compra(:p_id_producto, :p_id_tienda, :p_id_cliente)");
                $stmt->bindParam(':p_id_producto', $id_producto, PDO::PARAM_INT);
                $stmt->bindParam(':p_id_tienda', $id_tienda, PDO::PARAM_INT);
                $stmt->bindParam(':p_id_cliente', $id_cliente, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();

                // Llamar al procedimiento almacenado "actualizar_stock_compra" en $db
                $stmt = $pdo->prepare("SELECT actualizar_stock_compra(:p_id_tienda, :p_id_producto)");
                $stmt->bindParam(':p_id_tienda', $id_tienda, PDO::PARAM_INT);
                $stmt->bindParam(':p_id_producto', $id_producto, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            }

            // Confirmar la transacción
            $pdo->commit();
            $pdo2->commit();

            // Vaciar el carrito y mostrar un mensaje de éxito
            unset($_SESSION['carrito']);
            echo '<h2>Compra realizada exitosamente.</h2>';
            echo '<p>¡Gracias por tu compra!</p>';
        } catch (PDOException $e) {
            // Si ocurre un error, deshacer la transacción
            $pdo->rollBack();
            $pdo2->rollBack();
            echo "Error al procesar la compra: " . $e->getMessage();
        }
    } else {
        echo '<h2>Debe seleccionar una fecha de despacho.</h2>';
    }
}
?>
