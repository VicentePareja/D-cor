<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../config/conexion.php");
include('../templates/header.html');

$nuevoDescuento = $_POST['nuevo_descuento'];
$idProducto = $_POST['id_producto'];
$idTienda = $_POST['id_tienda'];

// Validar y sanitizar los datos si es necesario

$query = "SELECT update_discount(:nuevoDescuento, :idProducto, :idTienda) AS mensaje";
$stmt = $db->prepare($query);
$stmt->bindParam(':nuevoDescuento', $nuevoDescuento);
$stmt->bindParam(':idProducto', $idProducto);
$stmt->bindParam(':idTienda', $idTienda);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result && isset($result['mensaje'])) {
    echo "<span class='mensaje-actualizacion'>" . $result['mensaje'] . "</span>";
} else {
    echo "<span class='mensaje-actualizacion'>Error al ejecutar el procedimiento almacenado.</span>";
}
?>

<head>
<link rel="stylesheet" type="text/css" href="../styles/style.css">
</head>
<a href="../admin_index.php" class="btn-volver">Volver Inicio</a>