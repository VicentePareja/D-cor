<?php
require("../config/conexion.php");
include('../templates/header.html');

if (isset($_GET['id_compra'])) {
    $id_compra = $_GET['id_compra'];

    // Consulta del despacho
    $queryDespacho = $db->prepare("SELECT fecha_entrega, direccion_despacho FROM despachos WHERE id = :id_compra");
    $queryDespacho->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
    $queryDespacho->execute();
    $despacho = $queryDespacho->fetch(PDO::FETCH_ASSOC);

    // Consulta de la dirección de despacho
    $queryDireccion = $db->prepare("SELECT DISTINCT Direcciones.calle AS calle, Direcciones.numero AS numero
                                   FROM Clientes
                                   JOIN DireccionCliente ON Clientes.id = DireccionCliente.id_cliente
                                   JOIN Direcciones ON DireccionCliente.id_direccion = Direcciones.id
                                   JOIN CompraCliente ON Clientes.id = CompraCliente.id_cliente
                                   WHERE CompraCliente.id_compra = :id_compra");
    $queryDireccion->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
    $queryDireccion->execute();
    $direccion = $queryDireccion->fetch(PDO::FETCH_ASSOC);

    if ($despacho) {
        echo "<h2>Información del despacho</h2>";
        echo "<p>ID Compra: " . $id_compra . "</p>";
        echo "<p>Fecha de despacho: " . $despacho['fecha_entrega'] . "</p>";
        echo "<p>Dirección de despacho: " . $direccion['calle'] . " " . $direccion['numero'] . "</p>";

        echo '<a href="../client_index.php"><button>Ver mis compras</button></a>';
    } else {
        echo "<p>No se encontró información de despacho para la compra especificada.</p>";
    }
} else {
    echo "<p>Se requiere un ID de compra válido para ver la información del despacho.</p>";
}
?>
