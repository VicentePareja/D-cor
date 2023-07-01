<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    require("../config/conexion.php");
    include('../templates/header.html');

    $query = "SELECT * FROM usuarios ORDER BY id;";
    $result = $db2 -> prepare($query);
    $result -> execute();
    $usuarios = $result -> fetchAll();
?>

<head>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>

    <body>
        <table class='table'>
            <thead>
                <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Region</th>
                <th>Password</th>
                <th>Tipo</th>
                <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usuarios as $usuario) {
                    echo "<tr> 
                        <td>$usuario[0]</td> 
                        <td>$usuario[1]</td> 
                        <td>$usuario[2]</td> 
                        <td>****</td> 
                        <td>$usuario[4]</td>
                        <td>
                            <a href='editar.php?id=$usuario[0]'>Editar</a> |
                            <a href='eliminar.php?id=$usuario[0]'>Eliminar</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
        <footer>
            <p>
            </p>
        </footer>

    </body>
</html>
