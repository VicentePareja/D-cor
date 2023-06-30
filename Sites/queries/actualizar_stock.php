<?php
require("../config/conexion.php");

$nuevoStock = $_POST['nuevo_stock'];
$idProducto = $_POST['id_producto'];
$idTienda = $_POST['id_tienda'];

// Validar y sanitizar los datos si es necesario

$query = "UPDATE stock_oferta SET cantidad_producto = :nuevoStock WHERE id_producto = :idProducto AND id_tienda = :idTienda";
$stmt = $db->prepare($query);
$stmt->bindParam(':nuevoStock', $nuevoStock);
$stmt->bindParam(':idProducto', $idProducto);
$stmt->bindParam(':idTienda', $idTienda);
$stmt->execute();

?>

<style>
    .mensaje-actualizacion {
        display: block;
        text-align: center;
        font-size: 24px;
        margin-top: 20px;
    }
</style>

<?php
if ($stmt->rowCount() > 0) {
    echo "<span class='mensaje-actualizacion'>Stock actualizado correctamente.</span>";
} else {
    echo "<span class='mensaje-actualizacion'>No se pudo actualizar el stock.</span>";
}
?>

<style>
    .btn-volver {
        display: block;
        margin: 0 auto;
        width: 150px;
        text-align: center;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .btn-volver:hover {
        background-color: #45a049;
    }
</style>

<a href="../admin_index.php" class="btn-volver">Volver Inicio</a>
