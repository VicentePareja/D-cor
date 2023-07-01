<?php
require("../config/conexion.php");
include('../templates/header.html');

if (isset($_GET['id_compra'])) {
    $id_compra = $_GET['id_compra'];

    $query = $db->prepare("SELECT fecha_entrega FROM despachos WHERE id = $id_compra");
    $query->bindParam(1, $id_compra);
    $query->execute();
    $despacho = $query->fetch(PDO::FETCH_ASSOC);

    $user = $SESSION['id']
    $query_2 = $db->prepare("SELECT fecha_entrega FROM despachos WHERE id = $id_compra");
    $query_2->bindParam(1, $user);
    $query_2->execute();
    $despacho = $query->fetch(PDO::FETCH_ASSOC);

    if ($despacho) {
        echo "<h2>Información del despacho</h2>";
        echo "<p>ID Compra: " . $id_compra . "</p>";
        echo "<p>Fecha de despacho: " . $despacho['fecha_entrega'] . "</p>";
        echo "<p>Dirección de despacho: " . $despacho['direccion_despacho'] . "</p>";

        echo '<a href="../client_index.php"><button>Ver mis compras</button></a>';
    } 
} else {
    echo "<p>Se requiere un ID de compra válido para ver la información del despacho.</p>";
}
?>

