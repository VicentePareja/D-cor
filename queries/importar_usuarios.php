<?php
// Nos conectamos a las bdds
require("../config/conexion.php");
include('../templates/header.html');

try {
    // Verificar si los usuarios ya están importados
    $queryVerificarImportados = "SELECT COUNT(*) FROM usuarios";
    $result = $db2->prepare($queryVerificarImportados);
    $result->execute();
    $row = $result->fetch();
    $usuariosImportados = $row['count'];

    if ($usuariosImportados > 0) {
        echo "<div class='container'>
              <h3>Los usuarios ya están importados</h3>
              <a class='btn' href='../index.php'>Volver</a>
            </div>";
    } else {
        // Los usuarios no están importados, realizar la importación
        // Primero obtenemos todos los clientes de la tabla que queremos agregar
        $query = "SELECT * FROM clientes ORDER BY id;";
        $result = $db2->prepare($query);
        $result->execute();
        $clientes = $result->fetchAll();

        // Crear o verificar la existencia del usuario ADMIN
        $queryCrearAdmin = "SELECT crear_usuario_admin()";
        $result = $db2->prepare($queryCrearAdmin);
        $result->execute();

        // Convertir clientes en usuarios de tipo "Cliente"
        $queryConvertirClientes = "SELECT convertir_clientes_a_usuarios()";
        $result = $db2->prepare($queryConvertirClientes);
        $result->execute();

        // Redireccionar o mostrar mensaje de éxito
        header('Location: ../index.php?import_success=true');
        exit();
    }
} catch (Exception $e) {
    // Mostrar mensaje de error
    echo "Error al importar usuarios: " . $e->getMessage();
}
?>
